<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		// Define which kind of assets are needed
		$assets = array();
		$assets['models'] = array(
			'application_model',
			'author_model'
		);
		$assets['helpers'] = array(
			'url'
		);
		$assets['libraries'] = array(
			'parser'
		);

		parent::__construct();
		$this->load->helper('loader');
		load_assets($assets);
	}

	public function index()
	{
		$parser_data = $this->get_parser_data();

		$this->parser->parse('login/form.html', $parser_data);
	}

	public function request()
	{
		if (isset($_POST['username']) && isset($_POST['password']))
		{
			echo 'Good job.';
		}
	}

	private function get_parser_data()
	{
		$parser_data = array();
		$parser_data['base_url'] = base_url();
		$parser_data['index_page'] = index_page();
		$parser_data['site_url'] = site_url();
		$parser_data['application_name'] = $this->application_model->get_name();

		return $parser_data;
	}

	private function get_stylesheets()
	{

	}
}
