<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Models\Unit;
    use \Showcase\Framework\Database\DB;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\JsonResources\UserResource;
    use \Showcase\Framework\Session\SessionAlert;

    class HomeController extends BaseController{

        /**
         * Return the welcome view
         */
        static function Index(){
            /*$unit = new Unit();
            $unit->name = "test";
            $unit->value = 10;
            $unit->save();*/
            //$users = DB::model('User')->select()->get();
            //$r = DB::model('Unit')->insert(['name' => 'hola', 'value' => '55'])->run();
            //Log::print($r);
            //$r = DB::model('Unit')->delete()->where('id', 4)->run();
            //$r = DB::model('Unit')->update(['value' => '27', 'name' => '<li class="nav-item">'])->where('id', 4)->run();
            //Log::print($r);
            return self::response()->view('App/welcome', ['doc' => 'mohamed kamal']);
            //return self::response()->internal();
            //return self::response()->json(UserResource::array($users));
        }
    }
}