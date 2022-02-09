<?php
namespace  Showcase\Framework\IO\Storage{
    
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\IO\Debug\Log;
    /**
     * Manage the files storage
     */
    class Storage {

        private $_currentFolder;
        private $_rootFolder;
        private $_onlyFolder;
        private $_folder_type = 0; //0 for storage, 1 for resources and 2 for global and 3 for views and 4 for migration

        /**
         * Select the folder where to do the maniplulations
         * @param string $name folder name
         * 
         * @return \Showcase\Framework\Storage\Storage object
         */
        public static function folder($name){
            if(empty($name))
                return null;

            $_instance = new self;
            $_instance->_rootFolder = dirname(__FILE__) . '/../../../../storage/';

            //create folder if no exist
            $folder = $_instance->_rootFolder . $name . '/';
            if (!file_exists($folder)) {
                if(!mkdir($folder, 0777, true))
                    return null;
            }
            $_instance->_currentFolder = $folder;
            $_instance->_onlyFolder = $name;
            $_instance->_folder_type = 0;
            return $_instance;
        }

        /**
         * Select the folder where to do the maniplulations
         * @param string $name folder name
         * 
         * @return \Showcase\Framework\Storage\Storage object
         */
        public static function resources($name){
            if(empty($name))
                return null;

            $_instance = new self;
            $_instance->_rootFolder = dirname(__FILE__) . '/../../../../resources/';

            //create folder if no exist
            $folder = $_instance->_rootFolder . $name . '/';
            if (!file_exists($folder)) {
                if(!mkdir($folder, 0777, true))
                    return null;
            }
            $_instance->_currentFolder = $folder;
            $_instance->_onlyFolder = $name;
            $_instance->_folder_type = 1;
            return $_instance;
        }

        /**
         * Select the folder where to do the maniplulations
         * @param string $name folder name
         * 
         * @return \Showcase\Framework\Storage\Storage object
         */
        public static function views($name=''){
            $_instance = new self;
            $_instance->_rootFolder = dirname(__FILE__) . '/../../../../resources/views';

            //create folder if no exist
            $folder = $_instance->_rootFolder . $name;
            if (!file_exists($folder)) {
                if(!mkdir($folder, 0777, true))
                    return null;
            }
            $_instance->_currentFolder = $folder;
            $_instance->_onlyFolder = $name;
            $_instance->_folder_type = 3;
            return $_instance;
        }

        /**
         * Select the folder where to do the maniplulations
         * @param string $name folder name
         * 
         * @return \Showcase\Framework\Storage\Storage object
         */
        public static function migrations($name=''){
            $_instance = new self;
            $_instance->_rootFolder = dirname(__FILE__) . '/../../../Database/Migrations';

            //create folder if no exist
            $folder = $_instance->_rootFolder . $name;
            if (!file_exists($folder)) {
                if(!mkdir($folder, 0777, true))
                    return null;
            }
            $_instance->_currentFolder = $folder;
            $_instance->_onlyFolder = $name;
            $_instance->_folder_type = 4;
            return $_instance;
        }

        /**
         * Set no folder 
         * @param string $name folder name
         * 
         * @return \Showcase\Framework\Storage\Storage object
         */
        public static function global($name='') {
            $_instance = new self;
            $_instance->_rootFolder = dirname(__FILE__) . '/../../../../';

            //create folder if no exist
            $folder = $_instance->_rootFolder . $name;
            if (!file_exists($folder)) {
                if(!mkdir($folder, 0777, true))
                    return null;
            }
            $_instance->_currentFolder = $folder;
            $_instance->_onlyFolder = $name;
            $_instance->_folder_type = 2;
            return $_instance;
        }

        /**
         * Save content into a file
         * @param string $filename
         * @param mixed $content
         * 
         * @return boolean
         */
        public function put($filename, $content){
            if(empty($filename) || empty($content))
                return null;
            $file = $this->_currentFolder . $filename;
            if(!file_put_contents($file, $content))
                return false;
            return true;
        }

        /**
         * Append content into a file
         * @param string $filename
         * @param mixed $content
         * 
         * @return boolean
         */
        public function append($filename, $content) {
            if(empty($filename) || empty($content))
                return null;
            $file = $this->_currentFolder . $filename;
            if(!file_put_contents($file, $content, FILE_APPEND))
                return false;
            return true;
        }

