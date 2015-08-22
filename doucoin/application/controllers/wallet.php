<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}
	
	function index()
	{
		#var_dump($this->session);
		$session_uid = $this->session->userdata('uid');
		if(empty($session_uid))
		{
			$this->load->view('toindex');
		}
		
		$uid = $this->session->userdata('uid');
		
		$sql = 'SELECT property.uid,property.cid,cname,cprice,num FROM ecoin,property,user 
			WHERE property.uid = user.uid AND property.cid = ecoin.cid AND property.uid = '.$uid.' ORDER BY cid ASC; ';
		#echo $sql;
		
		$query = $this->db->query($sql);

		$data['info']=$query->result_array();
		$this->load->view('wallet',$data);
	}

	function recharge($cid)
	{
		#echo $cid;
		$data['cid'] = $cid;
		$this->load->view('recharge',$data);
	}

	function recharging()
	{
		$uid = $this->session->userdata('uid');
		$cid = $_POST['cid'];
		$cnum = doubleval($_POST['cnum']);

		$this->db->select('num')->from('property')->where(array('cid'=>$cid,'uid'=>$uid));
		$query = $this->db->get();
		$num = $cnum + doubleval($query->row()->num);

		#echo $uid;
		#echo $cid;
		#echo $num.'<br>';

		$data['num'] = $num;
		$query = $this->db->update('property', $data, array('uid'=>$uid, 'cid'=>$cid));

		$url = base_url().'index.php/wallet';
		$view['url'] = $url;
		if($query == 1)
		{						
			$this->load->view('success',$view);
		} 
		else 
		{
			$this->load->view('fail',$view);
		}
		
	}

	function withdraw($cid)
	{
		
	}
}
/* End of file wallet.php */
/* Location: ./application/controllers/wallet.php */