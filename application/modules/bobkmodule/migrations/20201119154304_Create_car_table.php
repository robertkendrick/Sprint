<?php

/**
 * Migration: Create Car Table
 *
 * Created by: SprintPHP
 * Created on: 2020-11-19 15:43pm
 *
 * @property $dbforge
 */
class Migration_create_car_table extends CI_Migration {

    public function up ()
    {
        $fields = [
		'id' => [
			'type' => 'int',
			'unsigned' => true,
			'auto_increment' => true,
			'constraint' => 9,
		],		'make' => [
			'type' => 'varchar',
			'constraint' => 100,
			'null' => true,
			'default' => '',
		],		'descr' => [
			'type' => 'text',
			'null' => true,
		],		'deleted' => [
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0,
		],		'created_on' => [
			'type' => 'datetime',
		],		'modified_on' => [
			'type' => 'datetime',
		],	];

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
	    $this->dbforge->create_table('cars', true, config_item('migration_create_table_attr') );
    
    }

    //--------------------------------------------------------------------

    public function down ()
    {
        $this->dbforge->drop_table('cars');
    }

    //--------------------------------------------------------------------

}