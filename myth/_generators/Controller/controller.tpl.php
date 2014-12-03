<?php

//--------------------------------------------------------------------
// Collect our options
//--------------------------------------------------------------------

$model_string = $model ? "'{$model}'" : 'null';
$lower_model  = trim( strtolower($model_string), "' " );
$lower_controller   = strtolower($controller_name);


//--------------------------------------------------------------------
// Build our Methods
//--------------------------------------------------------------------
// All methods assume that if we have a model given to use, we're
// extending ThemedController since that is the most common use case.
//

/*
 * INDEX
 */
$index_method = '';

if (! empty($model) )
{
	$index_method = <<<EOD
\$this->load->library('table');

		\$offset = \$this->uri->segment( \$this->uri->total_segments() );

        \$rows = \$this->{$lower_model}->limit(\$this->limit, \$offset)
	                 ->as_array()
	                 ->find_all();
        \$this->setVar('rows', \$rows);

\t\t
EOD;
}

/*
 * CREATE
 */
$create_method = '';

if (! empty($model))
{
	$create_method = <<<EOD
\$this->load->helper('form');
		\$this->load->helper('inflector');

		if (\$this->input->method() == 'post')
		{
			\$post_data = \$this->{$lower_model}->prep_data( \$this->input->post() );

			if (\$this->{$lower_model}->insert(\$post_data) )
			{
				\$this->setMessage('Successfully created item.', 'success');
				redirect( site_url('{$lower_controller}') );
			}

			\$this->setMessage('Error creating item. '. \$this->{$lower_model}->error(), 'error');
		}

\t\t
EOD;
}

/*
 * SHOW
 */
$show_method = '';

if (! empty($model))
{
	$show_method = <<<EOD
\$item = \$this->{$lower_model}->find(\$id);

		if (! \$item)
		{
			\$this->setMessage('Unable to find that item.', 'warning');
			redirect( site_url('{$lower_controller}') );
		}

		\$this->setVar('item', \$item);

\t\t
EOD;
}

/*
 * UPDATE
 */
$update_method = '';

if (! empty($model))
{
	$update_method = <<<EOD
\$this->load->helper('form');
		\$this->load->helper('inflector');

		if (\$this->input->method() == 'post')
		{
			\$post_data = \$this->{$lower_model}->prep_data( \$this->input->post() );

			if (\$this->{$lower_model}->update(\$id, \$post_data))
			{
				\$this->setMessage('Successfully updated item.', 'success');
				redirect( site_url('{$lower_controller}') );
			}

			\$this->setMessage('Error updating item. '. \$this->{$lower_model}->error(), 'error');
		}

		\$item = \$this->{$lower_model}->find(\$id);
		\$this->setVar('item', \$item);

\t\t
EOD;
}

/*
 * DELETE
 */
$delete_method = '';

if (! empty($model))
{
	$delete_method = <<<EOD
if (\$this->{$lower_model}->delete(\$id))
		{
			\$this->setMessage('Successfully deleted item.', 'success');
			redirect( site_url('{$lower_controller}') );
		}

		\$this->setMessage('Error deleting item. '. \$this->{$lower_model}->error(), 'error');
		redirect( site_url('tweet') );
\t\t
EOD;
}

//--------------------------------------------------------------------


$fields = '';

if ($themed)
{
	$index_method   .= "\$this->render();";
	$create_method  .= "\$this->render();";
	$show_method    .= "\$this->render();";
	$update_method  .= "\$this->render();";

	$fields = "
	/**
     * Allows per-controller override of theme.
     * @var null
     */
    protected \$theme = null;

    /**
     * Per-controller override of the current layout file.
     * @var null
     */
    protected \$layout = null;

	/**
     * The UIKit to make available to the template views.
     * @var string
     */
    protected \$uikit = '';

    /**
     * The number of rows to show when paginating results.
     * @var int
     */
	protected \$limit = 25;
";
}

//--------------------------------------------------------------------
// Create the class
//--------------------------------------------------------------------

echo "<?php

use {$base_path}{$base_class};

/**
 * {$controller_name} Controller
 *
 * Auto-generated by Sprint on {$today}
 */
class {$controller_name} extends {$base_class} {

	/**
     * The type of caching to use. The default values are
     * set globally in the environment's start file, but
     * these will override if they are set.
     */
    protected \$cache_type      = {$cache_type};
    protected \$backup_cache    = {$backup_cache};

    // If TRUE, will send back the notices view
    // through the 'render_json' method in the
    // 'fragments' array.
    protected \$ajax_notices    = {$ajax_notices};

    // If set, this language file will automatically be loaded.
    protected \$language_file   = {$lang_file};

    // If set, this model file will automatically be loaded.
    protected \$model_file      = '{$lower_model}';

    {$fields}

    //--------------------------------------------------------------------

    /**
     * The default method called. Typically displays an overview of this
     * controller's domain.
     *
     * @return mixed
     */
	public function index()
	{
		{$index_method}
	}

	//--------------------------------------------------------------------

    /**
     * Create a single item.
     *
     * @return mixed
     */
	public function create()
	{
		{$create_method}
	}

	//--------------------------------------------------------------------

    /**
     * Displays a single item.
     *
     * @param  int \$id  The primary_key of the object.
     * @return mixed
     */
	public function show(\$id)
	{
		{$show_method}
	}

	//--------------------------------------------------------------------

    /**
     * Updates a single item.
     *
     * @param  int \$id  The primary_key of the object.
     * @return mixed
     */
	public function update(\$id)
	{
		{$update_method}
	}

	//--------------------------------------------------------------------

	/**
	 * Deletes a single item
	 *
     * @param  int \$id  The primary_key of the object.
     * @return mixed
	 */
	public function delete(\$id)
	{
		{$delete_method}
	}

	//--------------------------------------------------------------------
}
";