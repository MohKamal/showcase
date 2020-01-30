<?php
namespace Showcase\Framework\Database\SQLite {
    use \Showcase\AutoLoad;
    use \Showcase\Framewok\IO\Debug\Log;

    class SQLiteCreateTable{
        /**
         * PDO object
         * @var \PDO
         */
        private $pdo;
    
        /**
         * connect to the SQLite database
         */
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
    
        /**
         * create tables 
         */
        public function createTables($name, array $params) {
            $query = 'CREATE TABLE IF NOT EXISTS ' . $name . ' (';
            foreach($params as $col => $options){
                $query .= $col;
                foreach($ptions as $p)
                    $query .= ' ' . $p;
                $query .= ' ,';
            }
            $query = rtrim($query, ",");
            $query .= ')';
            Log::print('Query : ' . $query);
            $commands = [$query];
            // execute the sql commands to create new tables
            foreach ($commands as $command) {
                $this->pdo->exec($command);
            }
        }
    
        /**
         * get the table list in the database
         */
        public function getTableList() {
    
            $stmt = $this->pdo->query("SELECT name
                                    FROM sqlite_master
                                    WHERE type = 'table'
                                    ORDER BY name");
            $tables = [];
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $tables[] = $row['name'];
            }
    
            return $tables;
        }
    }
}