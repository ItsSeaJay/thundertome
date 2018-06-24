<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry_model extends CI_Model {

	private $table = 'entries';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function total_entries()
	{
		return $this->db->count_all($this->table);
	}

	public function get_entry_page($page = 0, $limit = 8, $order = 'DESC')
	{
		$this->db->order_by('date', $order);
		$this->db->limit($limit, $page * $limit);
		$query = $this->db->get($this->table);
		$result = $query->result_array();

		return $result;
	}

	public function get_entry($where = array())
	{
		$this->db->where($where);
		$query = $this->db->get($this->table);
		$result = $query->row_array();

		return $result;
	}

	public function get_entries($where = array(), $order = 'DESC')
	{
		$this->db->where($where);
		$this->db->order_by('date', $order);
		$query = $this->db->get($this->table);
		$result = $query->result_array();

		return $result;
	}
}
