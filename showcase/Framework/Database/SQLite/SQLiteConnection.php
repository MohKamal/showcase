<?php
namespace Showcase\Framework\Database\SQLite {
    use \Showcase\AutoLoad;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * SQLite connnection
     */
    class SQLiteConnection {
        /**
         * PDO instance
         * @var type 
         */
        private $pdo;
    
        /**
         * return in instance of the PDO object that connects to the SQLite database
         * @return \PDO
         */
        public function connect() {
            try {
                if ($this->pdo == null) {
                    $dbfile = dirname(__FILE__) . '/../../../Database/SQLite/' . AutoLoad::env('DB_HOST');
                    $this->pdo = new \PDO("sqlite:" . $dbfile);
                }
                return $this->pdo;
            } catch (\PDOException $e) {
                Log::print("PDOException SQLite : SQLiteConnection.php line 27 \n => " . $e->getMessage());
            }
            return null;
        }
    }
}