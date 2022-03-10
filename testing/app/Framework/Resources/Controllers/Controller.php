<?php
namespace  Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\HTTP\Gards\Auth;
    use \Showcase\Framework\HTTP\Routing\Request;
    use \Showcase\Framework\Database\DB;

    class NameController extends BaseController{

        /**
         * @return View
         */
        static function index(){
            return self::response()->view('App/welcome');
        }
        
        /**
         * @return View
         */
        static function create(){
            return self::response()->view('App/welcome');
        }
        
        /**
         * Post method
         * @param \Showcase\Framework\HTTP\Routing\Request
         * @return Redirection
         */
        static function store(Request $request){
            if(Validator::validate($request->get(), ['email', 'password'])){
                    // email and password found
                    return self::response()->redirect('/'); 
            }
            return self::response()->redirect('/create', 'please fill all inputs', 'error'); 
        }
    }
}