VG StandardCodeTest
=======

**Candidate:** 2129798

## Requirements
* SQL-database
* PHP >=5.3.9

## Installation guide


Clone the repo

```
git clone git@github.com:2129798/StandardCodeTest.git
```

Create a VirtualHost-block to point to the web/ folder of the project (be sure that apache is sett to AllowOverride All, if not put the content of web/.htaccess in your VirtualHost-block.

Install composer into the project (if you dont have it allready global installed)

```
curl -sS https://getcomposer.org/installer | php
```

Create an database for the app, you will be prompted for connection details in the next step

Run the composer install commando to set up the app
```
php composer.phar install
```

Follow the instructions on the screen

You are now all set to view the app


## Testing

To run test the App type following in the root of the app

```
phpunit -c app
```
