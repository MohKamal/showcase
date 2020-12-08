<?php
namespace Showcase\Framework\Database\MySql {
    use \Showcase\AutoLoad;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * Create tables to database
     */
    class MySqlTable {

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
            //Log::console("Query: $query");
            // execute the sql commands to create new tables
            foreach ($commands as $command) {
                $this->pdo->exec($command);
            }
            Log::console($name . ' migration added to database succefully');
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
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }

        /**
         * Get all projects
         * @return array
         */
        public function getTable($table, array $columns, $soft=false) {
            $sql = 'SELECT * ' . ' FROM ' . $table;
            if($soft || (!is_null($columns) && !empty($columns)))
                $sql .= ' WHERE ';

            if($soft)
                $sql .= ' deleted_at=null AND active=1';

            if(!is_null($columns) && !empty($columns)){
                if($soft)
                    $sql .= ' AND ';
                foreach($columns as $name => $value){
                    $sql .=  $name .' =:' . $name . ' AND ';
                }
                $sql = rtrim($sql, " AND ");
            }

            $stmt = $this->pdo->prepare($sql);
            $values = array();
            foreach($columns as $name => $value){
                $values[":".$name] = $value;
            }
            $stmt->execute($values);

            $data = [];
            while ($rows = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $data[] = $rows;
            }
            return $data;
        }

        /**
         * Get tasks by the project id
         * @param string table name
         * @param string column name
         * @param mixte column value
         * @return an array of table row
         */
        public function getByColumn($table, $name, $value) {
            // prepare SELECT statement
            $query = 'SELECT * FROM ' . $table . ' WHERE ' . $name .' = :' . $name . ';';
            $stmt = $this->pdo->prepare($query);
            
            $stmt->execute([':'.$name => $value]);
    
            // for storing tasks
            $record = [];
    
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $record = $row;
            }
    
            return $record;
        }

        /**
         * Get tasks by the project id
         * @param string table name
         * @param string column name
         * @param mixte column value
         * @return an array of table row
         */
        public function getByColumns($table, array $columns) {
            // prepare SELECT statement
            $query = 'SELECT * FROM ' . $table . ' WHERE ';
            foreach($columns as $name => $value){
                $query .=  $name .' =:' . $name . ' AND ';
            }
            $query = rtrim($query, " AND ");

            $stmt = $this->pdo->prepare($query);
            $values = array();
            foreach($columns as $name => $value){
                $values[":".$name] = $value;
            }
            $stmt->execute($values);
    
            // for storing tasks
            $record = [];
    
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $record = $row;
            }
    
            return $record;
        }

        /**
         * Insert a new project into the projects table
         * @param string $projectName
         * @return the id of the new project
         */
        public function insertToTable($table, $data)
        {
            $sql = 'INSERT INTO ' . $table . '(';
            foreach($data as $key => $value){
                $sql .= $key . ', ';
            }

            $sql = rtrim($sql, ", ");
            $sql .= ') VALUES(';
            foreach($data as $key => $value){
                $sql .= ':' . $key . ', ';
            }
            $sql = rtrim($sql, ", ");
            $sql .= ')';
            $stmt = $this->pdo->prepare($sql);
            foreach($data as $key => $value){
                $stmt->bindValue(":".$key, $value);
            }
            
            $stmt->execute();
            return $this->pdo->lastInsertId();
        }

        /**
         * Mark a task specified by the task_id completed
         * @param string table name
         * @param array id with column name and value
         * @param array other columns with the names and values
         * @return bool true if success and falase on failure
         */
        public function update($table,array $id,array $data)
        {
            // SQL statement to update status of a task to completed
            $sql = "UPDATE " . $table . " SET ";
            foreach($data as $key => $value){
                $sql .= $key . "=:".$key . ", ";
            }
            $sql = rtrim($sql, ", ");
            $sql .= " WHERE " . $id["name"] . "=:". $id["name"] . ";";
            $stmt = $this->pdo->prepare($sql);
            // passing values to the parameters
            foreach($data as $key => $value){
                $stmt->bindValue(':'.$key, $value);
            }
            $stmt->bindValue(':'.$id["name"], $id["value"]);
 
            // execute the update statement
            return $stmt->execute();
        }

        /**
         * Delete a task by task id
         * @param int $taskId
         * @return int the number of rows deleted
         */
        public function deleteRow($table, array $id) {
            $sql = 'DELETE FROM ' . $table . ' WHERE ' . $id["name"] . '=:' . $id["name"];
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':'.$id["name"], $id["value"]);
    
            $stmt->execute();
    
            return $stmt->rowCount();
        }
    }
}