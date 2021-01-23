<?php
/**
 * 
 * Default controller in the Showcase
 * 
 */
namespace  Showcase\Framework\HTTP\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\IO\Storage\Storage;

    class ResourceController extends BaseController{

        /**
         * Return any file
         */
        static function ressource($request){
            $errors = Validator::validation($request->get(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../../resources/';
                return self::getData($Dir, $request->get()['file']);
            }
            else
                return self::response()->notFound();
        }

        /**
         * Return style files
         */
        static function css($request){
            $errors = Validator::validation($request->get(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../../resources/css/';
                return self::getData($Dir, $request->get()['file']);
            }
            else
                return self::response()->notFound();
        }

        /**
         * Return script files
         */
        static function js($request){
            $errors = Validator::validation($request->get(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../../resources/js/';
                return self::getData($Dir, $request->get()['file']);
            }
            else
                return self::response()->notFound();
        }

        /**
         * Return script files
         */
        static function images($request){
            $errors = Validator::validation($request->get(), ['file' => 'required | string']);

            if (empty($errors)) {
                $Dir = dirname(__FILE__) . '/../../../../resources/images/';
                return self::getPicture($Dir, $request->get()['file']);
            }
            else
                return self::response()->notFound();
        }

        /**
         * Return a file
         */
        static function download($request){
            $errors = Validator::validation($request->get(), ['file' => 'required | string']);
            if (empty($errors)) {
                $file = Storage::folder("downloads")->path($request->get()['file']);
                if (filter_var(strtolower($file), FILTER_VALIDATE_BOOLEAN)) 
                    return self::response()->notFound();
                return self::response()->download($file);
            }
            else
                return self::response()->notFound();
        }

        /**
         * Get pictures files
         * 
         * @return echo file
         */
        private static function getPicture($Dir, $name){
            if(Utilities::startsWith($name,'/'))
                $name = ltrim($name, '/'); 
            $filename = $Dir . $name;
            // Check if file exists, if it is not here return false:
            if ( !file_exists( $filename )) return false;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            // Suggest better filename for browser to use when saving file:
            header('Content-Disposition: attachment; filename='.basename($filename));
            header('Content-Transfer-Encoding: binary');
            // Caching headers:
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            // This should be set:
            header('Content-Length: ' . filesize($filename));
            // Clean output buffer without sending it, alternatively you can do ob_end_clean(); to also turn off buffering.
            ob_clean();
            // And flush buffers, don't know actually why but php manual seems recommending it:
            flush();
            // Read file and output it's contents:
            echo file_get_contents( $filename );
            // You nee
            exit;
        }

        /**
         * Get file data
         * 
         * @return string content
         */
        private static function getData($Dir, $name){
            if(Utilities::startsWith($name,'/'))
                $name = ltrim($name, '/'); 
            $file = $Dir . $name;
            if(!file_exists($file))
                return self::response()->notFound();
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
            if (in_array($ext, array("png", "jpg", "jpeg", "bmp", "gif"))) {
                return self::getPicture($Dir, $name);
            }else if(in_array($ext, array("ttf", "amfm", "etx", "fnt", "otf", "woff", "eot")))
                header('Content-type: font/opentype');
            else
                header('Content-type: text/' . $ext);

            $data = file_get_contents($file);
            echo $data;
        }
    }
}