<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends CI_Model {

    private $table = 'application';

    public function __construct()
    {
		parent::__construct();
		$this->load->database();
    }

    public function get_name()
    {
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		$name = $result['name'];

		return $name;
    }

    public function get_version_number()
    {
		$query = $this->db->get($this->table);
		$result = $query->result_array();
		$version_number = $result['major_version'] .
		                  '.' .
		                  $result['minor_version'] .
		                  '.' .
		                  $result['patch'];
    }
}
