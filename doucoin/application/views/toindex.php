<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    
    

    <title>请登陆</title>

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
     
    	<p>
        <a href="<?=base_url()?>">请先登陆</a>
      </p>
       
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
