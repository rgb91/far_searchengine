# FAR Search Engine

## Search engine built on Sphinx

* Server Scripts : PHP (Codeigniter Framework)
* Database       : MySQL


___
                      **INSTALLATION**
___

You need to change two files only:
* **./application/config/database.php**
	:: put all the database credentials here correctly

* **./application/config/config.php**
	:: change the *base_url* as required

___

* **Login:**
	:: email : mail_sanjaysaha@yahoo.com
	:: pass  : sanjay

* **Register:**
	:: Register with correctly filled up form

___


* **Database(SQL) files directory: /far/sql/**
* **Sphinx Configuration file directory: /far/sphinx/**

___


**Note:**

* If the Sphinx API is not installed with the PHP service,
put the Sphinx API file (sphinxapi.php) in the following directory:
**./application/controller/**

* After adding the API file in the controller directory, check if the following code is present in the search.php in the same folder after line number 1. If not, add this line at after line number 1:

`require 'sphinxapi.php';`

* The Database needs to be indexed by sphinx indexer, otherwise the application will not provide any search result.

* **How to index database & run sphinx**: change the indexed data location(s) & the database credentials as your pc in the sphinx.conf file. Then run the command `indexer <index_name>` to index. Now from the sphinx installation directory, run the command `searchd` to start the search server. You need to run the indexer for only once but searchd has to be run every time the pc is restarted. You can add this to your startup programs to start it when your pc boots.

___

