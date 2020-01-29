<?php
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;

    class NameController extends BaseController{

        static function index(){
            return self::view('App/welcome');
        }
        
        static function create(){
            //return
        }
        
        static function store($request){
            if(Validator::Validate($request->getBody(), ['email', 'password'])){
                if($auth->login($request->getBody()['email'], $request->getBody()['password']))
                    return URL::Redirect('/'); 
            }
            return URL::Redirect('/contact'); 
        }
    }
}