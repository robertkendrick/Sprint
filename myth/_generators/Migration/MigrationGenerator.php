<?php
/**
 * Sprint
 *
 * A set of power tools to enhance the CodeIgniter framework and provide consistent workflow.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package     Sprint
 * @author      Lonnie Ezell
 * @copyright   Copyright 2014-2015, New Myth Media, LLC (http://newmythmedia.com)
 * @license     http://opensource.org/licenses/MIT  (MIT)
 * @link        http://sprintphp.com
 * @since       Version 1.0
 */

use Myth\CLI as CLI;

class MigrationGenerator extends \Myth\Forge\BaseGenerator {

	// The auto-determined action
	protected $action = null;

	// The table we're using, if any
	protected $table = null;

	// The column we're using, if any
	protected $column = null;

	// The fields to create for making new tables.
	protected $fields = [];

	// The field name to be used as a primary key
	protected $primary_key  = null;

	protected $defaultSizes = [
		'tinyint'   => 1,
		'int'       => 9,
		'bigint'    => 20,
		'char'      => 20,
		'varchar'   => 255,
	];

	protected $defaultValues = [
		'tinyint'   => 0,
		'mediumint' => 0,
		'int'       => 0,
		'bigint'    => 0,
		'float'     => 0.0,
		'double'    => 0.0,
		'char'      => NULL,
		'varchar'   => NULL,
	];

	protected $defaultNulls = [
		'char'      => true,
		'varchar'   => true,
		'text'      => true,
	];

	protected $map = [
		'string'    => 'varchar',
		'number'    => 'int'
	];

	protected $allowedActions = [
		'create', 'add', 'remove'
	];

	protected $actionMap = [
		'make'      => 'create',
		'insert'    => 'add',
		'drop'      => 'remove',
		'delete'    => 'remove'
	];

	//--------------------------------------------------------------------

	public function run($segments=[], $quiet=false)
	{
//		var_dump($segments);
		$name = array_shift( $segments );

		if ( empty( $name ) )
		{
			$name = CLI::prompt( 'Migration name' );
		}

		// Format to CI Standards
		$name = str_replace('.php', '', strtolower( $name ) );

//		echo "108: \$name = $name \n";
		$this->detectAction($name);

		$this->collectOptions( $name, $quiet );

		$data = [
			'name'              => $name,
			'clean_name'        => ucwords(str_replace('_', ' ', $name)),
			'today'             => date( 'Y-m-d H:ia' ),
			'fields'            => trim( $this->stringify( $this->fields ), ', '),
			'raw_fields'        => $this->fields,
			'action'            => $this->action,
			'table'             => $this->table,
			'primary_key'       => $this->primary_key,
			'column'            => $this->column
			
		];

		if (! empty($this->column) && array_key_exists($this->column, $this->fields))
		{
//			var_dump($this->column, $this->fields);

			$data['column_string'] = trim( $this->stringify($this->fields[$this->column]), ', ');
//			var_dump($data['column_string']);
		}

		$this->load->library('migration');

		// todo *****************  Allow different migration "types"
		$type = 'app';

		if (! empty($this->module))
		{
			$type = 'mod:'. $this->module;
		}
		$destination = $this->migration->determine_migration_path($type, true);

		$file = $this->migration->make_name($name);

		$destination = rtrim($destination, '/') .'/'. $file;

		if (! $this->copyTemplate( 'migration', $destination, $data, true) )
		{
			CLI::error('Error creating seed file.');
		}

		return true;
	}

	protected function getTableName($startIndex, $segments)
	{
		if ( ($index2 = array_search('table', $segments)) !== FALSE ) {
			$startIndex++;
			$this->table = implode('_', array_slice($segments, $startIndex, $index2-$startIndex) );
			return TRUE;
		}
		return FALSE;
	}

	//--------------------------------------------------------------------

	/**
	 * Examines the name of the migration and attempts to determine
	 * the correct action to build the migration around, based on the first
	 * word of the name.
	 *
	 * Examples:
	 *  'create_user_table'         		action = 'create', table = 'user'
	 *  'add_name_to_user_table     		action = 'add', table = 'user'
	 *  add_rental_column_to_posts_table	action = 'add', table = 'posts'
	 * @param $name
	 */
		// (v4) It works -- but its a mess. Re-visist.
		public function detectAction($name)
		{
			$segments = explode('_', $name);
			$action = trim(strtolower(array_shift($segments)));
	
			// Is the action a convenience mapping?
			if (array_key_exists($action, $this->actionMap))
			{
				$action = $this->actionMap[$action];
			}
	
			if (! in_array($action, $this->allowedActions))
			{
				return;
			}
	
			$this->action = $action;
	
			// Are we referencing a create?
			if ( $action === 'create' ) {
	//			$this->load->helper('inflector');
				
				// The name of the table is assumed to be between
				// $index1 and $index2 found.
	//			$this->table = plural( implode('_', array_slice($segments, 0, $index) ) );
				if ( $this->getTableName(-1, $segments) === FALSE ) {
					echo "syntax error - missing keyword {table} \n";	
				}
	//				throw new Exception("syntax error - missing keyword {table}");
			}
	
			// Are we referencing an add?
			if ( $action === 'add' ) {
	//			echo "processing a column .....\n";
				$index2 = array_search('column', $segments);
	
				if ( ($index1 = array_search('to', $segments)) !== FALSE) {
					if ($index2 === FALSE) {	// no {column} index
						$index2 = $index1;
					}	
					$this->column = implode('_', array_slice($segments, 0, $index2));	
					if ( $this->getTableName($index1, $segments) === FALSE ) {
						echo "syntax error - missing keyword {table} \n";	
					}
				}
				else {	// no {to} index
					if($index2 !== FALSE) {	// we have a {column} index
						$index1 = $index2;	// save column index to use as no {to} index
						$this->column = implode('_', array_slice($segments, 0, $index1));	
					}
					else {		//we dont have a {column} or a {to} index
						throw new Exception("missing keyword {column} or {to} must have one or both\n");
					}	
					if ( $this->getTableName($index1, $segments) === FALSE ) {
						echo "syntax error - missing keyword {table} \n";	
					}
				}
			}
	
			// Are we referencing a remove/column?
			if ( $action === 'remove' ) {
	//			echo "processing a remove/column .....\n";
				if ( ($index2 = array_search('column', $segments)) !== FALSE ) {
					$this->column = implode('_', array_slice($segments, 0, $index2) );
				}
				else echo "syntax error - missing keyword {column} \n";
				
				if ( ($index1 = array_search('from', $segments)) !== FALSE ) {	
					if ( $this->getTableName($index1, $segments) === FALSE ) {
						echo "syntax error - missing keyword {table} \n";	
					}
				}
				else {
					$index1 = $index2;	// save column index to use as no {from} index
					if ( $this->getTableName($index1, $segments) === FALSE ) {
						echo "syntax error - missing keyword {table} \n";	
					}
				}
			}
		}
	
