<?php
namespace Core;
use PDO;
use App\Config;
/**
* abstract Model base class
*/
abstract class Model
{
  /**
  * Get the PDO database connection
  *
  * @return mixed  Returns database object or prints error message
  */
  static public function getDB()
  {
    static $db = null;
    if (!$db) {
      try {
        $host = Config::DB_HOST;
        $dbname = Config::DB_NAME;
        $db = new PDO("mysql:host=$host;dbname=$dbname", Config::DB_USER, Config::DB_PASSWD);

        // Throw Exception when an error occurs
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      } catch (\Exception $e) {
        echo $e->getMessage();
      }
    }
    return $db;
  }
}
 ?>
