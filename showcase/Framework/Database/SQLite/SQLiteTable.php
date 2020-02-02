<?php
namespace Showcase\Framework\Database\SQLite {
    use \Showcase\AutoLoad;
    use \Showcase\Framework\IO\Debug\Log;

    /**
     * Create tables to database
     */
    class SQLiteTable {

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
                foreach($col['params'] as $p){
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
         * Insert a new task into the tasks table
         * @param type $taskName
         * @param type $startDate
         * @param type $completedDate
         * @param type $completed
         * @param type $projectId
         * @return int id of the inserted task
         */
        public function insertTask($taskName, $startDate, $completedDate, $completed, $projectId)
        {
            $sql = 'INSERT INTO tasks(task_name,start_date,completed_date,completed,project_id) '
                . 'VALUES(:task_name,:start_date,:completed_date,:completed,:project_id)';
 
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
            ':task_name' => $taskName,
            ':start_date' => $startDate,
            ':completed_date' => $completedDate,
            ':completed' => $completed,
            ':project_id' => $projectId,
        ]);
 
            return $this->pdo->lastInsertId();
        }

        /**
         * Mark a task specified by the task_id completed
         * @param type $taskId
         * @param type $completedDate
         * @return bool true if success and falase on failure
         */
        public function completeTask($taskId, $completedDate)
        {
            // SQL statement to update status of a task to completed
            $sql = "UPDATE tasks "
                . "SET completed = 1, "
                . "completed_date = :completed_date "
                . "WHERE task_id = :task_id";
 
            $stmt = $this->pdo->prepare($sql);
 
            // passing values to the parameters
            $stmt->bindValue(':task_id', $taskId);
            $stmt->bindValue(':completed_date', $completedDate);
 
            // execute the update statement
            return $stmt->execute();
        }
    }
}