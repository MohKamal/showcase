<?php

namespace Showcase{
  /******************************************
   * 
   * 
   * 
   * 
   *  Silence is a friend who never betrays.
   * 
   * 
   * 
   * 
   *******************************************/
  $cssDir = dirname(__FILE__) . '/../ressources/';

  if (!isset($_GET['sheet'])) {
    header('HTTP/1.1 404 Not Found');
    exit;
  }
  
  $file = $cssDir . $_GET['sheet'];
  
  if (!$file) {
    header('HTTP/1.1 404 Not Found');
    exit;
  }
  
    $ext = pathinfo($file, PATHINFO_EXTENSION);
  /*if (substr($file, 0, strlen($cssDir) != $cssDir)) {
    // because we've sanitized using realpath - this must match
    header('HTTP/1.1 404 Not Found'); // or 403 if you really want to - maybe log it in errors as an attack?
    exit;
  }*/
  if($ext == 'js')
    $ext = 'javascript';

  if($ext == 'svg'){
    $find_string   = '<svg';
    $position = strpos(file_get_contents($file), $find_string);
    
    $svg_file_new = substr(file_get_contents($file), $position);
    echo $svg_file_new;
    exit;
    }
  header('Content-type: text/' . $ext);
  echo file_get_contents($file);
  exit;
  
}