<?php 
namespace Spencer\Booker;
use SilverStripe\Admin\ModelAdmin;

class BookListAdmin extends ModelAdmin {

	private static $managed_models = [
		BookList::class
	];

	private static $url_segment = 'books-list';
	private static $menu_title = 'Book List';
	private static $menu_icon_class = 'font-icon-block-file-list';
}