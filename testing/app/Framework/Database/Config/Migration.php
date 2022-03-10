<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Database\Config\Foreign;

    class MigrationName extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'MigrationName';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('name')->string()
            );
            $this->column(
                Column::factory()->name('username')->string()->default('user')
            );
            $this->column(
                Column::factory()->name('phone')->string()->nullable()
            );
            $this->timespan();
        }
    }
}