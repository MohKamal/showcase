<?php
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\HTTP\Links\URL;

    class NameController extends BaseController{

        /**
         * @return View
         */
        static function index(){
            return self::view('App/welcome');
        }
        
        /**
         * @return View
         */
        static function create(){
            return self::view('App/welcome');
        }
        
        /**
         * Post method
         * @param \Showcase\Framework\HTTP\Routing\Request
         * @return Redirection
         */
        static function store($request){
            if(Validator::Validate($request->getBody(), ['email', 'password'])){
                    return URL::Redirect('/'); 
            }
            return URL::Redirect('/contact'); 
        }
    }
}