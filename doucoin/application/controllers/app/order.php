<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {


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
		$flag = true;
		$result= array('code'=>400,'message'=>'failed','data'=>array());
		$uid = $_POST['uid'];
		$token = $_POST['token'];

		$this->db->select('token')->from('user')->where('uid',$uid);
		$query=$this->db->get();
		$users=$query->result_array();
	
		if (count($users) == 0) {
			$result['code']=401;
			$result['message']='登陆失效';
			$flag = false;
		}

		if ($flag) {
			$sql = 'SELECT orders.uid,orders.oid,orders.cid,ecoin.cname,ecoin.cename,odetail.time,odetail.price,odetail.num,odetail.bos,odetail.state FROM odetail,orders,ecoin WHERE orders.cid=ecoin.cid AND orders.oid=odetail.oid AND orders.uid= '.$uid.' ORDER BY orders.oid DESC ';
			
			$query = $this->db->query($sql);
			$result['data']=$query->result_array();
			$result['code']=200;
			$result['message']='succeed';
		}
		echo json_encode($result);
	}
	
	function cancel()
	{	
		$flag = true;
		$result= array('code'=>400,'message'=>'failed','data'=>array());
		
		$oid = $_POST['oid'];
		$uid = $_POST['uid'];
		$token = $_POST['token'];

		$this->db->select('token')->from('user')->where('uid',$uid);
		$query=$this->db->get();
		$users=$query->result_array();

		if (count($users) == 0) {
			$result['code']=401;
			$result['message']='登陆失效';
			$flag = false;
		}

		if ($flag) {
			
			$arr = array('state' => 'c', );
			$this->db->where('oid',$oid);
			$this->db->update('odetail',$arr);
			$result['data']='取消成功';
			$result['code']=200;
			$result['message']='succeed';
		}

		echo json_encode($result);
	}	
}
/* End of file order.php */
/* Location: ./application/controllers/order.php */