<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry_model extends CI_Model {

	private $table = 'entries';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all($order = 'DESC')
	{
		$this->db->order_by('date', $order);
		$query = $this->db->get($this->table);
		$result = $query->result_array();

		return $result;
	}

	public function get_where($where = array())
	{
		$this->db->where($where);
		$query = $this->db->get($this->table);
		$result = $query->result_array();

		return $result;
	}
}
