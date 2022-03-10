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
            $unit = new Unit();
            $unit->name = "nice";
            $unit->value = "cool";
            // $unit->save();
            $a = DB::factory()->model('Unit')->select()->where('id', 2)->first();
            $user = DB::factory()->model('User')->select()->where('id', 7)->first();
            // $a->setUser($user);
            var_dump($a->user()->firstname);
            return self::response()->view('App/welcome', ['doc' => 'Hola']);
        }
    }
}