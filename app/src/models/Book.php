<?php
namespace Spencer\Booker;
use SilverStripe\ORM\DataObject;

class Book extends DataObject {
	private static $db = [
		'PublicationDate'	=> 'Varchar', // Would generally want to use a date field, but Google Books dates appear to nonstandardized (year only, often) and I don't want to assign an arbitary date when innaccurate
		'Title'				=> 'Varchar',
		'Description'		=> 'Text',
		'Author'			=> 'Text',
		'ThumbnailURL'		=> 'Varchar',
		'ISBN'				=> 'Varchar'
	];

	private static $belongs_many_many = [
		"BookLists" => BookList::class,
	];

	private static $indexes = [
		'ISBNIndex'			=> [
			'type'				=> 'unique',
			'columns'			=> ['ISBN']
		]
	];

	private static $searchable_fields = [
		'ISBN'
	];

	private static $api_access = true;

    public function validate() {
        $result = parent::validate();

		if (!$this->Title) {
			$result->addError('Please ensure you have a valid title.');
		} else if (!$this->ISBN || strlen($this->ISBN) != 13) {
			$result->addError('Please ensure you have a valid ISBN-13.');
		}

		return $result;
	}
	private static $table_name = 'Book';
}