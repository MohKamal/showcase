<?php
namespace Showcase\Framework\HTTP\Controllers{
    
    use \Showcase\AutoLoad;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Views\View;
    
    class BaseController{
        
        function view($view){
            return View::show($view);
        }
    }
}