<b-navbar toggleable="lg" type="dark" variant="primary" class="mb-3">
	<div class="container">
		<b-navbar-brand href="$BaseHref" class="brand" rel="home">
			<span
				>$SiteConfig.Title <% if $SiteConfig.Tagline %>
				<small>$SiteConfig.Tagline</small>
				<% end_if %>
			</span>
		</b-navbar-brand>

		<b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
		<b-collapse id="nav-collapse" is-nav>
			<b-navbar-nav class="ml-auto">
				<ul class="navbar-nav mr-auto">
					<% loop $Menu(1) %>
					<b-nav-item class="$LinkingMode" href="$Link"
						>$Title.XML</b-nav-item
					>
					<% end_loop %>
				</ul>
			</b-navbar-nav>
		</b-collapse>
	</div>
</b-navbar>