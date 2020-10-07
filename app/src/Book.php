<?php
namespace Vendor\Booker;
use SilverStripe\ORM\DataObject;

class Book extends DataObject {
	private static $db = [
		'PublicationDate'	=> 'Date',
		'Title'				=> 'Varchar'
	];

	private static $has_one = [
		'Author'			=> Author::class
	];

	private static $api_access = [
        'view' => ['Title', 'PublicationDate'],
        'edit' => ['Title', 'PublicationDate']
    ];

	private static $table_name = 'Book';
}