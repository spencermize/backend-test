<template>
	<div class="col-12">
		<div v-if="store.state.activeList">
			<div class="row my-3">
				<div class="row col-12">
					<b-button-group v-if="!adding && store.state.activeList.Books.length >= 2">
						<b-button variant="primary" @click="sort('Author')">Sort by Author</b-button>
						<b-button variant="primary" @click="sort('Title')">Sort by Title</b-button>
						<b-button variant="success" @click="saveOrder">{{saving ? 'Saving...' : 'Save Current List Order' }}</b-button>
					</b-button-group>
					<b-button-group v-if="!adding" class="mx-1">
						<b-button variant="success" @click="adding = !adding">Add New Book</b-button>
					</b-button-group>
				</div>
				<div class="row col-12"><em>Tip: You can drag / drop the book order as well!</em></div>
				<div class="col-6 row">
					 <b-form-group
					  	v-if="adding" 
						class="col-12"
						id="searchGroup"
						label="Add a book to your list"
						description="Source any book Google Books recognizes"
					>
						<b-form-input v-model="query" type="text" placeholder="Enter a book title or author..." ></b-form-input>
					 </b-form-group>
					<b-button class="col-12 col-lg-4 mx-3" v-if="adding" @click="adding = false" variant="primary">Done Adding</b-button>
					<b-spinner class="mx-1" label="Spinning" v-if="searching"></b-spinner>
				</div>
			</div>
			<div class="col-12" v-if="results && adding">
					<book-card
						v-for="book in results.items"
						:key="book.id"					
						:bookID="book.id"				
						:pubDate="book.volumeInfo.publishedDate"
						:addList="store.state.activeList.ID"
						:title="book.volumeInfo.title"
						:ISBN="getISBN(book)"
						:author="book.volumeInfo.authors ? book.volumeInfo.authors.join(', ') : ''"
						:thumbnail="book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : ''"
						:description="getDescription(book)"
					></book-card>				
			</div>
			<div class="col-12" v-if="!adding">
				<draggable v-model="store.state.activeList.Books" draggable="article">
					<book-card 
						v-for="book in store.state.activeList.Books"
						:key="book.id"
						:bookID="book.id"				
						:pubDate="store.bookList[book.id] ? store.bookList[book.id].PublicationDate : ''"
						:author="store.bookList[book.id] ? store.bookList[book.id].Author : ''"
						:trashList="store.state.activeList.ID"
						classList="draggable"
						:title="store.bookList[book.id] ? store.bookList[book.id].Title : ''"
						:thumbnail="store.bookList[book.id] ? store.bookList[book.id].ThumbnailURL : ''"
						:description="store.bookList[book.id] ? store.bookList[book.id].Description : ''"
						:detail="true"
					></book-card>
				</draggable>					
			</div>	
		</div>
		 <b-skeleton-wrapper v-else :loading="true">
			<template v-slot:loading>
				<b-card 
					v-for="n in 5" 
					:key="n" 
					class="mb-3" 
					img-left 
					:img-src="bookshelfImg">
					<b-skeleton width="85%"></b-skeleton>
					<b-skeleton width="55%"></b-skeleton>
					<b-skeleton width="70%"></b-skeleton>
					<b-skeleton width="70%"></b-skeleton>
				</b-card>
			</template>
   		</b-skeleton-wrapper>
	</div>	
</template>
<script>
import mixins from '../js/mixins.js';
import bookshelfImg from '../js/bookshelfImg.js';
import draggable from 'vuedraggable';
import BookCard from './BookCard';
export default {
	mixins: [mixins],
	components: {
		draggable,
		BookCard
	},	
	data: function() {
		return {
			bookshelfImg,
			adding: false,
			searching: false,
			saving: false,
			query: '',
			search: null,
			results: null,
			order: 1
		}
	},
	watch: {
		query: function() {
			this.search();
		}
	},
	async mounted() {
		let retry = window.setInterval(() => {
			if ( this.store.lists.items ) {
				this.store.state.activeList = this.store.lists.items.filter(list => list.ID == this.$route.params.id)[0];
				this.loadBooks();
				if (this.store.state.nav.filter(item => item.to.path === this.$route.fullPath).length === 0){
					this.store.state.nav.push({
						text: this.store.state.activeList.Title,
						to: { path: this.$route.fullPath }
					});
				}
				clearInterval(retry)
			}
		}, 250);
	},
	async created() {	
		this.search = debounce(() => {
			this.googleBooks();
		}, 1000)		
	},
	destroyed() {
		if (this.$route.path == "/"){
			this.store.state.nav.pop();
			this.store.state.activeList = false;
		}
	},
	methods: {
		sort(type) {
			this.store.state.activeList.Books.sort( (a, b) => {
				const aBook = this.store.bookList[a.id];
				const bBook = this.store.bookList[b.id];
				this.order = this.order * -1;
				if (aBook[type] === bBook[type]) {
					return 0;
				}

				if(aBook[type] < bBook[type]) {
					return -1 * this.order;
				}

				if(aBook[type] > bBook[type]) {
					return 1 * this.order;
				}				
			});
		},
		getDescription(book){
			return book.volumeInfo.description && book.volumeInfo.description.length >= 250 ? `${book.volumeInfo.description.substr(0, 250)}...` : book.volumeInfo.description;
		},
		getISBN(book){
			if (book.volumeInfo.industryIdentifiers) {
				const ISBN = book.volumeInfo.industryIdentifiers.filter(ident => ident.type == "ISBN_13");
				return ISBN ? ISBN[0] && Number(ISBN[0].identifier) : 0;
			}
		},
		async loadBooks(){
			if (this.store.state.activeList.Books.length) {
				for(let i=0; i<this.store.state.activeList.Books.length; i++){
					const book = this.store.state.activeList.Books[i];
					if (!this.store.bookList[book.id]){
						this.store.bookList[book.id] = await this.ajaxRequest(`${this.routes.Book}/${book.id}`);
						this.$forceUpdate();
					}
				}
			} else {
				this.adding = true;
			}

		},
		async saveOrder(){
			this.saving = true;
			const options = {
				method: 'POST',
				body: this.optionsToParams({
					list: this.store.state.activeList.ID,
					books: this.store.state.activeList.Books.map(book => book.id).join(',')
				}),
			}
			await this.ajaxRequest(`${this.routes.ListUpdate}/reorder`, '', options);
			this.saving = false;
		},
		async googleBooks() {
			this.searching = true;
			this.results = await this.ajaxRequest(`${this.routes.GoogleBooks}/volumes`, `q=${this.query}&key=${GOOGLE_API}` );
			this.searching = false;
		}		
	}
}

// Courtesy: https://davidwalsh.name/javascript-debounce-function
function debounce(func, wait, immediate) {
	let timeout;
	return function() {
		let context = this, args = arguments;
		let later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		let callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}
</script>