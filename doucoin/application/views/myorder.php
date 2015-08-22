<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    
    

    <title>我的挂单</title>

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
        
      </div>
        
    </div>



    
<div class="container">
  <h4><a href="<?=base_url().'index.php/trade'?>" class="btn btn-info">前往交易系统</a></h4>
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <td>挂单号</td>
        <td>币种</td>
        <td>数量</td>
        <td>价格</td>
        <td>种类</td>
        <td>状态</td>
        <td>挂单时间</td>
        <td>操作</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach($myorder as $row):?>
      <tr>
        <td><?=$row['oid']?></td>
        <td><?=$row['cname']?></td>
        <td><?=$row['num']?></td>
        <td><?=$row['price']?></td>
        <td><?=$row['bos']=='b'?"买单":"卖单"; ?></td>
        <td><?php
              if($row['state']=='d')
                echo '成交';
              elseif($row['state']=='c')
                echo "取消";
              else
                echo "挂单中";
            ?>
        </td>
        <td><?=date('Y-m-d H:i:s',$row['time'])?></td>
        <td>
          <?php if($row['state']!='o'):?>
          <span class="text-muted">无法操作</span>
          <?php else:?>
          <a href="<?=base_url().'index.php/orderlist/cancel/'?><?=$row['oid']?>" class="text-danger">取消</a>
          <?php endif;?>
        </td>
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>
</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url().'js/jquery-1.11.0.min.js'?>"></script>
    <script src="<?=base_url().'js/bootstrap.min.js'?>"></script>
    
  </body>
</html>
