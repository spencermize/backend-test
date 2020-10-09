<?php 
namespace Spencer\Booker;
use SilverStripe\Admin\ModelAdmin;

class AuthorAdmin extends ModelAdmin {

	private static $managed_models = [
		Author::class
	];

	private static $url_segment = 'authors';
	private static $menu_title = 'Authors';
	private static $menu_icon_class = 'font-icon-torsos-all';
}