<?php
/**
 * More at : https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
 */
namespace Facade{
  $variables = [
      'APP_NAME' => 'Showcase',
      'APP_KEY' => '937a4a8c13e317dfd28effdd479cad2f',
      'DB_HOST' => 'localhost',
      'DB_USERNAME' => 'root',
      'DB_PASSWORD' => '',
      'DB_NAME' => 'showcase_db',
      'DB_PORT' => '3306',
      'APP_URL' => 'http://localhost/php-showcase-template/showcase/',
      'APP_SUBFOLDER' => '/php-showcase-template/showcase',
      'APP_ENV' => 'local',
      'RES_FOLDER' => dirname(__FILE__) . '\ressources',
      'LOG_FOLDER' => dirname(__FILE__) . '\Storage\logs',
      'RESOURCES' => '/ressources/',
      'VIEW' => 'views/',
      'ROUTE_FOLDER' => 'route/',
  ];
  
  foreach ($variables as $key => $value) {
      putenv("$key=$value");
  }
}