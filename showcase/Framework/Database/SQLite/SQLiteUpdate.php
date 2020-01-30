<?php
namespace Showcase\Framework\Database\SQLite {
    use \Showcase\AutoLoad;
    use \Showcase\Framewok\IO\Debug\Log;
    
    class SQLiteUpdate
    {
        /**
         * PDO object
         * @var \PDO
         */
        private $pdo;
 
        /**
         * Initialize the object with a specified PDO object
         */
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
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