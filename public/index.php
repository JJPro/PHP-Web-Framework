<?php
/**
* Front controller
*/

/**
* Autoloader
*
* Twig,
* my own classes
*/
require_once '../vendor/autoload.php';

/* dealt by composer autoloader
spl_autoload_register(function($class){
  $doc_root = dirname(__DIR__);
  $file = $doc_root . '/' . str_replace('\\', '/', $class) . '.php';

  if (is_readable($file)) {
    require $file;
  }
});
*/

/**
* Error and Exception handling
*/
set_error_handler('\Core\Error::errorHandler');
set_exception_handler('\Core\Error::exceptionHandler');

/**
* Utility - log info to console (browser)
*
* @param $data
* @param string $label
*/
function console_log($data, string $label = '')
{
  $json_data = json_encode($data);
  echo <<<CONSOLE
<script>
  console.log( '$label', $json_data );
</script>
CONSOLE;
}


/**
* Routing
*/
$router = new Core\Router();

// Add routes - fixed routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
// Add routes - dynamic routes
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
$router->add('admin/{controller}', ['namespace' => 'Admin', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id}/{action}');
$router->add('{controller}', ['action' => 'index']);

$router->dispatch($_SERVER['QUERY_STRING']);

console_log($_SERVER['QUERY_STRING'], 'query string:');
