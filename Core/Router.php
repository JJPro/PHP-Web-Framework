<?php
class Router {
  /**
  * Associative array of routes ( the routing table )
  * @var array
  */
  protected $routes = [];

  /**
  * Parameters from the matched route
  * @var array
  */
  protected $params = [];

  /**
  * Add a route to the routing table
  *
  * @param string $route  The route URL
  * @param array  $params Parameters (controller, action, etc.)
  *
  * @return void
  *
  * Example:
  * fixed format:
  *   - $router->add('posts/index', [
  *         'controller' => 'Posts',
  *         'action' => 'index'
  *     ]):
  *     $this->routes['posts/index'] = [
  *       'controller' => 'Posts',
  *       'action' => 'index'
  *     ]
  * regex:
  *   - $router->add('{controller}/{action}'):
  *     $this->routes['/^(?<controller>[a-z-]+)\/(?<action>[a-z-]+)$/i'] = [];
  *   - $router->add('{controller}/{id}/{action}'):
  *     $this->routes['/^(?<controller>[a-z-]+)\/(?<id>\d+)\/(?<action>[a-z-]+)$/i']
  *     = [];
  */
  public function add($route, $params = [])
  {
    // convert route string to regex: escape forward slashes
    $route = preg_replace('/\//', '\\/', $route);

    // convert variables e.g. {controller} => (?<controller>[a-z-]+)
    $route = preg_replace('/\{([\w-]+)\}/', '(?<\1>[\w-]+)', $route);

    // add start and end delimiters, and case insensitive flag
    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;
  }

  public function getRoutes()
  {
    return $this->routes;
  }

  /**
  * Match the url to routes in routing table, setting the $params property if a
  * route is found.
  *
  * @param string $url The route URL
  *
  * @return boolean  true if a match found, false otherwise
  */
  public function match($url)
  {
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        console_log($matches, 'matches');
        console_log($route, 'matched route');
        // Get named capturing group values
        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match; // e.g. "controller" => "users"
          }
        }
        $this->params = $params;

        return true;
      }
    }

    return false;
  }

  /**
  * Get the currently matched parameters
  *
  * @return array
  */
  public function getParams()
  {
    return $this->params;
  }

}
?>
