<?php
namespace  Showcase\Framework\Database\Interfaces {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * Database connection
     */
    interface DatabaseConnection {
    
        /**
         * return in instance of the PDO object that connects to the SQLite database
         * @return \PDO
         */
        public function connect();
    }
}