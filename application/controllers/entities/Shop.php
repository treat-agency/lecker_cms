<?php defined('BASEPATH') or exit('No direct script access allowed');

require(APPPATH . 'controllers/Backend.php');

class Shop extends Backend
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('entities/Content_model', 'cm');
		$this->load->model('Frontend_model', 'fm');
	}


}