let mixins = {
	data: function () {
		return {
			routes: {},
			store: window.store,
			name: 'Booker'					
		};
	},
	methods: {
		async ajaxRequest(route, params, opts) {
			const headers = new Headers();
			headers.append('Accept', 'application/json');

			const options = Object.assign({
				method: 'GET',
				headers,
			}, opts);

			try {
				const resp = await fetch(`${route}?${params || ''}`, options);
				if (resp.status >= 200 && resp.status <= 299) {
					return await resp.json();
				} else {
					throw Error(resp.statusText);
				}
			} catch (err) {
				console.log(err);
			}
		},
		optionsToParams(options) {
			// Courtesy: https://formcarry.com/documentation/fetch-api-example
			return Object.keys(options)
				.map(key => encodeURIComponent(key) + '=' + encodeURIComponent(options[key]))
				.join('&');	
		}
	},
	created() {
		const namespace = '/api/v1/Spencer-Booker-';
		const routes = {
			Book: 'Book',
			BookList: 'BookList',
		};

		Object.keys(routes).forEach(route => {
			this.routes[route] = namespace + routes[route];
		});

		this.routes.ListUpdate = '/listupdates';
		this.routes.GoogleBooks = 'https://www.googleapis.com/books/v1';
	}
};

export default mixins;
