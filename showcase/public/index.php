<?php

namespace Showcase{
  /******************************************
   * 
   *  Silence is a friend who never betrays.
   * 
   *******************************************/
  require_once '../autoload.php';
  require_once '../Framwork/Initializer/AppSetting.php';

  use \Showcase\Framwork\Initializer\AppSetting;
  use \Showcase\AutoLoad;

  AppSetting::Init();
  AutoLoad::register();

  require_once '../Framwork/HTTP/Routing/web.php';

}