<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    
    

    <title>我的钱包</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url().'css/bootstrap.css'?>" rel="stylesheet">
    <!-- custom css -->
    <link href="<?=base_url().'css/wallet.css'?>" rel="stylesheet">


  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" >
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="<?=base_url()?>">DouCoin</a>
        </div>
        <div class="navbar-collapse collapse">
        <?php 
          $session_uid = $this->session->userdata('uid');
          $session_email = $this->session->userdata('email');
          if (!empty($session_uid)) {?>
          <form class="navbar-form navbar-right" action="<?=base_url().'index.php/login/logout' ?>" method="post" >
            <div class="form-group">
              <a href="<?=base_url().'index.php/user/index/'?><?=$session_uid?>" class="form-control"><?=$session_email?></a>
            </div>
            <input type="submit" class="btn btn-success" value="登出">
          </form>
          <?php }else {?>
          <form class="navbar-form navbar-right" action="<?=base_url().'index.php/login' ?>" method="post" >
            <div class="form-group  <?php if (isset($error)) echo 'has-error'?>">
              <input type="text" placeholder="<?php if (isset($error)) echo $error; else echo '邮箱'?>"
               class="form-control" name="email">
            </div>
            <div class="form-group">
              <input type="password" placeholder="密码" class="form-control" name="spwd">
            </div>
            <input type="submit" class="btn btn-success" value="登陆">
          </form>
          <?php }?>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    
   

    <div class="container">
     
    		<table class="table table-hover table-bordered">
    			<thead>
    				<tr>
    					<td>序号</td>
    					<td>币种</td>
    					<td>当前价格</td>
    					<td>拥有数目</td>
    					<td>操作</td>
    				</tr>
    			</thead>
    			<tbody>
            <?php foreach ($info as $k => $v) {
              # code...
              #echo $v['cid'];
            ?>
    				<tr>
    					<td><?=$v['cid']?></td>
    					<td><?=$v['cname']?></td>
    					<td><?=$v['cprice']?></td>
    					<td><?=$v['num']?></td>
    					<td><a href="<?=base_url().'index.php/wallet/recharge/'?><?=$v['cid']?>">充值</a>|
                  <a href="<?=base_url().'index.php/wallet/withdraw/'?><?=$v['cid']?>">提现</a>
                </td>
    				</tr>
            <?php }?>
    			</tbody>
    		</table>
       <h3><a href="<?=base_url().'index.php/trade'?>" class="btn btn-success">前往交易系统</a></h3>
      <footer>
	      <hr>
    	  <p>&copy; 有关部门</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url().'js/jquery-1.11.0.min.js'?>"></script>
    <script src="<?=base_url().'js/bootstrap.min.js'?>"></script>
  </body>
</html>
