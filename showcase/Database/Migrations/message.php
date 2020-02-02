<?php
namespace Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class message extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'message';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('name')->string()
            );
            $this->column(
                Column::factory()->name('phone')->string()->nullable()
            );
            $this->timespan();
            $this->softDelete();
        }
    }
}