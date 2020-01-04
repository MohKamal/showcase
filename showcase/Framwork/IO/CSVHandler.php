<?php
namespace Showcase\Framwork\IO {
    
    class CSVHandler{

        /**
         * Read CSV file and return array
         * @param $filePath csv file path
         */
        static function Read($filePath){
            if(!empty($filePath)){
                if (($fp = fopen($filePath,"r")) !== FALSE){
                    $file = file($filePath);
                    $data = null;
                    foreach ($file as $key => $Ligne) {
                        $Ligne = trim($Ligne);
                        $data[] = explode(',',$Ligne);
                    }
                    fclose($fp);
                    return $data;
                }
            }
            return null;
        }
        
        /**
         * Write data to the file
         */
        static function Write($filePath, array $data){
            if(!empty($filePath)){
                if (($fp = fopen($filePath,"a")) !== FALSE)
                {
                    $dataString = '';
                    for($i = 0; $i < count($data); $i++){
                        $dataString .= $data[$i] . ",";
                    }
                    $dataString = ltrim($dataString, ',');
                    $dataString = substr($dataString, 0, -1);
                    $dataString .= "\n";
                    fputs($fp , $dataString);
                    fclose($fp);
                }
            }
        }

        /**
         * Update a line in file
         */
        static function Update($filePath, array $data, $lineIndex){
                $dataString = '';
                for($i = 0; $i < count($data); $i++){
                    $dataString .= $data[$i] . ",";
                }
                $dataString = ltrim($dataString, ',');
                $dataString = substr($dataString, 0, -1);
                $filename = $filePath;
                $fp = fopen($filename, "r") or die("Couldn't create new file"); 
                $fl = fread ($fp, filesize($filename));

                $fl=explode("\n", $fl);
                $fl[$lineIndex]= $dataString;
                $fl=implode("\n", $fl);
                fclose($fp);

                $fp = fopen($filename, "w+") or die("Couldn't create new file"); 
                fwrite($fp, $fl);
                fclose($fp);
        }

        /**
         * Remove a line in file
         */
        static function Remove($filePath, $lineIndex){
            $filename = $filePath;
            $fp = fopen($filename, "r") or die("Couldn't create new file"); 
            $fl = fread ($fp, filesize($filename));

            $fl=explode("\n", $fl);
            $fl[$lineIndex]= '';
            $fl=implode("\n", $fl);
            fclose($fp);

            $fp = fopen($filename, "w+") or die("Couldn't create new file"); 
            fwrite($fp, $fl);
            fclose($fp);
    }
    }
}