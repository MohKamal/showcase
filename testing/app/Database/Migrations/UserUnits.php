<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;
    use \Showcase\Framework\Database\Config\Foreign;

    class UserUnits extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'userunits';
            $this->order = 4;
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('user_id')->int()
            );
            $this->column(
                Column::factory()->name('unit_id')->int()
            );
            $this->timespan();
        }

        function handleForeign() {
            $this->foreign(
                Foreign::factory()->column('user_id')->model('User')->updateCascade()
            );
            $this->foreign(
                Foreign::factory()->column('unit_id')->model('Unit')->updateCascade()
            );
        }
    }
}