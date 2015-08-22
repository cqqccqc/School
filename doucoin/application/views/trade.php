<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    
    

    <title>交易</title>

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
          <p style="float:right" class="text-warning"><strong><a href="<?=base_url().'index.php/orderlist/myorder/'?>">&nbsp;&nbsp;我的挂单</a></strong></p>
          <p style="float:right" class="text-warning"><strong><a href="<?=base_url().'index.php/orderlist/index/'?><?=$cid?>">&nbsp;&nbsp;市场深度</a></strong></p>
          <p style="float:right" class="text-warning"><strong>&nbsp;&nbsp;最高价：<em><?php if(isset($hprice['price'])) echo $hprice['price'];else echo 0;?></em></strong></p>
          <p style="float:right" class="text-warning"><strong>最低价：<em><?php if(isset($lprice['price'])) echo $lprice['price'];else echo 0;?></em></strong></p>
        </div>
      </div>
        
    </div>



    
<div class="container">
	<div class="row">

    	<div class="col-md-2">
    		<?php foreach($result as $row):?>
        <div class="">   
          <a class="btn btn-primary btn-lg btn-block" href="<?=base_url().'index.php/trade/index/'?><?=$row['cid']?>"><?=$row['cname']?></a>    
        </div>
        <?php endforeach;?>
    	</div>

    	<div class="col-md-10">

       <div style="background-color:#124578;height:400px" ><img src="<?=base_url().'img/kline.png'?>" width="100%" height="400"></div>

       <div class="row">
        <div class="col-md-6">
          <form method="post" action="<?=base_url().'index.php/trade/sell'?>">
            <input type="hidden" name="cid" value="<?=$cinfo['cid']?>">
          <fieldset>
            <legend>卖出<?=$cinfo['cname']?></legend>
          <table class="table table-hover table-bordered">
            <tr>
              <td>最佳卖价</td>
              <td><?php if(isset($border[0]['price'])) 
                {
                  echo $border[0]['price'];
                } else { echo 0;}?></td>
              <td>RMB/<?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>我的余额</td>
              <td><?php
                    if (!empty($property['num'])) {
                      echo $property['num'];
                    }?><input type="hidden" name="property" value="<?php
                    if (!empty($property['num'])) {
                      echo $property['num'];
                    }?>"></td>
              <td><?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>卖出价</td>
              <td><input type="text" id="sprice" name="sprice" class="form-control"></td>
              <td>RMB/<?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>卖出量</td>
              <td><input type="text" id="snum" name="snum" class="form-control"></td>
              <td><?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>兑换额</td>
              <td id="schange"></td>
              <td>RMB</td>
            </tr>
            <tr>
              <td>手续费</td>
              <td>0</td>
              <td><?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>交易密码</td>
              <td><input type="password" name="tpwd" class="form-control"></td>
              <td></td>
            </tr>
          </table>
          <input type="submit" class="btn btn-warning">
          </fieldset>
          </form>
        </div>





        <div class="col-md-6">
          <form method="post" action="<?=base_url().'index.php/trade/buy'?>">
            <input type="hidden" name="cid" value="<?=$cinfo['cid']?>">
          <fieldset>
            <legend>买入<?=$cinfo['cname']?></legend>
          <table class="table table-hover table-bordered">
            <tr>
              <td>最佳买价</td>
              <td><?php if(isset($sorder[0]['price'])) 
                {
                  echo $sorder[0]['price'];
                } else { echo 0;}?></td>
              <td>RMB/<?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>我的余额</td>
              <td><?=$rmb['num']?><input type="hidden" name="rmb" value="<?=$rmb['num']?>"></td>
              <td>RMB</td>
            </tr>
            <tr>
              <td>买入价</td>
              <td><input type="text" name="bprice" class="form-control"></td>
              <td>RMB/<?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>买入量</td>
              <td><input type="text" name="bnum" class="form-control"></td>
              <td><?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>兑换额</td>
              <td></td>
              <td><?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>手续费</td>
              <td>0</td>
              <td><?=strtoupper($cinfo['cename'])?></td>
            </tr>
            <tr>
              <td>交易密码</td>
              <td><input type="password" name="tpwd" class="form-control"></td>
              <td></td>
            </tr>
          </table>
          <input type="submit" class="btn btn-warning">
          </fieldset>
          </form>
        </div>
       </div>



       <div class="row">
        <div class="col-md-6">
          <form>
          <fieldset>
            <legend>卖5</legend>
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <td>价格</td>
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
          </fieldset>
          </form>
        </div>
        <div class="col-md-6">
          <form>
          <fieldset>
            <legend>买5</legend>
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <td>价格</td>
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
          </fieldset>
          </form>
        </div>
       </div>
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
