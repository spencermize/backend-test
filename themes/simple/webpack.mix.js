/* eslint-env node */
const webpack = require('webpack');
const mix = require('laravel-mix');
require('dotenv').config();

mix.options({
	extractVueStyles: 'dist/vue.css'
});

mix
	.sass('src/scss/app.scss', 'css')
	.js('src/js/app.js', 'javascript')
	.extract()
	.babel(['javascript/app.js'], 'javascript/app-es5.js');

let config = {
	plugins: [
		new webpack.DefinePlugin({
			PRODUCTION: JSON.stringify(mix.inProduction()),
			GOOGLE_API: JSON.stringify(process.env.GOOGLE_API)
		})	
	]
};

mix.webpackConfig(config);