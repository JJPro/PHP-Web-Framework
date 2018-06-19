<?php
namespace Core;

/**
* View
*/
class View
{
  /**
  * Render a view/template file
  *
  * @param string $view  The view template file
  *
  * @return void
  */
  public static function render($view, $assigns = [])
  {
    /*
    $file = "../App/Views/$view";

    if (is_readable($file)) {
      require $file;
    } else {
      echo "$file not found";
    }
    */
    static $twig = null;

    $backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 2);
    console_log($backtrace, 'backtrace of View::render');
    $callee_controller = $backtrace[1]['class'];
    console_log($callee_controller, 'callee controller ');
    if (preg_match('/\\\\(\w+)$/', $callee_controller, $matches)){
      $controller_name = $matches[1];
      $templates_dir = "../App/Templates";

      if (!$twig) {
        console_log("no twig");
        $loader = new \Twig_Loader_Filesystem($templates_dir);
        $twig = new \Twig_Environment($loader);
      }
      $twig->display("$controller_name/$view.twig", $assigns);
    } else {
      echo "$view_file_path not found";
    }
  }
}
 ?>
