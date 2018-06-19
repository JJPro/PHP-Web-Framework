<?php
namespace Core;

/**
* Base controller
*/
abstract class Controller
{
  /**
  * Parameters from the matched route
  * @var array
  */
  protected $route_params = [];

  /**
  * Class constructor
  *
  * @param array $route_params  Parameters from the route
  *
  * @return void
  */
  public function __construct($route_params)
  {
    $this->route_params = $route_params;
  }

  /**
  * Magic method called when a non-existence or inaccessible method is called.
  * Used to execute before and after filter methods on action methods. Action
  * methods need to be named with an "Action" suffix, e.g. indexAction,
  * showAction etc.
  *
  * @param string $method  Method name
  * @param array $args   Arguments passed to the method
  *
  * @return void
  */
  public function __call($method, $args)
  {
    if (method_exists($this, $method)) {
      if ($this->before() !== false) {
        call_user_func_array([$this, $method], $args);
        $this->after();
      }
    } else {
      echo "Method $method not found in controller " . get_class($this);
    }
  }

  protected function before(){}

  protected function after(){}
}

?>
