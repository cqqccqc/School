<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		#var_dump($_SESSION);
		$this->load->view('index');
		
	}
}
/* End of file index.php */
/* Location: ./application/controllers/index.php */