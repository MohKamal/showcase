<?php
namespace Showcase\Models{
    use Showcase\Framwork\IO\CSVHandler;
    use \Showcase\AutoLoad;
    use \Showcase\Framwork\Session\SessionAlert;
    use \Exception;

    AutoLoad::register();

    class Degree
    {
        public $user_email;
        public $programmation;
        public $compilation;
        public $ai;
        public $uml;

        public function __get($var) {
            throw new Exception("Invalid property $var");
        }

        public function __set($var, $value) {
            $this->__get($var);
        }

        public function __construct($user_email){
            $this->user_email = $user_email;
        }

        /**
         * Update Degree $data
         * @param $data array
         */
        public function updateValues(array $data){
            foreach($data as $key => $value){
                $this->$key = $value;
            }
        }

        /**
         * Save to file
         */
        public function save(){
            CSVHandler::Write(AutoLoad::env('CSV_NOTE'), [strtolower($this->user_email), $this->programmation, $this->compilation, $this->ai,  $this->uml]);
        }

        public function update(){
            $data = CSVHandler::Read(AutoLoad::env('CSV_NOTE'));
            $index = -1;
            $found = false;
            if($data != null){
                foreach($data as $line){
                    $index = $index + 1;
                    if($line[0] == strtolower($this->user_email)){
                        $found = true;
                        break;
                    }
                }
            }
            // Saving to file
            if($found){
                CSVHandler::Update(AutoLoad::env('CSV_NOTE'), [strtolower($this->user_email), $this->programmation, $this->compilation, $this->ai,  $this->uml], $index);
            }
        }

        /**
         * Get a user notes by its email
         */
        public static function getByEmail($email){
            // Extract all users data
            $data = CSVHandler::Read(AutoLoad::env('CSV_NOTE'));
            // Loop for the specific user
            if($data != null){
                foreach($data as $line){
                    if($line[0] == strtolower($email)){
                        $degree = new Degree($line[0]);
                        $degree->updateValues(['programmation' => $line[1], 'compilation' => $line[2], 'ai' => $line[3], 'uml' => $line[4]]);
                        return $degree;
                    }
                }
            }
            return null;
        }

        /**
         * Get a user notes by its email
         */
        public static function getAllByEmail($email){
            // Extract all users data
            $data = CSVHandler::Read(AutoLoad::env('CSV_NOTE'));
            $degrees = array();
            // Loop for the specific user
            if($data != null){
                foreach($data as $line){
                    if($line[0] == strtolower($email)){
                        $degree = new Degree($line[0]);
                        $degree->updateValues(['programmation' => $line[1], 'compilation' => $line[2], 'ai' => $line[3], 'uml' => $line[4]]);
                        $degrees[] = $degree;
                    }
                }
            }
            return $degrees;
        }

        /**
         * Get Result for this degrees
         */
        public function result(){
            return (($this->programmation + $this->compilation + $this->ai + $this->uml) / 4);
        }

        public static function file(){
            return AutoLoad::env("CSV_NOTE");
        }

        /**
         * Delete the data
         */
        public function delete(){
            $data = CSVHandler::Read(AutoLoad::env('CSV_NOTE'));
            $index = -1;
            $found = false;
            if($data != null){
                foreach($data as $line){
                    $index = $index + 1;
                    if($line[0] == strtolower($this->user_email)){
                        $found = true;
                        break;
                    }
                }
            }
            // Saving to file
            if($found){
                CSVHandler::Remove(AutoLoad::env('CSV_NOTE'), $index);
            }
        }
    }
}