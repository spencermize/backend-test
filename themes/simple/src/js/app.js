import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

// Now, on to the show!
if (!window.location.href.includes('/Security/login')) {
	// We *should* have a PHP session (required to establish ownership of BookLists), because HomePage requires login.
	};

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

		}
	});
}