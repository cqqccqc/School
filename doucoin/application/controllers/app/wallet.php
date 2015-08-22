<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index($uid)
	{

		$data=array('code'=>400,'message'=>'failed','info'=>array());
		$sql = 'SELECT property.cid,cname,cprice,num FROM ecoin,property,user 
			WHERE property.uid = user.uid AND property.cid = ecoin.cid AND property.uid = '.$uid.' ORDER BY cid ASC; ';
		#echo $sql;
		
		$query = $this->db->query($sql);
		if ($query->num_rows() >0 ) {
			$data['code']=200;
			$data['message']='success';
			$data['info']=$query->result_array();
		}

		echo json_encode($data);

		
	}

}
/* End of file wallet.php */
/* Location: ./application/controllers/app/wallet.php */