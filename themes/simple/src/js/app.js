/* global GOOGLE_API */
import Vue from 'vue';
import VueRouter from 'vue-router';
import Lists from '../vue/Lists.vue';
import SingleList from '../vue/SingleList.vue';
import SingleBook from '../vue/SingleBook.vue';
import mixins from './mixins.js';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

// Now, on to the show!
if (!window.location.href.includes('/Security/login')) {
	// We *should* have a PHP session (required to establish ownership of BookLists), because HomePage requires login
	window.store = {
		state: {
			loading: false,
			activeList: false,			
			error: false,
			nav: [
				{
					text: 'Home',
					to: { path: '/' }
				}
			],			
		},
		lists: [],
		bookList: {},		
	};

	const routes = [
		{ path: '/', component: Lists },
		{ path: '/lists/:id', component: SingleList },
		{ path: '/books/:id', component: SingleBook }
	];
	const router = new VueRouter({
		routes
	});

	new Vue({
		el: '#app',
		router,
		mixins: [mixins],
		data() {
			return {

			};
		},
		async mounted() {
			this.store.lists = await this.ajaxRequest(this.routes.BookList);
		},
		methods: {

		}
	});
}