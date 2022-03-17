<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\HTTP\Exceptions\GeneralException;
    use \Showcase\Framework\HTTP\Exceptions\ExecptionEnum;
    use \Showcase\Framework\Database\DB;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            DB::factory()->model(null)->select()->first();
            return self::response()->view('App/welcome');
        }
    }
}