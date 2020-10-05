# Reading List
## Task
Fork this repository and add functionality that allows the user to create a list of books they would like to read. This repository provides a base Silverstripe installation that will serve as the foundation of your project.

Users should be able to perform the following actions:
* Add or remove books from the list
* Change the order of the books in the list
* Sort the list of books by their author
* Display a book detail page with a minimum of author, publication date, and title

Please use the Silverstripe ORM (https://docs.silverstripe.org/en/4/developer_guides/model/data_model_and_orm/) rather than crafting queries by hand.

To submit your test, please commit all work to the `master` branch of your fork and send us a link to your forked repository.

### Project Setup
* You need a local web server and MySQL instance. We use MAMP, which provides both, but please use whatever you're comfortable with.
* Point your web server at the `/public` directory in this project.
* Install composer (see https://getcomposer.org/doc/00-intro.md). After installation, run `composer install` in the project root directory to install the project dependencies like the framework.
	* See Silverstripe documentation about Composer for more information: https://docs.silverstripe.org/en/4/getting_started/composer/
* Copy the `.env.example` file to `.env` and update MySQL credentials in the `.env` file to match your local username/password (it comes set to root:root). You may also need to adjust the database server depending on your local setup.
* To load the site up in the browser and build the database go to `http://localhost:8888/dev/build?flush=all` (or equivalant for your local environment).
* You should now have a working site at `http://localhost:8888`
* See this documentation for further details https://www.silverstripe.org/learn/lessons/v4/up-and-running-setting-up-a-local-silverstripe-dev-environment-1

### Silverstripe Documentation
* Adding a table to the database: https://www.silverstripe.org/learn/lessons/v4/introduction-to-the-orm-1
* Adding a new page/controller: https://www.silverstripe.org/learn/lessons/v4/the-holderpage-pattern-1
* Outputting content to the page: https://www.silverstripe.org/learn/lessons/v4/adding-dynamic-content-1
* More lessons here: https://docs.silverstripe.org/en/4/lessons/

### Bonus Points!
* Add CMS controls for an admin to manage the books via a `ModelAdmin` subclass (https://www.silverstripe.org/learn/lessons/v4/introduction-to-modeladmin-1).
* Deploy it for real so we can play with it! (and then tell us about how you deployed it)
* Handle image uploading while adding books to the list
* Do something fancy like integrating an external API
* Make the frontend responsive
* On the frontend, use the Bootstrap 4 library
