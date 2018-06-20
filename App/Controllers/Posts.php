<?php
namespace App\Controllers;
use App\Models\Post;
/**
* Posts controller
*
* PHP version 7.2
*/
class Posts extends \Core\Controller
{

  /**
  * Show the index page
  *
  * @return void
  */
  protected function index()
  {
    $posts = Post::getAll();
    \Core\View::render("index.html", ['posts' => $posts]);
  }

  /**
  * Show the new post creation page
  *
  * @return void
  */
  protected function new()
  {
    echo "Showing /posts/new";
  }

  /**
  * Show the edit page
  *
  * @return void
  */
  protected function edit()
  {
    echo "Showing /posts/{$this->route_params['id']}/edit";
    console_log($this->route_params, "route_params of Posts.php");
  }
}
?>
