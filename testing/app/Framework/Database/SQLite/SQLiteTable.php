<?php
namespace  Showcase\Framework\Database\SQLite {
    use \Showcase\Framework\Initializer\VarLoader;
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\Interfaces\DatabaseAdapter;

    /**
     * Create tables to database
     */
    class SQLiteTable implements DatabaseAdapter {

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
        public function createTables($name, array $columns) {
            $query = 'CREATE TABLE IF NOT EXISTS ' . $name . ' (';
            foreach($columns as $col){
                $query .= $col['name'];
                foreach($col['options'] as $p){
                    $query .= ' ' . $p;
                }
                $query .= ', ';
            }
            $query = rtrim($query, ", ");
            $query .= ')';
            $commands = [$query];
            // execute the sql commands to create new tables
            foreach ($commands as $command) {
                $this->pdo->exec($command);
            }
            Log::console($name . " migration added to database succefully\n", 'success');
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

        /**
         * Execute a custom query
         * @return array
         */
        public function query($query) {
            if(empty($query))
                return false;
            $stmt = $this->pdo->query($query);
            $data = [];
            if (strpos($query, "SELECT") !== false) {
                if (strpos($query, "COUNT") === false) {
                    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                        $data[] = $row;
                    }
                    return $data;
                }else{
                    return $stmt->fetchColumn();
                }
            }

            return $this->pdo->lastInsertId();
        }
    }
}