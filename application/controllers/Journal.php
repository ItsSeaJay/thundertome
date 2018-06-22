<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Journal extends CI_Controller {

	public function __construct()
	{
		// Define which kind of assets are needed
		$assets = array();
		$assets['models'] = array(
			'application_model',
			'entry_model'
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
		$parser_data['title'] = 'Journal';
		$parser_data['entries'] = $this->get_entries();

		$this->parser->parse('journal.html', $parser_data);
	}

	public function entries($year = '')
	{
		// Determine which entries should be fetched from the database
		$where = array(
			'year' => $year
		);

		$parser_data = $this->get_parser_data();
		$parser_data['title'] = 'Journal';
		$parser_data['entries'] = $this->entry_model->get_where($where);

		if (count($parser_data['entries']) > 0)
		{
			$this->parser->parse('journal.html', $parser_data);
		}
		else
		{
			echo 'No entries found...';
		}
	}

	private function get_parser_data()
	{
		$parser_data = array();
		$parser_data['base_url'] = base_url();
		$parser_data['index_page'] = index_page();
		$parser_data['stylesheets'] = $this->get_stylesheets($parser_data);

		return $parser_data;
	}

	private function get_stylesheets($parser_data = array())
	{
		$stylesheets = $this->parser->parse(
			'stylesheets.html',
			$parser_data,
			TRUE // Return result as a string
		);

		return $stylesheets;
	}

	private function get_entries($year = '', $month = '', $day = '')
	{
		$entries = $this->entry_model->get_all();

		foreach ($entries as &$entry)
		{
			// Change the values of the entry to better suit the parser
			$entry['date'] = date('d.m.Y', strtotime($entry['date']));
		}

		return $entries;
	}
}
