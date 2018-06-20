# Purpose #
After using Elixir Phoenix and PHP Laravel for quite a time, I decided to make
my own web framework to get a deeper understanding of web frameworks, and will
put to good use in future projects.

This is also a good chance to practice:
- Routing with Regex (i.e. named capturing groups) - map requests to controller/actions.
- PHP 7 new features.
- Utilize composer to integrate with 3rd party libraries.
- Follow PSR coding guidelines
- Autoloading with composer

# Components #
* Router - using Regex to route URL to Controller/action
* Model
* Templates - HTML templates. The View part of MVC
* Controller - controller/action decides which view to render
* Config.php - application configurations (database, log level, etc. ) in one place. 
