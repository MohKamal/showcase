<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 */
namespace Showcase{
  $variables = [
      'APP_NAME' => 'Showcase',
      'APP_KEY' => '937a4a8c13e317dfd28effdd479cad2f',
      'DB_HOST' => 'localhost',
      'DB_USERNAME' => 'root',
      'DB_PASSWORD' => '',
      'DB_NAME' => 'showcase_db',
      'DB_PORT' => '3306',
      'APP_URL' => 'http://localhost/showcase/public/',
      'APP_SUBFOLDER' => '/showcase/public',
      'APP_ENV' => 'local',
      'ROUTE_FOLDER' => 'route/',
  ];
  
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
}