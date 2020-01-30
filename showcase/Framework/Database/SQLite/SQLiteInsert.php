<?php
namespace Showcase\Framework\Database\SQLite {
    use \Showcase\AutoLoad;
    use \Showcase\Framewok\IO\Debug\Log;
    
    class SQLiteInsert
    {
        /**
         * PDO object
         * @var \PDO
         */
        private $pdo;
 
        /**
         * Initialize the object with a specified PDO object
         * @param \PDO $pdo
         */
        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }
 
        /**
         * Insert a new project into the projects table
         * @param string $projectName
         * @return the id of the new project
         */
        public function insertProject($projectName)
        {
            $sql = 'INSERT INTO projects(project_name) VALUES(:project_name)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':project_name', $projectName);
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
    }
}