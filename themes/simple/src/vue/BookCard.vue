<template>
	<b-card
		:img-src="thumbnail"
		img-alt="Book Image"
		tag="article"
		img-left	
		:title="title"
		:class="`${classList} mb-3`"
		:sub-title="author"
	>
		<b-card-text>{{ description }} </b-card-text>
		<b-button-group>
			<b-button v-if="trashList" variant="danger" class="mx-1" aria-label="trash" @click="remove()"><b-icon icon="trash"></b-icon></b-button>
			<b-button v-if="detail" :to="`/books/${bookID}`" variant="primary" class="mx-1"><b-icon icon="arrow-right-square"></b-icon></b-button>
			<b-button v-if="addList && !added" variant="success" @click="add()"><b-icon icon="plus"></b-icon></b-button>
			<b-button v-if="addList && added" :disabled="added"><b-icon icon="plus"></b-icon></b-button>			
		</b-button-group>
	</b-card>
</template>

<script>
import mixins from '../js/mixins.js';
export default {
	props: {
		bookID: String|Number,
		title: String,
		pubDate: String,
		author: String,
		description: String,
		trashList: Number,
		addList: Number,
		classList: String,
		thumbnail: String,
		detail: Boolean,
		ISBN: Number
	},
	data:  function() {
		return {
			added: false
		}
	},
	mixins: [mixins],
	methods: {
		async remove(){
			await this.modifyServerList(this.bookID, this.trashList, 'DELETE');
			this.store.state.activeList.Books = this.store.state.activeList.Books.filter(book => this.bookID != book.id);
		},
		async add() {
			let existing = await this.getBookByISBN(this.ISBN);

			if (existing.totalSize === 0) {
				const results = await this.createBook();
				existing = await this.getBookByISBN(this.ISBN);
			}
			const dbID = existing.items[0].ID; // We'll just assume the database search works perfectly.
			this.store.state.activeList.Books.push({
				id: dbID
			});
			this.added = true;
			this.store.bookList[dbID] = existing.items[0];

			this.modifyServerList(dbID, this.addList, 'POST');			
		},
		async modifyServerList(book, list, method) {
			const options = {
				method,
				body: this.optionsToParams({
					list,
					book
				}),
			}
			return this.ajaxRequest(this.routes.ListUpdate, '', options);
		},
		async createBook() {
			const newBook = {
				Title: this.title,
				Description: this.description,
				Author: this.author,
				ThumbnailURL: this.thumbnail,
				PublicationDate: this.pubDate,
				ISBN: this.ISBN
			}
			const options = {
				body: this.optionsToParams(newBook),
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'Accept': 'application/json'
				},
				method: 'POST'
			}
			try {
				await this.ajaxRequest(this.routes.Book, '', options);
				return newBook;
			} catch (e) {
				return null;
			}
		},
		async getBookByISBN(ISBN) {
			return await this.ajaxRequest(this.routes.Book, `ISBN=${ISBN}`);
		}		
	}
}
</script>