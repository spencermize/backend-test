<template>
	<article v-if="book" class="row">
		<h1 class="col-12">{{ book.Title }}</h1>
		<h2 class="col-12 text-muted">{{ book.Author}}</h2>
		<img :src="book.ThumbnailURL" :alt="`${book.Title} cover`" class="col-2" />
		<p class="pt-3 col-10">
			{{ book.Description }} <br />
			<small><strong class="mr-1">Published:</strong>{{ book.PublicationDate }}</small> <br />
			<small><strong class="mr-1">ISBN-13:</strong>{{ book.ISBN }}</small>
		</p>
	</article>
	<b-spinner v-else variant="success" label="Spinning" style="width: 10rem; height: 10rem;"></b-spinner>
</template>
<script>
import mixins from '../js/mixins.js';
export default {
	mixins: [mixins],
	data: function() {
		return {
			book: null
		}
	},
	async mounted() {
		this.book = await this.getBook();
		this.store.state.nav.push({
			text: this.book.Title,
			to: { path: this.$route.fullPath }
		});	
	},
	methods: {
		async getBook() {
			return this.ajaxRequest(`${this.routes.Book}/${this.$route.params.id}`);
		}		
	},
	destroyed() {
		this.store.state.nav.pop();
	}
}
</script>