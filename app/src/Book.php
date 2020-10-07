<?php
namespace Vendor\Booker;
use SilverStripe\ORM\DataObject;

class Book extends DataObject {
	private static $db = [
		'PublicationDate'	=> 'Date',
		'Title'				=> 'Text'
	];

	private static $api_access = [
        'view' => ['Title', 'PublicationDate'],
        'edit' => ['Title', 'PublicationDate']
    ];
}