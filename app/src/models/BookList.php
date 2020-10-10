<?php
namespace Spencer\Booker;
use SilverStripe\Security\Permission;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Security\Security;
use SilverStripe\ORM\DataObject;

class BookList extends DataObject {
	private static $api_access = true;
	private static $table_name = 'BookList';
	
	private static $db = [
		'Title'			=> 'Varchar',
		'Member'		=> 'Int'
	];

	public function populateDefaults() {
		$this->Member = Security::getCurrentUser()->ID;
		parent::populateDefaults();
	}

	private static $many_many = [
		"Books" => Book::class,
	];

    private static $many_many_extraFields = [
        "Books" => [
        	"Order" => 'Int'
        ]
    ];
	public function canView($member = null) {
		return $this->hasListPerms($member);
	}

	public function canEdit($member = null) {
		return $this->hasListPerms($member);
	}
	public function canCreate($member = null, $context = []) {
		return true;
	}
	public function canDelete($member = null) {
		return $this->hasListPerms($member);
	}

	private function hasListPerms($member) {
		$user = Security::getCurrentUser();
		if ($user && $user->ID && $user->ID === $this->Member) {
			return true;
		} else {
			return false;
		}
	}
}
