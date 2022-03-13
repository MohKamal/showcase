<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Database\Config\Foreign;

    class rememberMe extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'remembers';
            $this->order = 2;
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
        
        /**
        * Migration Relation details
        * @return array of foreign relations
        */
       function handleForeign(){
            $this->foreign(
                Foreign::factory()->column('user_id')->model('User')->deleteCascade()
            );
       }
    }
}