# social_network_poo
Social network made with MVC structure in PHP using OOP

## Installing

You require [PHP](https://www.php.net/manual/fr/install.php).

Create a folder and go inner :

```
$ mkdir <choice_your_name>
$ cd ./<choice_your_name>
```

Clone the repository :

```
$ git clone https://github.com/axelmitschidev/tiny-social-network-mvc-php.git .
```

Change your db ids if needed in ./src/models/Db.php :

```
self::$instance = new PDO("mysql:host=localhost;dbname=YOUR_DB_NAME","USERNAME_DB","PASSWORD_DB");
Default : new PDO("mysql:host=localhost;dbname=social_network_cours","root","");
```

Start server and development (with CLI PHP) :

```
$ php -S localhost:<port> -t public
```
