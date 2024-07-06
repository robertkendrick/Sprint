<?php

/**
 * Migration: Create Mynewmodule Table
 *
 * Created by: SprintPHP
 * Created on: 2020-11-19 14:45pm
 *
 * @property $dbforge
 */
class Migration_create_mynewmodule_table extends CI_Migration {

    public function up ()
    {
        $fields = [
	];

        $this->dbforge->add_field($fields);
	    $this->dbforge->create_table('mynewmodules', true, config_item('migration_create_table_attr') );
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_table('mynewmodules');
    }

    //--------------------------------------------------------------------

}