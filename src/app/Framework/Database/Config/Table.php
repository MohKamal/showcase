<?php
namespace  Showcase\Framework\Database\Config {
    use \Showcase\Framework\IO\Debug\Log;
    use \Showcase\Framework\Database\Config\Column;
    
    class Table{

        /**
         * @var string table name
         */
        public $name = "table_name";

        /**
         * Table columns
         * @var array
         */
        public $columns = array();

        /**
         * Add column to the table
         * @var \Showcase\Framework\Database\Config\Column
         * @return boolean
         */
        public function column(Column $column){
            if($column == null)
                return false;
            array_push($this->columns, ["name" => $column->name, "options" => $column->options]);
            return true;
        }

        /**
         * Add time column
         */
        public function timespan(){
            $this->column(
                Column::factory()->name('created_at')->datetime()
            );
            $this->column(
                Column::factory()->name('updated_at')->datetime()
            );
        }
        
        /**
         * Soft deleting from databse
         */
        public function softDelete(){
            $this->column(
                Column::factory()->name('deleted_at')->datetime()
            );
            $this->column(
                Column::factory()->name('active')->bool()
            );
        }
    }
}