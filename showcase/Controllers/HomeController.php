<?php
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;

    class HomeController extends BaseController{

        static function Index(){
            return self::view('App/welcome');
        }
    }
}