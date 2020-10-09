import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

// This section is totally janky and a security nightmare, but because the SilverStripe RESTful API plugin I found doesn't allow for token authentication, I have to save the Base64 password for the user.
// Improvements could include building a proper tokenization system or (assuming users stay as proper Members), modifying the RESTful API plugin to recognize the PHP session.
window.onload = () => {
	if (document.getElementById('MemberLoginForm_LoginForm')) {
		document.getElementById('MemberLoginForm_LoginForm').addEventListener('submit', (_ev) => {
			const email = document.getElementById('MemberLoginForm_LoginForm_Email');
			const password = document.getElementById('MemberLoginForm_LoginForm_password');
			window.localStorage.setItem('creds', btoa(`${email}:${password}`));
		});
	}

};

if (!window.location.href.includes('/Security/login') && !window.localStorage.getItem('creds')) { // No proper cached credentials
	window.location = '/Security/logout?BackURL=/Security/login%3FBackURL=home';
	// window.location = '/Security/login?BackURL=home';
}

if (window.location.href.includes('/Security/logout')) { // "Log out"
	window.localStorage.removeItem('creds');
}

// Now, on to the show!
// We *theoretically* should have both a PHP session (required to establish ownership of BookLists) and cached passwords (required to use the REST API)
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
			login: window.localStorage.getItem('creds'),
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
			headers.append('Authorization', `Basic ${this.login}`);

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

function getCookie(cname) {
	var name = cname + '=';
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	}
	return '';
}