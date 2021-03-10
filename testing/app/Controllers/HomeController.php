<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{
    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Models\Unit;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            $unit = new Unit();
            $unit->name = "nice";
            $unit->value = "cool";
            $unit->save();
            return self::response()->view('App/welcome', ['doc' => 'Hola']);
        }
    }
}