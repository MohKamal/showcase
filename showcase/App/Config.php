<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 * 
 * 
 * You may need to save variables to use in the diffrents files of the project
 * Here declare the variables in the variables array Key  => Value
 * 
 */
namespace Showcase{
  /**
   * 
   * Global Variables to be used everywhere with the Authoload
   * 
   * 
   * @var array
   */
  $variables = [
      'APP_NAME' => 'Showcase',
  ];
  
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
}