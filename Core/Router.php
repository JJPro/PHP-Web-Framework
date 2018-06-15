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
  **/
  protected $params = [];

  /**
  * Add a route to the routing table
  *
  * @param string $route  The route URL
  * @param array  $params Parameters (controller, action, etc.)
  *
  * @return void
  */
  public function add($route, $params)
  {
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
    /*
    foreach ($this->routes as $route => $params) {
      if ($url == $route){
        $this->params = $params;
        return true;
      }
    }
    */

    // Match to the fixed URL format /controller/action
    $reg_exp = '/^(?<controller>[a-z-]+)\/(?<action>[a-z-]+)$/';

    if (preg_match($reg_exp, $url, $matches)) {
      // Get named capturing group values
      foreach ($matches as $key => $value) {
        if (is_string($key))
          $this->params[$key] = $value;
      }
      return true;
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
