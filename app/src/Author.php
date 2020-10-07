<?php
namespace Vendor\Booker;
use SilverStripe\ORM\DataObject;

class Author extends DataObject {
	private static $db = [
		'FirstName'		=> 'Date',
		'LastName'		=> 'Text'
	];

	private static $has_many = [
		'Books'			=> Book::class
	];

	private static $api_access = true;
}