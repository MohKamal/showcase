<?php
namespace Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class users extends Table{

        /**
         * Migration details
         */
        function handle(){
            $this->name = 'users';
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