        /**
         * Get a file content
         * @param string $filename
         * 
         * @return mixed
         */
        public function get($filename){
            if(empty($filename))
                return null;

            if(!file_exists($this->_currentFolder . $filename))
                return false;
            
            return file_get_contents($this->_currentFolder . $filename);
        }

        /**
         * Check if a file exists
         * @param string $filename
         * 
         * @return mixed
         */
        public function exists($filename){
            if(empty($filename))
                return null;
            return file_exists($this->_currentFolder . $filename);
        }

        /**
         * Download a file
         * @param string $filename
         * 
         * @return mixed
         */
        public function download($filename){
            if(empty($filename))
                return null;
            $file = $this->_currentFolder . $filename;
            if (file_exists($file)) {
                while (ob_get_level()) {
                    ob_end_clean();
                }
                ob_start();
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_flush();
                ob_clean();
                readfile($file);
            }
        }

        /**
         * Copy a file from a dir to the selected dir
         * @param string $filename to copy
         * @param string $newname for the new file
         * 
         * @return mixed
         */
        public function copy($filename, $newname){
            if(empty($filename) || empty($newname))
                return null;
            $file = $this->_rootFolder . $filename;
            if(!file_exists($file))
                return false;
            $new = $this->_currentFolder . $newname;
            return copy($file, $new);
        }

        /**
         * Move a file from a dir to the selected dir
         * @param string $filename to move
         * @param string $newname for the new file
         * 
         * @return mixed
         */
        public function move($filename, $newname){
            if(empty($filename) || empty($newname))
                return null;
            $file = $this->_rootFolder . $filename;
            if(!file_exists($file))
                return false;
            $new = $this->_currentFolder . $newname;
            return rename($file, $new);
        }

        /**
         * Remove a file from a dir to the selected dir
         * @param string $filename to move
         * @param string $newname for the new file
         * 
         * @return mixed
         */
        public function remove($filename){
            if(empty($filename))
                return null;
            $file = $this->_currentFolder . $filename;
            if(!file_exists($file))
                return false;
            unlink($file);
            return true;
        }

        /**
         * Get url for download
         * @param string $filename
         * 
         * @return mixed
         */
        public function url($filename) {
            if(empty($filename))
                return null;

            $currentFile = $this->_currentFolder . $filename;
            $folder = $this->_rootFolder . "downloads/";
            $toFile = $folder . basename($filename);
            if(!file_exists($currentFile))
                return false;

            if ($currentFile !== $toFile) {
                if (!file_exists($folder)) {
                    if(!mkdir($folder, 0777, true))
                        return null;
                }
                if (!copy($currentFile, $toFile)) {
                        return false;
                }
            }

            if(!file_exists($toFile))
                return false;
            $base = URL::base();
            if(Utilities::endsWith($base, '/'))
                $base = substr($base, 0, -1);
            return  $base . "/download?file=" . basename($filename); 
        }

                /**
         * Get url for download
         * @param string $path
         * 
         * @return mixed
         */
        public function urlFromPath($path) {
            if(empty($path))
                return null;

            $currentFile = $path;
            $folder = $this->_rootFolder . "downloads/";
            $toFile = $folder . basename($path);
            if(!file_exists($currentFile))
                return false;

            if ($currentFile !== $toFile) {
                if (!file_exists($folder)) {
                    if(!mkdir($folder, 0777, true))
                        return null;
                }
                if (!copy($currentFile, $toFile)) {
                        return false;
                }
            }

            if(!file_exists($toFile))
                return false;
            $base = URL::base();
            if(Utilities::endsWith($base, '/'))
                $base = substr($base, 0, -1);
            return  $base . "/download?file=" . basename($path); 
        }

        /**
         * Get file path
         * @param string $filename
         * 
         * @return mixed
         */
        public function path($filename, $verify=true) {
            if(empty($filename))
                return null;
            $file = $this->_currentFolder . "/$filename";
            if ($verify) {
                if (!file_exists($file)) {
                    return false;
                }
            }
            return $file;
        }
        
        /**
         * Scan a folder and get all the files
         * 
         * @return array of files
         */
        public function scandir() {
            $dir = $this->_currentFolder;
            return scandir($dir);
        }

        /**
         * Copy an uploaded file to storage folder
         * 
         * @param string $from uploaded file path
         * @param string $to new file path
         * 
         * @return boolean
         */
        public function moveUpload($from, $to) {
            $new = $this->_currentFolder . $to;
            if(move_uploaded_file($from, $new)){
                return true;
            } else {
                return false;
            }
        }
    }
}