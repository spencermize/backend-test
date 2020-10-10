<div class="content-container unit size3of4 lastUnit row">
	<article v-if="store.lists.totalSize === 0">
		<div class="content">$Content</div>
	</article>
	<b-breadcrumb class="col-12" :items="store.state.nav"></b-breadcrumb>
	<transition name="slide">
		<router-view></router-view>	
	</transition>
</div>