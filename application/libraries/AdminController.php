<?php

use Myth\Route;

class AdminController extends \Myth\Controllers\ThemedController {

    use \Myth\Auth\AuthTrait;

    public function __construct()
    {
        parent::__construct();

		// only logged-in users else redirect to login page
        $this->restrict( Route::named('login') );
    }
}
