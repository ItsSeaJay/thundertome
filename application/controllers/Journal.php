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

		// Show different entries depending on what parameters have been specified
		switch ($this->uri->total_segments())
		{
			// Only the year has been entered
			case 1:
				$where = array();
				$where['year'] = $year;

				// Get all the entries from the specified year
				$parser_data['entries'] = $this->entry_model->get_entries($where);
				// Change the title accordingly
				$parser_data['title'] = 'Entries from ' . $year;

				if (count($parser_data['entries']) > 0)
				{
					$this->parser->parse('journal.html', $parser_data);
				}
				else
				{
					show_404();
				}
				break;

			// The year and the month has been entered, but not the day
			case 2:
				$where = array();
				$where['year'] = $year;
				$where['month'] = $month;
				$date = $year . '-' . $month;

				// Get all the entries from the specified year
				$parser_data['entries'] = $this->entry_model->get_entries($where);
				// Change the title accordingly
				$parser_data['title'] = 'Entries from ' . date('M Y', strtotime($date));

				if (count($parser_data['entries']) > 0)
				{
					$this->parser->parse('journal.html', $parser_data);
				}
				else
				{
					show_404();
				}
				break;

			// The year, the month and the day have been entered
			case 3:
				$where['year'] = $year;
				$where['month'] = $month;
				$where['day'] = $day;
				$date = $year . '-' . $month . '-' . $day;

				// Get all the entries from the specified year
				$parser_data['entries'] = $this->entry_model->get_where($where);
				// Change the title accordingly
				$parser_data['title'] = 'Entries from ' . date('d M Y', strtotime($date));

				if (count($parser_data['entries']) > 0)
				{
					$this->parser->parse('journal.html', $parser_data);
				}
				else
				{
					show_404();
				}
				break;
			
			default:
				show_404();
				break;
		}
	}

	public function entry($year = '', $month = '', $day = '', $uri = '')
	{
		$where = array();
		$where['year'] = $year;
		$where['month'] = $month;
		$where['day'] = $day;
		$where['uri'] = $uri;
		$parser_data = $this->get_parser_data();

		$this->parser->parse('entry.html', $parser_data);
	}

	private function get_parser_data($where = array())
	{
		$parser_data = $this->entry_model->get_entry($where) ?? array();
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
		$entries = $this->entry_model->get_entries();

		foreach ($entries as &$entry)
		{
			// Change the values of the entry to better suit the parser
			$entry['date'] = date('d.m.Y', strtotime($entry['date']));
			$entry['base_url'] = base_url();
			$entry['index_page'] = index_page();
		}

		return $entries;
	}
}
