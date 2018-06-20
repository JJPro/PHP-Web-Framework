<?php
namespace App\Models;
use PDO;
/**
 * The Post Model
 */
class Post extends \Core\Model
{
  /**
  * Get all the posts as an asociative array
  *
  * @return array
  */
  public static function getAll()
  {
    try {
      $db = self::getDB();
      $stmt = $db->query('SELECT * from posts ORDER BY created_at');
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $posts;

    } catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
}

 ?>
