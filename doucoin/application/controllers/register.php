<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
	}

	public function index()
	{	
		$session_uid = $this->session->userdata('uid');
		if (!empty($session_uid))
		{
			header('Location: '.base_url());
		}
		$this->load->view('register');
	}
	
	public function registering()
	{	
		$session_uid = $this->session->userdata('uid');
		if (empty($session_uid))
		{
			header('Location: '.base_url());
		}
		
		$has_error	=	false;
		$error_msg 	=	array();
		
		$email	=	trim($_POST['email']);
		$phone	=	trim($_POST['phone']);
		$spwd	=	trim($_POST['spwd']);
		$cspwd	=	trim($_POST['cspwd']);
		$tpwd	=	trim($_POST['tpwd']);
		$ctpwd	=	trim($_POST['ctpwd']);
		#$vcode	=	trim($_POST['vcode']);
		
		$error_msg['email']		=	$email;
		$error_msg['phone']		=	$phone;
		
		if($email==""||$phone==""||$spwd==""||$cspwd==""||$tpwd==""||$ctpwd=="")
		{
			$has_error=true;
			$error_msg['filled']='<span style="color:red">You must fill all fields!</span>';
		}
		
		
		$this->db->select('uid')->from('user')->where('email',$email);
		$query=$this->db->get();
		if($query->num_rows()>0){
			$has_error=true;
			$error_msg['eemail']='<span style="color:red">This email has been registered!</span>';
		}
		
		
		$this->db->select('uid')->from('user')->where('phone',$phone);
		$query=$this->db->get();
		if($query->num_rows()>0){
			$has_error=true;
			$error_msg['ephone']='<span style="color:red">This phone has been registered!</span>';
		}
		
		
		if($spwd!=$cspwd)
		{
			$has_error=true;
			$error_msg['espwd']='<span style="color:red">The login password you entered must be the same as the former</span>';
		}
		
		
		if($tpwd!=$ctpwd)
		{
			$has_error=true;
			$error_msg['etpwd']='<span style="color:red">The transaction password you entered must be the same as the former</span>';
		}
		
		
		if ($has_error)
		{
			$this->load->view('register',$error_msg);
		}
		
		if (!$has_error)
		{
			$spwd=md5($spwd);
			$tpwd=md5($tpwd);
			$data = array(
				'uid'	=>	null,
				'email'	=>	$email,
				'spwd'	=>	$spwd,
				'tpwd'	=>	$tpwd,
				'phone'	=>	$phone,
				'rtime'	=>	now()
			);
			$this->db->insert('user',$data);

			$this->db->from('user')->where('email',$email);
			$query=$this->db->get();
			$sess_arr['uid']	=	$uid = $query->row()->uid;
			$sess_arr['email']	=	$query->row()->email;
			$this->session->set_userdata($sess_arr);

			$query = $this->db->query('SELECT cid FROM ecoin ORDER BY cid DESC LIMIT 1');
			$result = intval($query->row()->cid);
			#echo $result;
			for($i=1; $i<=$result; $i++)
			{
				$arr=array(
					'uid' => $uid,
					'cid' => $i,
					'num' => 0
				);
				$this->db->insert('property',$arr);
			}

			$this->load->view('index');
		}
	}
}
/* End of file register.php */
/* Location: ./application/controllers/register.php */