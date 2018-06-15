<?php

/**
* Front controller
*/

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
require '../Core/Router.php';

$router = new Router();

// Add routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);

// Display the routing table
// echo "<pre>";
console_log($router->getRoutes(), "routes");
// echo "</pre>";

// Match the requested route
$url = $_SERVER['QUERY_STRING'];

if ($router->match($url)) {
  console_log($router->getParams(), "params");
} else {
  console_log("No route found for URL '$url'");
}
