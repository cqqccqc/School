<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>欢迎来到DouCoin!</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url().'css/bootstrap.css'?>" rel="stylesheet">
    <!-- custom css -->
    <link href="<?=base_url().'css/index.css'?>" rel="stylesheet">


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
              <a href="<?=base_url().'index.php/user/index/'?>" class="form-control"><?=$session_email?></a>
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

    
    <div class="jumbotron">
      <div class="container">
        <h1>欢迎来到DouCoin!</h1>
        <p>在这里你可以操作各类电子货币。</p>
        <p>
        <?php 

        if (!empty($session_uid)) {echo '<a href="'.base_url().'index.php/user/index/" class="btn btn-success btn-lg">'.$session_email.'的个人中心';}
        	else echo '<a href="'.base_url().'index.php/register" class="btn btn-success btn-lg">注册 &raquo;'?>
        </a></p>
      </div>
    </div>

    <div class="container">

      <div class="row">
        <div class="col-md-6">
          <h2>交易</h2>
          <p>各类电子货币的在线交易</p>
          <p><a class="btn btn-primary" href="<?=base_url().'index.php/trade'?>" >进入 &raquo;</a></p>
        </div>
        <div class="col-md-6">
          <h2>钱包</h2>
          <p>管理我的钱包</p>
          <p><a class="btn btn-primary" href="<?=base_url().'index.php/wallet'?>" >进入 &raquo;</a></p>
       </div>
       <!--  <div class="col-md-4">
          <h2>商城</h2>
          <p>支持电子货币的商城</p>
          <p><a class="btn btn-primary" href="#" >进入 &raquo;</a></p>
        </div> -->
      </div>


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
