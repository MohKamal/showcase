<?php
namespace  Showcase\Database\Seed {    

    use \Showcase\Framework\Database\Seeding\Seeder;
    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\Database\DB;
    // use \Showcase\Models\User;

    class SeederName extends Seeder{

        /**
         * Seeder details
         */
        function execute(){
            $this->name = 'SeederName';
            /*
                $user = new User();
                $user->name = "Kamal"
                $user->save();
            */
        }
    }
}