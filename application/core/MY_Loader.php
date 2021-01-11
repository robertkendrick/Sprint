<?php

require_once APPPATH .'third_party/HMVC/Loader.php';

class MY_Loader extends HMVC_Loader {

    /**
     * Does the same thing that load->view does except ensures that the
     * view file is treated as a path so that it can be found outside of
     * the standard view paths.
     *
     * @param $view
     * @param array $vars
     * @param bool $return
     * @return object|void
     */
    public function view_path($view, $vars = array(), $return = FALSE)
    {
        $view .= '.php';

        // If the file can't be found, then use the regular view method...
        if (file_exists($view)) {
            return $this->_ci_load(array('_ci_path' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
        }
        else {
            return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
        }
    }

    // --------------------------------------------------------------------

//bobk added
	/**
	 * CI Object to Array translator
	 *
	 * Takes an object as input and converts the class variables to
	 * an associative array with key/value pairs.
	 *
	 * @param	object	$object	Object data to translate
	 * @return	array
	 */
	protected function _ci_object_to_array($object)
	{
		return is_object($object) ? get_object_vars($object) : $object;
	}

	// --------------------------------------------------------------------

}
