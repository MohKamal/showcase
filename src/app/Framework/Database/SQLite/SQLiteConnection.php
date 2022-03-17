<?php
namespace  Showcase\Framework\Database\SQLite {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\Interfaces\DatabaseConnection;
    use \Showcase\Framework\HTTP\Exceptions\DatabaseException;
    use \Showcase\Framework\HTTP\Exceptions\ExecptionEnum;

    /**
     * SQLite connnection
     */
    class SQLiteConnection implements DatabaseConnection {
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
                    $base_dir = dirname(__FILE__) . '/../../../Database/SQLite/';
                    if (!file_exists($base_dir)) {
                        mkdir($base_dir, 0777, true);
                    }
                    $dbfile = $base_dir . VarLoader::env('DB_HOST');
                    $this->pdo = new \PDO("sqlite:" . $dbfile);
                }
                return $this->pdo;
            } catch (\PDOException $e) {
                throw new GeneralException("PDOException SQLite :  " . $e->getMessage(), ExecptionEnum::ERROR_DATABASE_CONNECTION);
            }
            return null;
        }
    }
}