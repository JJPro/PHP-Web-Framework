<?php
namespace Core;
use App\Config;
use Core\View;
/**
* Error and exception handler
*/
class Error
{
  /**
  * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
  *
  * @param int $level  Error level
  * @param string $message  Error message
  * @param string $file   Filename the error was raised in
  * @param int $line  Line number in the file
  *
  * @return void
  */
  static public function errorHandler($level, $message, $file, $line)
  {
    throw new \ErrorException($message, 0, $level, $file, $line);
  }

  /**
  * Exception handler.
  *
  * @param Exception $exception  The exception
  *
  * @return void
  */
  public static function exceptionHandler($exception)
  {
    // Code is 404 (not found) or 500 (general error)
    $code = $exception->getCode();
    $code = $code == 404 ? 404 : 500;
    console_log($code, 'HTTP Response Code: ');
    http_response_code( $code);

    $exception_class = get_class($exception);
    if (\App\Config::SHOW_ERRORS) {
      echo <<<EXCEPTION
<h1>Fatal error</h1>
<p>Uncaught exception: '$exception_class'</p>
<p>Message: '{$exception->getMessage()}'</p>
<p>
  Stack trace: <pre>
    {$exception->getTraceAsString()}
  </pre>
</p>
<p>Thrown in '{$exception->getFile()}' on line {$exception->getLine()}</p>
EXCEPTION;
    } else {
      $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
      console_log($log, "error log path: ");
      ini_set('error_log', $log);
      $message = <<<LOGMESSAGE
Uncaught exception: '$exception_class' with message '{$exception->getMessage()}'
Stack trace: {$exception->getTraceAsString()}
Thrown in '{$exception->getFile()}' on line {$exception->getLine()}
LOGMESSAGE;

      error_log($message);
      console_log($code, 'HTTP Response Code: ');

      View::render("$code.html");
    }
  }
}
 ?>
