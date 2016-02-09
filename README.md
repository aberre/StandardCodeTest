VG StandardCodeTest
=======

**Candidate:** 2129798



## Installation guide


# 1. Clone the repo

```
git clone git@github.com:2129798/StandardCodeTest.git
```

# 2. Create a VirtualHost-block to point to the web/ folder of the project (be sure that apache is sett to AllowOverride All, if not put the content of web/.htaccess in your VirtualHost-block.

# 3. Install composer into the project (if you dont have it allready global installed)

```
curl -sS https://getcomposer.org/installer | php
```

# 4. Run the composer install commando to set up the app
```
php composer.phar install
```

# 5. Follow the instructions on the screen

# 6. You are now all set to view the app

