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
  $Dir = dirname(__FILE__) . '/../ressources/';

  if (!isset($_GET['sheet'])) {
    header('HTTP/1.1 404 Not Found');
    exit;
  }
  
  $file = $Dir . $_GET['sheet'];
  
  if (!$file) {
    header('HTTP/1.1 404 Not Found');
    exit;
  }
  
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    /*if (substr($file, 0, strlen($Dir) != $Dir)) {
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
    header('Content-type: image/svg+xml');
    echo $svg_file_new;
    exit;
  }
  
  if(in_array($ext, array("png", "jpg", "jpeg", "bmp", "gif")))
    header('Content-type: image/' . $ext);
  else if(in_array($ext, array("ttf", "amfm", "etx", "fnt", "otf", "woff", "eot")))
    header('Content-type: font/opentype');
  else
    header('Content-type: text/' . $ext);
  
  echo file_get_contents($file);
  exit;
  
}