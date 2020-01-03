<?php
namespace Facade\Controllers{
    
    use \Facade\AutoLoad;
    use \Facade\Utils\Validation\Validator;
    use \Facade\Utils\HTTP\Links\URL;
    use \Facade\Models\User;
    use \Facade\Models\Degree;
    
    class HomeController{

        static function Dashboard(){
            //Verify if the user is connected, if not, redirect him to the login page
            if(User::Current() != null){
                return URL::Redirect('views/App/calcule.php');
            }

            return URL::Redirect('login'); //Login page
        }
    }
}