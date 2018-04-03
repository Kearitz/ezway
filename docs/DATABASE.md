# Database management

No ORM implementation on Ezway. ORM is usefull on big project, in little project old school request can manage database.  
[Only MariaDB. Todo: test with MySQL, add postgreSQL. see [Roadmap](ROADMAP.md)]  

## Install 
### MariaDB

- install [MariaDB](https://mariadb.org)  
- install/activate [MySQLi](http://www.php.net/manual/en/mysqli.installation.php)

## Configuration 

Configuration file is src/ezway/Setting : change $db[something] var.   

## Database helper

To use Database, you can use "Ezway\Core\Database" class. 
This class connect and execute your query. 

[Only select. Todo: delete, update. see [Roadmap](ROADMAP.md)]

