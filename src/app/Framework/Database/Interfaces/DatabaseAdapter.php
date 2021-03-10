<?php
namespace  Showcase\Framework\Database\Interfaces {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * Create tables to database
     */
    interface DatabaseAdapter {
    
        /**
         * create tables 
         */
        public function createTables($name, array $columns);
    
        /**
         * get the table list in the database
         */
        public function getTableList();

        /**
         * Execute a custom query
         * @return array
         */
        public function query($query);
    }
}