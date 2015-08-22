<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	function index()
	{
		$session_uid = $this->session->userdata('uid');
		if (empty($session_uid))
		{
			$this->load->view('toindex');
		}
		
		$data=array();

		$uid = $this->session->userdata('uid');
		$data['uid']=$uid;

		$this->db->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$data['user'] = $query->row_array();
		$this->load->view('user',$data);
	}
		
	function edit_spwd()
	{
		$uid 	=	$this->session->userdata('uid');
		$ospwd 	=	md5($_POST['ospwd']);
		$nspwd	=	md5($_POST['nspwd']);
		$cspwd	=	md5($_POST['cspwd']);
		$error	=	"";
		$url = base_url().'index.php/user/index';

		if($nspwd != $cspwd)
		{	
			$error = "两次输入的密码不一致";
			$data['url'] = $url;
			$data['error'] = $error;
			$this->load->view('fail',$data);
			return;
		}
		
		$this->db->select('spwd')->from('user')->where('uid',$uid);
		$spwds = $this->db->get()->row_array();
		$spwd = $spwds['spwd'];
		if($ospwd != $spwd)
		{			
			$error = "原密码输入错误";
			$data['url'] = $url;
			$data['error'] = $error;
			$this->load->view('fail',$data);
			return;
		}

		$this->db->query("UPDATE user SET spwd = '".$nspwd."' WHERE uid = ".$uid);
		if($this->db->affected_rows()>0)
		{
			$url = base_url().'index.php/user/index';
			$data['url'] = $url;	
			$this->load->view('success',$data);
		}
		
	}
		
	function edit_tpwd()
	{
		$uid 	=	$this->session->userdata('uid');
		$otpwd 	=	md5($_POST['otpwd']);
		$ntpwd	=	md5($_POST['ntpwd']);
		$ctpwd	=	md5($_POST['ctpwd']);
		$error	=	"";
		$url = base_url().'index.php/user/index';

		if($ntpwd != $ctpwd)
		{	
			$error = "两次输入的密码不一致";
			$data['url'] = $url;
			$data['error'] = $error;
			$this->load->view('fail',$data);
			return;
		}
		
		$this->db->select('tpwd')->from('user')->where('uid',$uid);
		$tpwds = $this->db->get()->row_array();
		$tpwd = $tpwds['tpwd'];
		if($otpwd != $tpwd)
		{			
			$error = "原密码输入错误";
			$data['url'] = $url;
			$data['error'] = $error;
			$this->load->view('fail',$data);
			return;
		}

		$this->db->query("UPDATE user SET tpwd = '".$ntpwd."' WHERE uid = ".$uid);
		if($this->db->affected_rows()>0)
		{
			$url = base_url().'index.php/user/index';
			$data['url'] = $url;	
			$this->load->view('success',$data);
		}
		
	}
}
/* End of file user.php */
/* Location: ./application/controllers/user.php */