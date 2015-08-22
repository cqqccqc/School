<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderlist extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	
	function index($cid=1)
	{
		$data['cid'] = $cid;

		//get all s order
		$query = $this->db->query('SELECT num,price FROM odetail,orders WHERE odetail.oid=orders.oid AND cid = '.$cid.' AND bos="s" AND state="o" ORDER BY price ASC, time ASC');
		$data['sorder'] = $query->result_array();

		//get all b order
		$query = $this->db->query('SELECT num,price FROM odetail,orders WHERE odetail.oid=orders.oid AND cid = '.$cid.' AND bos="b" AND state="o" ORDER BY price ASC, time ASC');
		$data['border'] = $query->result_array();

		//current price
		$query = $this->db->query('SELECT cprice FROM ecoin WHERE cid='.$cid);
		$data['cprice']=$query->row_array();

		//high price
		$query = $this->db->query('SELECT price FROM eprice WHERE cid='.$cid.' ORDER BY price DESC');
		$data['hprice']=$query->row_array();

		//high price
		$query = $this->db->query('SELECT price FROM eprice WHERE cid='.$cid.' ORDER BY price ASC');
		$data['lprice']=$query->row_array();

		$this->load->view('orderlist',$data);
	}
	
	function myorder()
	{
		$data= array();
		$uid = $this->session->userdata('uid');
		$sql = 'SELECT orders.uid,orders.oid,orders.cid,ecoin.cname,odetail.time,odetail.price,odetail.num,odetail.bos,odetail.state FROM odetail,orders,ecoin WHERE orders.cid=ecoin.cid AND orders.oid=odetail.oid AND orders.uid= '.$uid.' ORDER BY orders.oid DESC ';
		
		$query = $this->db->query($sql);
		$data['myorder'] = $query->result_array();
		$this->load->view('myorder',$data);
	}
	
	function cancel($oid)
	{	
		$arr = array('state' => 'c', );
		$this->db->where('oid',$oid);
		$this->db->update('odetail',$arr);
		header('Location: '.base_url().'index.php/orderlist/myorder');
	}	
}
/* End of file orderlist.php */
/* Location: ./application/controllers/orderlist.php */