<?php
namespace Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;

    class MigrationName extends Table{

        /**
         * Migration details
         */
        function __construct(){
            $this->name = 'MigrationName';
            $this->column('id', ['int', 'not null']);
            $this->column('name', ['varchar(100)', 'not null']);
            $this->column('created_at', ['date']);
        }
    }
}