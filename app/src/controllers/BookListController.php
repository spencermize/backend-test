<?php

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;

use Spencer\Booker\BookList;
use Spencer\Booker\Book;

class BookListController extends Controller {
    private static $allowed_actions = [
		'reorder',
        'index'
    ];	
	public function index(HTTPRequest $request) {
		$postArray = $this->setup($request);
		$listID = intval($postArray['list']);
		$bookID = intval($postArray['book']);

		$bookList = BookList::get()->byID($listID);
		$book = Book::get()->byID($bookID);

		if ($request->isPOST()) {
			$bookList->Books()->add($book);
		}

		if ($request->isDELETE()) {
			$bookList->Books()->remove($book);
		}

		$bookList->write();
		$this->getResponse()->setBody(json_encode([
			'status' => 'success'
		]));
		return $this->getResponse();
	}

	public function reorder(HTTPRequest $request) {
		$postArray = $this->setup($request);

		$listID = intval($postArray['list']);
		$bookIDs = explode(',', $postArray['books']);

		$bookList = BookList::get()->byID($listID);

		if ($request->isPOST()) {
			$bookList->Books()->removeAll();
			foreach($bookIDs as $key => $bookID) {
				$book = Book::get()->byID($bookID);
				$bookList->Books()->add($book, array(
					"Order" => $key
				));

			}


		}
	}

	private function setup($request){
		$this->setResponse(new HTTPResponse());
		$this->getResponse()->setStatusCode(200);
		$this->getResponse()->addHeader("Content-type", "application/json");

		$body = $request->getBody();
		$postArray = array();
		parse_str($body, $postArray);

		return $postArray;
	}
	
}