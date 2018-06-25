<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		// Define which kind of assets are needed
		$assets = array();
		$assets['models'] = array(
			// Models
		);
		$assets['helpers'] = array(
			// Helpers
		);
		$assets['libraries'] = array(
			// Libraries
		);

		parent::__construct();
		$this->load->helper('loader');
		load_assets($assets);
	}

	public function index()
	{
		echo 'Hello, World!';
	}
}
