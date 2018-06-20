<?php
namespace App\Controllers;
use Core\{View, Controller};

/**
* Home controller
*
* PHP version 7.2
*/
class Home extends Controller
{
  /**
  * Show the index page
  *
  * @return void
  */
  protected function index()
  {
    View::render('index.html', [
      'hi' => "hi2",
      'colors' => ['red', 'blue', 'green'],
    ]);
  }
}
?>
