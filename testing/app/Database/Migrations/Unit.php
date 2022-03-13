<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Database\Config\Foreign;

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

        function handleForeign() {
            $this->foreign(
                Foreign::factory()->model('User')->toOne('userunits', 'unit_id', 'user_id')->dontAddItToQuery()
            );
        }
    }
}