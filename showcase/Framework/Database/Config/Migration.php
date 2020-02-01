<?php
namespace Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class MigrationName extends Table{

        /**
         * Migration details
         */
        function handle(){
            $this->name = 'MigrationName';
            $this->column(
                Column::factory()->name('id')->int()
            );
            $this->column(
                Column::factory()->name('name')->string()
            );
            $this->column(
                Column::factory()->name('phone')->string()->nullable()
            );
        }
    }
}