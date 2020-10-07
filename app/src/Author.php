<?php
namespace Vendor\Booker;
use SilverStripe\ORM\DataObject;

class Author extends DataObject {
	private static $db = [
		'FirstName'		=> 'Varchar',
		'LastName'		=> 'Varchar'
	];

	private static $has_many = [
		'Books'			=> Book::class
	];

	private static $api_access = true;
	private static $table_name = 'Author';

	public function getFullName() {
		return $this->FirstName . ' ' . $this->LastName;
	}
}