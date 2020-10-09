<?php
namespace Spencer\Booker;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\ORM\DataObject;

class BookList extends DataObject {
	private static $db = [
		'ListName'		=> 'Varchar',
		'Member'		=> 'Int'
	];

	// public function populateDefaults() {
	// 	$this->Member = Security::getCurrentUser()->$ID;
	// 	parent::populateDefaults();
	// }

	private static $many_many = [
		"Books" => Book::class,
	];

	private static $api_access = true;
	private static $table_name = 'BookList';

	public function canView($member = null) {
		return true;
	}
}