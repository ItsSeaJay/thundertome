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
			'url',
			'security'
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
		$response = $this->prepare_response();

		if (isset($_POST['username']) && isset($_POST['password']))
		{
			// Find the author through the username
			$where = array();
			$where['username'] = $_POST['username'];
			$author = $this->author_model->get_author($where);
			
			if (!empty($author))
			{
				if (password_verify($_POST['password'], $author['password']))
				{
					$response['success'] = TRUE;
					$response['message'] = 'Authentication successful';
				}
				else
				{
					$response['message'] = 'Password is incorrect';
				}
			}
			else
			{
				$response['message'] = 'Username is incorrect';
			}
		}
		else
		{
			$response['message'] = 'No post data sent';
		}

		$json = json_encode($response);
		echo $json;
	}

	private function prepare_response()
	{
		$response = array();
		$response['success'] = FALSE;
		$response['message'] = 'No error message specified';
		$response['csrf_hash'] = $this->security->get_csrf_hash();

		return $response;
	}

	private function get_parser_data()
	{
		$parser_data = array();
		$parser_data['base_url'] = base_url();
		$parser_data['index_page'] = index_page();
		$parser_data['site_url'] = site_url();
		$parser_data['csrf_token_name'] = $this->security->get_csrf_token_name();
		$parser_data['csrf_hash'] = $this->security->get_csrf_hash();
		$parser_data['application_name'] = $this->application_model->get_name();
		$parser_data['stylesheets'] = $this->get_stylesheets($parser_data);

		return $parser_data;
	}

	private function get_stylesheets($parser_data = array())
	{
		$stylesheets = $this->parser->parse(
			'stylesheets.html',
			$parser_data,
			TRUE
		);

		return $stylesheets;
	}
}
