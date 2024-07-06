<?php

/**
 * Migration: Create Newmod Table
 *
 * Created by: SprintPHP
 * Created on: 2020-11-17 21:04pm
 *
 * @property $dbforge
 */
class Migration_create_newmod_table extends CI_Migration {

    public function up ()
    {
        $fields = [
		'id' => [
			'type' => 'int',
			'unsigned' => true,
			'auto_increment' => true,
			'constraint' => 9,
		],	];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
	    $this->dbforge->create_table('newmods', true, config_item('migration_create_table_attr') );
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_table('newmods');
    }

    //--------------------------------------------------------------------

}