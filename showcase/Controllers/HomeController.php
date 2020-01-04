<?php
namespace Showcase\Controllers{
    
    use \Showcase\AutoLoad;
    use \Showcase\Framwork\Validation\Validator;
    use \Showcase\Framwork\HTTP\Links\URL;
    use \Showcase\Models\User;
    use \Showcase\Models\Degree;
    
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