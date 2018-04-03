<?php
namespace Ezway\Core;

use Ezway\Config\Settings;

/**
 * Manage database. (Only MariaDB on first releases)
 * No ORM cause we want to stay easy.
 */
class Database
{
    /**
     * Connection to database
     * (only mysqli cause only MariaDb. Maybe other database some day)
     * @var mysqli
     */
    private $c = null;

    public function __construct()
    {
        //HERE MANAGE OTHER THAN MARIADB
        $this->c = new \mysqli(Settings::$dbHost, Settings::$dbUser, Settings::$dbPassword, Settings::$dbName, Settings::$dbPort);
        if ($this->c->connect_error) {
            die("ERROR: Unable to connect: " . $this->c->connect_error);
        }
    }

    /**
     * Execute a select query and transform result to array
     *
     * @param string $sql query
     * @return array query result
     */
    public function select(string $sql): array
    {
        $qres = $this->c->query($sql);
        $result = array();
        if ($qres->num_rows > 0) {
            while ($row = $qres->fetch_assoc()) {
                array_push($result, $row);
            }
        }
        return $result;
    }

}