	//--------------------------------------------------------------------

	public function collectOptions($name, $quiet=false)
	{
		$options = CLI::getOptions();

		// Use existing db table?
		if (array_key_exists('fromdb', $options) )
		{
			$this->readTable($this->table);
		}
		// Otherwise try to use any fields from the CLI
		else
		{
			$fields = ! empty($options['fields']) ? $options['fields'] : null;
			if (empty($fields) && $quiet)
			{
				return;
			}

/* orig code
			$fields = empty( $fields ) ?
				CLI::prompt( 'Fields? (name:type)' ) :
				$options['fields'];
			$this->fields = $this->parseFields( $fields );
*/
//bobk: add
			if (empty ($fields) && $this->action === 'add') {
				$fields = $this->column . ':' . CLI::prompt("Enter column's type and length(optional) for $this->column (type:length)" );
			}
			else {
				$fields = empty( $fields ) ?
				CLI::prompt( 'Fields? (name:type)' ) :
				$options['fields'];
			}
			$this->fields = $this->parseFields( $fields );				
//end bobk add
		}
	}
	//--------------------------------------------------------------------

	/**
	 * Parses a string containing 'name:type' segments into an array of
	 * fields ready for $dbforge;
	 *
	 * @param $str
	 *
	 * @return array
	 */
	public function parseFields($str)
	{
        if (empty($str))
        {
	        return;
        }

		$fields = [];
		$segments = explode(' ', $str);

		if (! count($segments))
		{
			return $fields;
		}

		foreach ($segments as $segment)
		{
			$pop = [null, null, null];
			list($field, $type, $size) = array_merge( explode(':', $segment), $pop);
			$type = strtolower($type);

			// Is type one of our convenience mapped items?
			if (array_key_exists($type, $this->map))
			{
				$type = $this->map[$type];
			}

			$f = [ 'type' => $type ];

			// Creating a primary key?
			if ($type == 'id')
			{
				$f['type'] = 'int';
				$size = empty($size) ? 9 : $size;
				$f['unsigned'] = true;
				$f['auto_increment'] = true;

				$this->primary_key = $field;
			}

			// Constraint?
			if (! empty($size))
			{
				$f['constraint'] = (int)$size;
			}
			else if (array_key_exists($type, $this->defaultSizes))
			{
				$f['constraint'] = $this->defaultSizes[$type];
			}

			// NULL?
			if (array_key_exists($type, $this->defaultNulls))
			{
				$f['null'] = true;
			}

			// Default Value?
			if (array_key_exists($type, $this->defaultValues))
			{
				$f['default'] = $this->defaultValues[$type];
			}

			$fields[$field] = $f;
		}

//		var_dump($fields);
		
		return $fields;
	}

	//--------------------------------------------------------------------

	/**
	 * Reads the fields from an existing table and fills out our
	 * $fields array and $primary key information.
	 *
	 * @param $table
	 */
	protected function readTable($table)
	{
		// Database loaded?
		if (empty($this->db))
		{
			$this->load->database();
		}

		// Table exists?
		if (! $this->db->table_exists($table))
		{
			return false;
		}

		$fields = $this->db->field_data($table);

		// Any fields?
		if (! is_array($fields) || ! count($fields))
		{
			return false;
		}

		$new_fields = [];

		foreach ($fields as $field)
		{
			$f = [ 'type' => $field->type ];

			// Constraint
			if (! empty($field->max_length))
			{
				$f['constraint'] = $field->max_length;
			}
			else if (array_key_exists($field->type, $this->defaultSizes))
			{
				$f['constraint'] = $this->defaultSizes[ $field->type ];
			}

			// Default
			if (! empty($field->default)) $f['default'] = $field->default;

			// Primary Key?
			if (! empty($field->primary_key) && $field->primary_key == 1)
			{
				$this->primary_key = $field->name;
				$f['auto_increment'] = true;
				$f['unsigned'] = true;
			}

			$new_fields[ $field->name ] = $f;
		}

		$this->fields = $new_fields;
	}

	//--------------------------------------------------------------------

}
