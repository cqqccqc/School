<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trade extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	//页面数据显示
	function index($cid=1)
	{
		echo $this->session->userdata('uid');
		$session_uid = $this->session->userdata('uid');
		if(empty($session_uid))
		{
			$this->load->view('toindex');
		}
		
		$uid = $this->session->userdata('uid');
		if($cid==17) {
			header('Location: '.base_url().'index.php/wallet');
		}

		$data['cid'] = $cid;
		//buy or sell info
		$query = $this->db->get('ecoin');
		$data['result'] = $query->result_array();

		$this->db->from('ecoin')->where('cid',$cid);
		$query = $this->db->get();
		$data['cinfo'] = $query->row_array();

		$this->db->from('property')->where('cid',$cid);
		$this->db->where('uid',$uid);
		$query = $this->db->get();
		$data['property'] = $query->row_array();

		$this->db->from('property')->where('cid',17);
		$this->db->where('uid',$uid);
		$query = $this->db->get();
		$data['rmb'] = $query->row_array();


		//s order
		$query = $this->db->query('SELECT price,num FROM `orders`,`odetail` WHERE orders.cid = '.$cid.
			' AND odetail.bos = "s" AND state = "o" 
			AND orders.oid = odetail.oid ORDER BY price ASC, time ASC LIMIT 5');
		$data['sorder']=$query->result_array();

		//b order
		$query = $this->db->query('SELECT price,num FROM `orders`,`odetail` WHERE orders.cid = '.$cid.
			' AND odetail.bos = "b" AND state = "o" 
			AND orders.oid = odetail.oid ORDER BY price DESC, time ASC LIMIT 5');
		$data['border']=$query->result_array();

		//current price
		$query = $this->db->query('SELECT cprice FROM ecoin WHERE cid='.$cid);
		$data['cprice']=$query->row_array();

		//high price
		$query = $this->db->query('SELECT price FROM eprice WHERE cid='.$cid.' ORDER BY price DESC');
		$data['hprice']=$query->row_array();

		//high price
		$query = $this->db->query('SELECT price FROM eprice WHERE cid='.$cid.' ORDER BY price ASC');
		$data['lprice']=$query->row_array();

		#$this->_transaction(1);
		$this->load->view('trade',$data);
	}
		
	function sell()
	{	
		$sprice = $_POST['sprice'];
		$snum = $_POST['snum'];
		$tpwd = md5($_POST['tpwd']);
		$cid = $_POST['cid'];
		$property = $_POST['property'];
		$uid=$this->session->userdata('uid');
		
		$data['error'] = '';
		$data['url'] = base_url().'index.php/trade/index/'.$cid;
		
		$this->db->select('tpwd')->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$dtwds = $query->row_array();
		$dtwd = $dtwds['tpwd'];
		#var_dump($dtwd);
		if ($tpwd!=$dtwd)
		{
			$data['error'] = '交易密码不正确';
			$this->load->view('fail',$data);
			return;
		}

		if ($snum>$property)
		{
			$data['error'] = '余额不足';
			$this->load->view('fail',$data);
			return;
		}
		$arr = array(
			'uid' => $uid,
			'cid' => $cid );
		$this->db->insert('orders',$arr);
		$oid = $this->db->insert_id();

		$arr = array(
			'oid'	=> $oid,
			'time'	=> time(),
			'price'	=> $sprice,
			'num'	=> $snum,
			'bos'	=> 's',
			'state'	=> 'o');
		$this->db->insert('odetail',$arr);
		if($this->db->affected_rows()<0)
		{
			$data['error'] = '出错了';
			$this->load->view('fail',$data);
			return;
		}
		$this->_transaction($cid);
		$this->load->view('success',$data);
	}


	function buy()
	{	
		$bprice = $_POST['bprice'];
		$bnum = $_POST['bnum'];
		$tpwd = md5($_POST['tpwd']);
		$cid = $_POST['cid'];
		$rmb = $_POST['rmb'];
		$uid=$this->session->userdata('uid');
		
		$data['error'] = '';
		$data['url'] = base_url().'index.php/trade/index/'.$cid;
		
		$this->db->select('tpwd')->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$dtwds = $query->row_array();
		$dtwd = $dtwds['tpwd'];
		#var_dump($dtwd);
		if ($tpwd!=$dtwd)
		{
			$data['error'] = '交易密码不正确';
			$this->load->view('fail',$data);
			return;
		}

		if ($bnum>$rmb)
		{
			$data['error'] = '余额不足';
			$this->load->view('fail',$data);
			return;
		}
		$arr = array(
			'uid' => $uid,
			'cid' => $cid );
		$this->db->insert('orders',$arr);
		$oid = $this->db->insert_id();

		$arr = array(
			'oid'	=> $oid,
			'time'	=> time(),
			'price'	=> $bprice,
			'num'	=> $bnum,
			'bos'	=> 'b',
			'state'	=> 'o');
		$this->db->insert('odetail',$arr);
		if($this->db->affected_rows()<0)
		{
			$data['error'] = '出错了';
			$this->load->view('fail',$data);
			return;
		}
		$this->_transaction($cid);
		$this->load->view('success',$data);
	}

	private function _transaction($cid)
	{
		$sql1= 'SELECT orders.uid,orders.oid,orders.cid,ecoin.cname,odetail.time,odetail.price,odetail.num,odetail.bos,odetail.state FROM odetail,orders,ecoin WHERE orders.cid=ecoin.cid AND orders.oid=odetail.oid AND odetail.bos="b" AND odetail.state="o" AND orders.cid='.$cid.' ORDER BY odetail.price DESC LIMIT 1';
		$sql2= 'SELECT orders.uid,orders.oid,orders.cid,ecoin.cname,odetail.time,odetail.price,odetail.num,odetail.bos,odetail.state FROM odetail,orders,ecoin WHERE orders.cid=ecoin.cid AND orders.oid=odetail.oid AND odetail.bos="s" AND odetail.state="o" AND orders.cid='.$cid.' ORDER BY odetail.price ASC LIMIT 1';
		
		$query1=$this->db->query($sql1);
		$result1=$query1->row_array();
		$bp=$result1['price'];
		$bn=$result1['num'];
		$boid=$result1['oid'];
		$buid=$result1['uid'];
		$brmb=$bp*$bn;

		$query2=$this->db->query($sql2);
		$result2=$query2->row_array();
		$sp=$result2['price'];
		$sn=$result2['num'];
		$soid=$result2['oid'];
		$suid=$result2['uid'];
		$srmb=$sp*$sn;

		if ($bp>=$sp)
		{
			if ($bn==$sn)
			{	//order deal
				$data=array('state'=>'d');
				$this->db->where('oid',$boid);
				$this->db->update('odetail',$data);
				$this->db->where('oid',$soid);
				$this->db->update('odetail',$data);

				//update property 
				$this->db->select('num')->from('property')->where(array('uid'=>$buid,'cid'=>$cid));
				$bpro=$this->db->get()->row()->num;
				$this->db->select('num')->from('property')->where(array('uid'=>$suid,'cid'=>$cid));
				$spro=$this->db->get()->row()->num;
				$bpro += $bn;
				$spro = $sn-$spro;
				$bproarr=array('num'=>$bpro);
				$this->db->where('uid',$buid);
				$this->db->where('cid',$cid);
				$this->db->update('property',$bproarr);
				$sproarr=array('num'=>$spro);
				$this->db->where('uid',$suid);
				$this->db->where('cid',$cid);
				$this->db->update('property',$sproarr);

				//更新rmb数值
				$this->db->select('num')->from('property')->where(array('uid'=>$buid,'cid'=>17));
				$bormb=$this->db->get()->row()->num;
				$this->db->select('num')->from('property')->where(array('uid'=>$suid,'cid'=>17));
				$sormb=$this->db->get()->row()->num;
				$brmb-=$bormb;
				$srmb+=$sormb;
				$brmbarr=array('num'=>$brmb);
				$this->db->where('uid',$buid);
				$this->db->where('cid',17);
				$this->db->update('property',$brmbarr);
				$srmbarr=array('num'=>$srmb);
				$this->db->where('uid',$suid);
				$this->db->where('cid',17);
				$this->db->update('property',$srmbarr);

				//ecoin update
				$ecoinarr=array('cprice'=>$bp);
				$this->db->where('cid',$cid);
				$this->db->update('ecoin',$ecoinarr);
				

				$arr=array(
					'cid'	=> $cid,
					'time'	=> time(),
					'price' => $bp);
				$this->db->insert('eprice',$arr);
			} elseif ($bn>$sn)
			{
				$difference = $bn-$sn;
				$data=array('state'=>'d');
				$this->db->where('oid',$soid);
				$this->db->update('odetail',$data);
			 	$data=array('num'=>$difference);
			 	$this->db->where('oid',$boid);
			 	$this->db->update('odetail',$data);

				//update property 
				$this->db->select('num')->from('property')->where(array('uid'=>$buid,'cid'=>$cid));
				$bpro=$this->db->get()->row()->num;
				$this->db->select('num')->from('property')->where(array('uid'=>$suid,'cid'=>$cid));
				$spro=$this->db->get()->row()->num;
				$bpro += $bn;
				$spro = $sn-$spro;
				$bproarr=array('num'=>$bpro);
				$this->db->where('uid',$buid);
				$this->db->where('cid',$cid);
				$this->db->update('property',$bproarr);
				$sproarr=array('num'=>$spro);
				$this->db->where('uid',$suid);
				$this->db->where('cid',$cid);
				$this->db->update('property',$sproarr);

				//更新rmb数值
				$this->db->select('num')->from('property')->where(array('uid'=>$buid,'cid'=>17));
				$bormb=$this->db->get()->row()->num;
				$this->db->select('num')->from('property')->where(array('uid'=>$suid,'cid'=>17));
				$sormb=$this->db->get()->row()->num;
				$brmb-=$bormb;
				$srmb+=$sormb;
				$brmbarr=array('num'=>$brmb);
				$this->db->where('uid',$buid);
				$this->db->where('cid',17);
				$this->db->update('property',$brmbarr);
				$srmbarr=array('num'=>$srmb);
				$this->db->where('uid',$suid);
				$this->db->where('cid',17);
				$this->db->update('property',$srmbarr);

				//ecoin update
				$ecoinarr=array('cprice'=>$bp);
				$this->db->where('cid',$cid);
				$this->db->update('ecoin',$ecoinarr);
				

				$arr=array(
					'cid'	=> $cid,
					'time'	=> time(),
					'price' => $bp);
				$this->db->insert('eprice',$arr);
			} else
			{
				$difference = $sn-$bn;
				$data=array('state'=>'d');
				$this->db->where('oid',$boid);
				$this->db->update('odetail',$data);
			 	$data=array('num'=>$difference);
			 	$this->db->where('oid',$soid);
			 	$this->db->update('odetail',$data);

				//update property 
				$this->db->select('num')->from('property')->where(array('uid'=>$buid,'cid'=>$cid));
				$bpro=$this->db->get()->row()->num;
				$this->db->select('num')->from('property')->where(array('uid'=>$suid,'cid'=>$cid));
				$spro=$this->db->get()->row()->num;
				$bpro += $bn;
				$spro = $sn-$spro;
				$bproarr=array('num'=>$bpro);
				$this->db->where('uid',$buid);
				$this->db->where('cid',$cid);
				$this->db->update('property',$bproarr);
				$sproarr=array('num'=>$spro);
				$this->db->where('uid',$suid);
				$this->db->where('cid',$cid);
				$this->db->update('property',$sproarr);

				//更新rmb数值
				$this->db->select('num')->from('property')->where(array('uid'=>$buid,'cid'=>17));
				$bormb=$this->db->get()->row()->num;
				$this->db->select('num')->from('property')->where(array('uid'=>$suid,'cid'=>17));
				$sormb=$this->db->get()->row()->num;
				$brmb-=$bormb;
				$srmb+=$sormb;
				$brmbarr=array('num'=>$brmb);
				$this->db->where('uid',$buid);
				$this->db->where('cid',17);
				$this->db->update('property',$brmbarr);
				$srmbarr=array('num'=>$srmb);
				$this->db->where('uid',$suid);
				$this->db->where('cid',17);
				$this->db->update('property',$srmbarr);

				//ecoin update
				$ecoinarr=array('cprice'=>$bp);
				$this->db->where('cid',$cid);
				$this->db->update('ecoin',$ecoinarr);
				

				$arr=array(
					'cid'	=> $cid,
					'time'	=> time(),
					'price' => $bp);
				$this->db->insert('eprice',$arr);
			}
			return $this->_transaction($cid);
		} 
		else 
		{
			return 'success';
		}
	}
}
/* End of file trade.php */
/* Location: ./application/controllers/trade.php */