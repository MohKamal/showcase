<?php
namespace Facade\Controllers{
    
    use \Facade\AutoLoad;
    use \Facade\Utils\Validation\Validator;
    use \Facade\Utils\HTTP\Links\URL;
    use \Facade\Models\Degree;
    use \Facade\Models\User;
    
    class DegreeController{

        /**
         * 
         */
        public static function store($request)
        {
            if(Validator::Validate($request->getBody(), ['programmation', 'compilation', 'ai', 'uml'])){
                $degree = new Degree(User::Current()->email);
                $degree->updateValues(['programmation' => $request->getBody()['programmation'], 'compilation' => $request->getBody()['compilation'], 'ai' => $request->getBody()['ai'], 'uml' => $request->getBody()['uml']]);
                $degree->save();
            }
            return URL::Redirect('user-space');
        }

        /**
         * 
         */
        public function update($request)
        {
            if(Validator::Validate($request->getBody(), ['pk', 'name', 'value'])){
                $degree = Degree::getByEmail($request->getBody()['pk']);
                $degree->updateValues([$request->getBody()['name'] => $request->getBody()['value']]);
                $degree->update();
            }
            return URL::Redirect('user-space');
        }

        /**
         * 
         */
        public function delete($password)
        {
            return false;
        }
    }
}