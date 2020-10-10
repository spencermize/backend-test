<template>
	<div class="col-12">
		<b-form @submit="newList" class="row mb-3">
			<b-form-input class="col-6" v-model="newListTitle" type="text" placeholder="Enter a List Name" ></b-form-input>
			<b-button class="ml-3" type="submit" variant="primary">Add New List</b-button>
		</b-form>
		<b-list-group class="row" v-if="store.lists.items">
			<b-list-group-item 
				v-for="list in store.lists.items"
				class="col-6 d-flex justify-content-between align-items-center"
				:to="`/lists/${list.ID}`"
				:key="'item-' + list.ID"
			>
				<div>
					{{ list.Title }}
					<b-badge variant="primary" pill class="ml-1">{{ list.Books.length }}</b-badge>
				</div>
				<div>
					<b-button variant="danger" class="mx-1" aria-label="trash" @click="remove($event, list.ID)"><b-icon icon="trash"></b-icon></b-button>
					<b-button variant="success" class="mx-1"><b-icon icon="arrow-right-square"></b-icon></b-button>
				</div>
			</b-list-group-item>
		</b-list-group>
	</div>
</template>
<script>
import mixins from '../js/mixins.js';
export default {
	mixins: [mixins],
	data: function() {
		return {
			newListTitle: ''
		}
	},
	methods: {
		async newList(e) {
			e.preventDefault();
			const opts = {
				body: this.optionsToParams({Title: this.newListTitle}),
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'Accept': 'application/json'
				}
			}
			this.store.lists.items.push(await this.ajaxRequest(`${this.routes.BookList}`, '', opts));
		},

		async remove(e, id) {
			e.preventDefault();
			const opts = {
				method: 'DELETE'
			}
			await this.ajaxRequest(`${this.routes.BookList}/${id}`, '', opts);
			this.store.lists.items = this.store.lists.items.filter(list => list.ID != id);
		}
	},
	mounted: async function() {
		this.store.state.nav.length = 1;
	}
}
</script>