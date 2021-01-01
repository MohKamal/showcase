<?php
namespace Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class Unit extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'unites';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('name')->string()
            );
            $this->column(
                Column::factory()->name('value')->double()
            );
            $this->timespan();
            $this->softDelete();
        }
    }
}