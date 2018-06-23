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

	public function entries($year = '', $month = '', $day = '')
	{
		$parser_data = $this->get_parser_data();

		// Figure out which action should be taken based on the uri
		$actions = array(
			1 => array(
				'year' => $year
			),
			2 => array(
				'year' => $year,
				'month' => $month
			),
			3 => array(
				'year' => $year,
				'month' => $month,
				'day' => $day
			)
		);
		$action = $actions[$this->uri->total_segments()];

		// Get the entries based on the action chosen above
		$parser_data['entries'] = $this->entry_model->get_where($action);

		// Build the page title based on the URI
		$titles = array(
			1 => 'Entries from ' . $year,
			2 => 'Entries from ' . $month . $year,
			3 => 'Entries from ' . $day . $month . $year
		);
		$parser_data['title'] = $titles[$this->uri->total_segments()];

		if (count($parser_data['entries']) > 0)
		{
			$this->parser->parse('journal.html', $parser_data);
		}
		else
		{
			show_404();
		}
	}

	public function entry($year = '', $month = '', $day = '', $uri = '')
	{
		$where = array();
		$where['year'] = $year;
		$where['month'] = $month;
		$where['day'] = $day;
		$where['uri'] = $uri;
		$parser_data = $this->get_parser_data($where);

		$this->parser->parse('entry.html', $parser_data);
	}

	private function get_parser_data($where = array())
	{
		$parser_data = $this->entry_model->get($where) ?? array();
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
