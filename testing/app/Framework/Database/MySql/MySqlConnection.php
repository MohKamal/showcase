<?php
namespace  Showcase\Framework\Database\MySql {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\Interfaces\DatabaseConnection;

    /**
     * MySql connnection
     */
    class MySqlConnection implements DatabaseConnection {
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
            $servername = VarLoader::env('DB_HOST');
            $username = VarLoader::env('DB_USERNAME');
            $password = VarLoader::env('DB_PASSWORD');
            $dbname = VarLoader::env('DB_NAME');
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
                Log::print("PDOException MySql : MySqlConnection.php line 35 \n => " . $e->getMessage());
            }
            return null;
        }
    }
}