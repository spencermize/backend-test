<?php
namespace Spencer\Booker;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\ORM\DataObject;

class BookList extends DataObject {
	private static $api_access = true;
	private static $table_name = 'BookList';
	
	private static $db = [
		'ListName'		=> 'Varchar',
		'Member'		=> 'Int'
	];

	public function populateDefaults() {
		$this->Member = Security::getCurrentUser()->ID;
		parent::populateDefaults();
	}

	private static $many_many = [
		"Books" => Book::class,
	];


	public function canView($member = null) {
		$user = Security::getCurrentUser();
		if ($user && $user->ID && $user->ID === $this->Member) {
			return true;
		} else {
			return false;
		}
	}
}
