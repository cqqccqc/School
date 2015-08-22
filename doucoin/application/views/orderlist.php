<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    
    

    <title>市场深度</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url().'css/bootstrap.css'?>" rel="stylesheet">
    <!-- custom css -->
    <link href="<?=base_url().'css/trade.css'?>" rel="stylesheet">


  </head>

  <body>

    <div class="navbar navbar-default navbar-fixed-top" >
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
        <div>
          <p style="float:left"  class="text-warning"><strong>当前价格：<em><?php if(isset($cprice['cprice'])) echo $cprice['cprice'];else echo 0;?></em></strong></p>
          <p style="float:right" class="text-warning"><strong><a href="<?=base_url().'index.php/orderlist/myorder/'?><?=$cid?>">&nbsp;&nbsp;我的挂单</a></strong></p>
          <p style="float:right" class="text-warning"><strong><a href="<?=base_url().'index.php/trade/index/'?><?=$cid?>">&nbsp;&nbsp;返回</a></strong></p>
          <p style="float:right" class="text-warning"><strong>&nbsp;&nbsp;最高价：<em><?php if(isset($hprice['price'])) echo $hprice['price'];else echo 0;?></em></strong></p>
          <p style="float:right" class="text-warning"><strong>最低价：<em><?php if(isset($lprice['price'])) echo $lprice['price'];else echo 0;?></em></strong></p>
        </div>
      </div>
        
    </div>



    
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <table class="table table-hover table-bordered">
        <caption><h3>Sell</h3></caption>
        <thead>
          <tr>
            <td>价格/RMB</td>
            <td>数量</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($sorder as $row):?> 
            <tr>
              <td><?=$row['price']?></td>
              <td><?=$row['num']?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <div class="col-md-6">
      <table class="table table-hover table-bordered">
        <caption><h3>Buy</h3></caption>
        <thead>
          <tr>
            <td>价格/RMB</td>
            <td>数量</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($border as $row):?>
            <tr>
              <td><?=$row['price']?></td>
              <td><?=$row['num']?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url().'js/jquery-1.11.0.min.js'?>"></script>
    <script src="<?=base_url().'js/bootstrap.min.js'?>"></script>
    
  </body>
</html>
