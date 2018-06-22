<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Journal extends CI_Controller {

	public function __construct()
	{
		$assets = array();
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
		$parser_data['title'] = 'Journal';

		$this->parser->parse('journal.html', $parser_data);
	}

	public function get_parser_data()
	{
		$parser_data = array();
		$parser_data['base_url'] = base_url();
		$parser_data['index_page'] = index_page();

		return $parser_data;
	}
}
