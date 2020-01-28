<?php
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;

    class HomeController extends BaseController{

        static function dashboard(){
            return self::view('App/main');
        }
    }
}