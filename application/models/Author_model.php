<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Author_model extends CI_Model {

	private $table = 'authors';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_author($where = array())
	{
		$this->db->where($where);
		$query = $this->db->get($this->table);
		$row = $query->row_array();

		return $row;
	}
}
