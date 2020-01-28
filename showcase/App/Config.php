<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 */
namespace Showcase{
  $variables = [
      'APP_NAME' => 'Showcase',
  ];
  
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
}