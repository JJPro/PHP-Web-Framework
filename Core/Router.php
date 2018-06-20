<?php
namespace Core;

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

  /**
  * Call the requested controller/action method
  *
  * @param string $url  The route URL
  *
  * @return void
  */
  public function dispatch($url)
  {
    $url = $this->removeQueryStringVariables($url);
    if ($this->match($url)) {
      $controller = $this->params['controller'];
      $controller = $this->convertToPascalCase($controller);
      $controller = "{$this->getNamespace()}$controller";

      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);
        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        // if (is_callable([$controller_object, $action])) {
        //   $controller_object->$action();
        // } else {
        //   echo "Method $action in controller $controller not found";
        // }
        if (preg_match('/action$/i', $action) == 0) {
          $controller_object->$action();
        } else {
          throw new \Exception("Method $action in controller $controller cannot be called directly");
        }
      } else {
        throw new \Exception("Controller class $controller not found");
      }
    } else {
      throw new \Exception("No route found for $url", 404);
    }
  }

  /**
  * Get the namespace for the controller class. The namespace defined in the
  * router parameters is added if present.
  *
  * @return string The request URL
  */
  protected function getNamespace()
  {
    $namespace = 'App\Controllers\\';

    if (array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] . '\\';
    }

    return $namespace;
  }

  /**
  * Utility function, converts string to pascal case style
  *
  * @param string $controller
  *
  * @return string   String in pascal case
  */
  private function convertToPascalCase(string $controller)
  {
    // convert to pascal case first
    $controller = ucwords($controller, '-');

    // remove - (hyphen)
    $controller = str_replace('-', '', $controller);

    return $controller;
  }

  /**
  * Utility function, converts string to camel case style
  *
  * @param string $action
  *
  * @return string    String in camel case
  */
  private function convertToCamelCase($action)
  {
    // convert to pascal case first
    $action = $this->convertToPascalCase($action);

    // convert first letter to lower case
    $action = lcfirst($action);

    return $action;
  }

  /**
  * Remove query string variables
  *
  * @param string $url  The full URL
  *
  * @return string      The URL with the query variables removed
  */
  protected function removeQueryStringVariables($url)
  {
    $parts = explode('&', $url, 2);
    if (strpos($parts[0], '=') === false) {
      $url = $parts[0];
    } else {
      $url = '';
    }
    return $url;
  }

}
?>
