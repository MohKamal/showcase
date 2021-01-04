<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace Showcase\Framework\HTTP\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;

    class ResourceController extends BaseController{

        /**
         * Return any file
         */
        static function ressource($request){
            $errors = Validator::validation($request->getBody(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../ressources/';
                $name = $request->getBody()['file'];
                if(substr($request->getBody()['file'],0,1) === '/')
                    $name = ltrim($request->getBody()['file'], '/'); 
                $file = $Dir . $name;
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if($ext == 'js')
                    $ext = 'javascript';

                if($ext == 'svg'){
                    $find_string   = '<svg';
                    $position = strpos(file_get_contents($file), $find_string);
                    
                    $svg_file_new = substr(file_get_contents($file), $position);
                    header('Content-type: image/svg+xml');
                    echo $svg_file_new;
                    exit;
                }
                if(in_array($ext, array("png", "jpg", "jpeg", "bmp", "gif", "ico")))
                    header('Content-type: image/' . $ext);
                else if(in_array($ext, array("ttf", "amfm", "etx", "fnt", "otf", "woff", "eot")))
                    header('Content-type: font/opentype');
                else
                    header('Content-type: text/' . $ext);
                
                echo file_get_contents($file);
            }
            return self::response()->notFound();
        }

        /**
         * Return style files
         */
        static function css($request){
            $errors = Validator::validation($request->getBody(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../ressources/css/';
                $name = $request->getBody()['file'];
                if(substr($request->getBody()['file'],0,1) === '/')
                    $name = ltrim($request->getBody()['file'], '/'); 
                $file = $Dir . $name;
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if($ext == 'js')
                    $ext = 'javascript';

                if($ext == 'svg'){
                    $find_string   = '<svg';
                    $position = strpos(file_get_contents($file), $find_string);
                    
                    $svg_file_new = substr(file_get_contents($file), $position);
                    header('Content-type: image/svg+xml');
                    echo $svg_file_new;
                    exit;
                }
                if(in_array($ext, array("png", "jpg", "jpeg", "bmp", "gif", "ico")))
                    header('Content-type: image/' . $ext);
                else if(in_array($ext, array("ttf", "amfm", "etx", "fnt", "otf", "woff", "eot")))
                    header('Content-type: font/opentype');
                else
                    header('Content-type: text/' . $ext);
                
                echo file_get_contents($file);
            }
            return self::response()->notFound();
        }

        /**
         * Return script files
         */
        static function js($request){
            $errors = Validator::validation($request->getBody(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../ressources/js/';
                $name = $request->getBody()['file'];
                if(substr($request->getBody()['file'],0,1) === '/')
                    $name = ltrim($request->getBody()['file'], '/'); 
                $file = $Dir . $name;
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if($ext == 'js')
                    $ext = 'javascript';

                if($ext == 'svg'){
                    $find_string   = '<svg';
                    $position = strpos(file_get_contents($file), $find_string);
                    
                    $svg_file_new = substr(file_get_contents($file), $position);
                    header('Content-type: image/svg+xml');
                    echo $svg_file_new;
                    exit;
                }
                if(in_array($ext, array("png", "jpg", "jpeg", "bmp", "gif", "ico")))
                    header('Content-type: image/' . $ext);
                else if(in_array($ext, array("ttf", "amfm", "etx", "fnt", "otf", "woff", "eot")))
                    header('Content-type: font/opentype');
                else
                    header('Content-type: text/' . $ext);
                
                echo file_get_contents($file);
            }
            return self::response()->notFound();
        }

        /**
         * Return script files
         */
        static function images($request){
            $errors = Validator::validation($request->getBody(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../ressources/images/';
                $name = $request->getBody()['file'];
                if(substr($request->getBody()['file'],0,1) === '/')
                    $name = ltrim($request->getBody()['file'], '/'); 
                $file = $Dir . $name;
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                
                if($ext == 'js')
                    $ext = 'javascript';

                if($ext == 'svg'){
                    $find_string   = '<svg';
                    $position = strpos(file_get_contents($file), $find_string);
                    
                    $svg_file_new = substr(file_get_contents($file), $position);
                    header('Content-type: image/svg+xml');
                    echo $svg_file_new;
                    exit;
                }
                if(in_array($ext, array("png", "jpg", "jpeg", "bmp", "gif", "ico")))
                    header('Content-type: image/' . $ext);
                else if(in_array($ext, array("ttf", "amfm", "etx", "fnt", "otf", "woff", "eot")))
                    header('Content-type: font/opentype');
                else
                    header('Content-type: text/' . $ext);
                
                echo file_get_contents($file);
            }
            return self::response()->notFound();
        }
    }
}