<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$email =$_GET['email'];
		$spwd = md5($_GET['spwd']);
		#echo $uid.'\n'.$token;	
		
		$log_state = array("code"=>"400","message"=>"","data"=>array());
		$log_state["data"]=array(1,2,3);
		#var_dump($log_state);
		$j_log_state = json_encode($log_state);
		echo $j_log_state;
	}
	
	public function login()
	{	
		$data = array();
		$log_state = array("code"=>"400","message"=>"","data"=>array());
		$token = uniqid();
		
		$email =$_GET['email'];
		$spwd = md5($_GET['spwd']);
		
		$this->db->from('user')->where(array('email'=>$email,'spwd'=>$spwd));
		$query=$this->db->get();
		
		if($query->num_rows() > 0)
		{
			$uid = $query->row()->uid;
			$this->db->where('uid', $uid);
			$this->db->update('user', array('uid'=>$uid,'token'=>$token));
			
			echo $uid.'\n'.$token;	
		} else {
		
		}
	}
}
/* End of file json.php */
/* Location: ./application/controllers/app/json.php */