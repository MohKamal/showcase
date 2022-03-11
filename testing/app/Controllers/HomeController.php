<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{
    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Database\DB;
    use \Showcase\Models\Unit;
    use \Showcase\Models\User;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            $a = DB::factory()->model('Unit')->select()->where('id', 2)->first();
            return self::response()->view('App/welcome', ['doc' => 'Hola']);
        }
    }
}