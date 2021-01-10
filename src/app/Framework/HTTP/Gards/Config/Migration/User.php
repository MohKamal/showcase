<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class User extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'users';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('firstname')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('lastname')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('username')->string()->default('user')
            );
            $this->column(
                Column::factory()->name('password')->string()
            );
            $this->column(
                Column::factory()->name('email')->string()
            );
            $this->column(
                Column::factory()->name('phone')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('email_verify')->datetime()->nullable()
            );
            $this->timespan();
        }
    }
}