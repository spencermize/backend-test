# Reading List

## Task
Fork this repository and add functionality that allows the user to create a list of books they would like to read.

Users should be able to perform the following actions:

* Add or remove books from the list
* Change the order of the books in the list
* Sort the list of books by their author
* Display a book detail page with a minimum of author, publication date, and title

Please use the ORM rather than crafting queries by hand.

To submit your test please commit all work to the master branch of your fork and send us a link to your forked repository.

##### Project Setup
* You need a local dev environment (we use MAMP but whatever you are comfortable with)
* Point your vhost at the /public folder in this project
* Installing Composer:
	* `$ curl -s https://getcomposer.org/installer | php`
	* `$ sudo mv composer.phar /usr/local/bin/composer`
	* See SilverStripe documentation about Composer for more information https://docs.silverstripe.org/en/4/getting_started/composer/
	* In your project directory run `composer install` to load all required packages
* Update MySQL credentials in the .env file to match your local username/password (it comes set to root:root)
* To load the site up in the browser and build the database go to `http://localhost:8888/dev/build?flush=all` (or equivalant for your local env)
* You should now have a working site at `http://localhost:8888`
* See this documentation for further details https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1

##### SilverStripe Documentation
* Adding a table to the database: https://www.silverstripe.org/learn/lessons/v4/introduction-to-the-orm-1
* Adding a new page/controller: https://www.silverstripe.org/learn/lessons/v4/the-holderpage-pattern-1
* Outputting content to the page: https://www.silverstripe.org/learn/lessons/v4/adding-dynamic-content-1
* More lessons here: https://docs.silverstripe.org/en/4/lessons/

##### Bonus points!
* Deploy it for real so we can play with it! (and then tell us about how you deployed it)
* Handle image uploading while adding books to the list
* Do something fancy like integrating an external API or handling user authentication
* Make the frontend responsive
* On the frontend, use the Bootstrap 4 library
