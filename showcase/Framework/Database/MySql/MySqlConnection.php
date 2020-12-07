<?php
namespace Showcase\Framework\Database\MySql {
    use \Showcase\AutoLoad;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * MySql connnection
     */
    class MySqlConnection {
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
            $servername = AutoLoad::env('DB_HOST');
            $username = AutoLoad::env('DB_USERNAME');
            $password = AutoLoad::env('DB_PASSWORD');
            $dbname = AutoLoad::env('DB_NAME');
            try {
                if ($this->pdo == null) {
                    $this->pdo = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
                        \PDO::ATTR_PERSISTENT => true
                    ]);
                    // set the PDO error mode to exception
                    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                }
                return $this->pdo;
            } catch(\PDOException $e) {
                Log::print("PDOException MySql : MySqlConnection.php line 32 \n => " . $e->getMessage());
            }
            return null;
        }
    }
}