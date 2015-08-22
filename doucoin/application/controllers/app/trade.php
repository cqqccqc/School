<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trade extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		
	}

	public function info()
	{	
		$info=array();
		$query = $this->db->get('ecoin',16,0);
		foreach ($query->result() as $row)
		{	
			array_push($info,  
					array(
			    	'cid'=>$row->cid,
			    	'cename'=>$row->cename,
			   		'cname'=>$row->cname,
			    	'cprice'=>$row->cprice)	
		    );
		}

		#var_dump($info);
		echo json_encode($info);
	}

	public function einfo($cid=1)
	{

		$this->db->from('ecoin')->where('cid', $cid);
		$query = $this->db->get();
		$result = $query->row();
		$info=array(
			    	'cid'=>$result->cid,
			    	'cename'=>$result->cename,
			   		'cname'=>$result->cname,
			    	'cprice'=>$result->cprice);
		echo json_encode($info);
	}

	//buy or sell
	public function top5($cid=1,$uid)
	{
		$query = $this->db->query('SELECT price,num FROM `orders`,`odetail` WHERE orders.cid = '.$cid.
			' AND odetail.bos = "s" AND state = "o" 
			AND orders.oid = odetail.oid ORDER BY price ASC, time ASC LIMIT 5');
		$sell = $query->result_array();
		if (count($sell) > 0) {
			$buy_recommend = $sell[0];
		} else {
			$buy_recommend = 0;
		}
		
 
 		$query = $this->db->query('SELECT price,num FROM `orders`,`odetail` WHERE orders.cid = '.$cid.
			' AND odetail.bos = "b" AND state = "o" 
			AND orders.oid = odetail.oid ORDER BY price ASC, time ASC LIMIT 5');
		$buy = $query->result_array();
		if (count($buy) > 0) {
			$sell_recommend = $buy[0];
		} else {
			$sell_recommend = 0;
		}


		$query = $this->db->query('SELECT property.cid,cname,cename,cprice,num FROM ecoin,property,user 
			WHERE property.uid = user.uid AND property.cid = ecoin.cid AND property.cid = '.$cid.' 
			AND property.uid = '.$uid.' ORDER BY cid ASC; ');
		$balance = $query->result_array();

		$query = $this->db->query('SELECT property.cid,cname,cename,cprice,num FROM ecoin,property,user 
			WHERE property.uid = user.uid AND property.cid = ecoin.cid AND property.cid = 17 
			AND property.uid = '.$uid.' ORDER BY cid ASC; ');
		$rmb = $query->result_array();

		$data=array('sell'=>$sell, 'buy'=>$buy, 
			'buy_recommend'=>$buy_recommend, 'sell_recommend'=>$sell_recommend, 
			'balance'=>$balance[0], 'rmb'=>$rmb[0]);

		echo json_encode($data);
	}


	function sell()
	{	
		$flag = true;
		$data=array('code'=>400, 'message'=>'failed');

		$sprice = $_POST['sprice'];
		$snum = $_POST['snum'];
		$tpwd = md5($_POST['tpwd']);
		$cid = $_POST['cid'];
		$property = $_POST['property'];

		//uid and token
		$uid=$_POST['uid'];
		$token=$_POST['token'];
	
		$this->db->select('token')->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$dtokens = $query->row_array();
		if (count($dtokens) == 0) {
			#401表示token失效了
			$data['code'] = 401;
			$data['message'] = '登陆失效';

			$flag = false;
		}

		$this->db->select('tpwd')->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$dtwds = $query->row_array();
		$dtwd = $dtwds['tpwd'];
		#var_dump($dtwd);
		if ($tpwd!=$dtwd)
		{
			//402表示交易密码不正确
			$data['code'] = 402;
			$data['message'] = '交易密码不正确';
			
			$flag = false;
		}

		if ($snum>$property)
		{
			//403表示余额不足
			$data['code'] = 403;
			$data['message'] = '余额不足';
			
			$flag = false;
		}

		if($flag){
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
				//404表示未知错误
				$data['code'] = 404;
				$data['message'] = '未知错误';
			}
			$this->_transaction($cid);

			$data['code']=200;
			$data['message']='挂单成功';
		}
		echo json_encode($data);
	}


	function buy()
	{	
		$flag = true;
		$data=array('code'=>400, 'message'=>'failed', 'data'=>'');

		$bprice = $_POST['bprice'];
		$bnum = $_POST['bnum'];
		$tpwd = md5($_POST['tpwd']);
		$cid = $_POST['cid'];
		$rmb = floatval($_POST['rmb']);

		$buynum=floatval($bprice)*floatval($bnum);
		//uid and token
		$uid=$_POST['uid'];
		$token=$_POST['token'];
	
		$this->db->select('token')->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$dtokens = $query->row_array();
		if (count($dtokens) == 0) {
			#401表示token失效了
			$data['code'] = 401;
			$data['message'] = '登陆失效';

			$flag = false;
		}

		$this->db->select('tpwd')->from('user')->where('uid',$uid);
		$query = $this->db->get();
		$dtwds = $query->row_array();
		$dtwd = $dtwds['tpwd'];
		#var_dump($dtwd);
		if ($tpwd!=$dtwd) {
			//402表示交易密码不正确
			$data['code'] = 402;
			$data['message'] = '交易密码不正确';
			
			$flag = false;
		}

		if ($buynum>$rmb)
		{
			//403表示余额不足
			$data['code'] = 403;
			$data['message'] = '余额不足';
			
			$flag = false;
		}

		if ($flag) {

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
				//404表示未知错误
				$data['code'] = 404;
				$data['message'] = '未知错误';
				
			}
			$this->_transaction($cid);

			$data['code']=200;
			$data['message']='挂单成功';
		}

		echo json_encode($data);
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
/* Location: ./application/controllers/app/trade.php */