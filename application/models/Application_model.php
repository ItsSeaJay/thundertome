<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application extends CI_Model {

    private $table_name = 'application';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
}
