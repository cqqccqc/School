<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$data = array();
		$log_state = array("code"=>400,"message"=>"failed","data"=>array());
		$token = uniqid();
		
		
		
		if(!empty($_POST['email']) && !empty($_POST['spwd']))
		{
			$email =$_POST['email'];
			$spwd = md5($_POST['spwd']);
		
			$this->db->from('user')->where(array('email'=>$email,'spwd'=>$spwd));
			$query=$this->db->get();
		
			if($query->num_rows() > 0)
			{
				$uid = $query->row()->uid;
				$this->db->where('uid', $uid);
				$this->db->update('user', array('uid'=>$uid,'token'=>$token));
				if ($this->db->affected_rows() > 0)
				{
					$log_state['data']=array('uid'=>$uid,'token'=>$token,'email'=>$email);
					$log_state['code']=200;
					$log_state['message']='success';
				}			
			}
		}
		$j_log_state = json_encode($log_state);
		echo $j_log_state;
	}

	// 400表示信息不全，401表示用户已存在，402表示未知错误
	public function register()
	{
		$data = array();
		$reg_state = array("code"=>400,"message"=>"failed","data"=>array());
		#$token = uniqid();
		
		// echo $_GET['email'];
		// echo $_GET['spwd'];
		// echo $_GET['tpwd'];
		// echo $_GET['phone'];
		
		if( !empty($_POST['email']) && !empty($_POST['spwd']) && !empty($_POST['tpwd']) && !empty($_POST['phone']) )
		{
			$email =$_POST['email'];
			$spwd = md5($_POST['spwd']);
			$tpwd = md5($_POST['tpwd']);
			$phone = $_POST['phone'];

			$this->db->from('user')->where(array('email'=>$email,'spwd'=>$spwd));
			$query=$this->db->get();
		
			if($query->num_rows() > 0)
			{
			
				$reg_state['code']=401;
				$reg_state['message']='user is existed';
			}else {
				$registerInfo=array(
					'uid'	=>	null,
					'email'	=>	$email,
					'spwd'	=>	$spwd,
					'tpwd'	=>	$tpwd,
					'phone'	=>	$phone,
					'rtime'	=>	time()
					);

				$this->db->insert('user', $registerInfo);
				if ($this->db->affected_rows() > 0)
				{
					$reg_state['code']=200;
					$reg_state['message']='success';
				} else {
					$reg_state['code']=402;
				}				
			}
		}
		$j_reg_state = json_encode($reg_state);
		echo $j_reg_state;
	}
}
/* End of file login.php */
/* Location: ./application/controllers/app/login.php */