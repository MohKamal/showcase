<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class rememberMe extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'remembers';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('user_id')->string()
            );
            $this->column(
                Column::factory()->name('token')->string()
            );
            $this->timespan();
        }
    }
}