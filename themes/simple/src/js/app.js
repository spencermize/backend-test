import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

// Now, on to the show!
if (!window.location.href.includes('/Security/login')) {
	// We *should* have a PHP session (required to establish ownership of BookLists), because HomePage requires login.
	const namespace = '/api/v1/Spencer-Booker-';
	const routes = {
		Author: 'Author',
		Book: 'Book',
		BookList: 'BookList',
	};

	Object.keys(routes).forEach(route => {
		routes[route] = namespace + routes[route];
	});

	new Vue({
		el: '#app',
		data() {
			return {
				name: 'Booker',
				lists: []
			};
		},
		async mounted() {
			this.lists = await this.ajaxRequest(routes.BookList);
		},
		methods: {
			async ajaxRequest(route, method, params) {
				const headers = new Headers();
				headers.append('Accept', 'application/json');

				const options = {
					method: method || 'GET',
					headers
				};

				try {
					const resp = await fetch(`${route}?${params || ''}`, options);
					if (resp.status === 200) {
						return await resp.json();
					} else {
						throw Error(resp.statusText);
					}
				} catch (err) {
					console.log(err);
				}
			}
		}
	});
}