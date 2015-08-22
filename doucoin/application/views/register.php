
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>注册</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url().'css/bootstrap.css'?>" rel="stylesheet">
    <!-- custom css -->
    <link href="<?=base_url().'css/register.css'?>" rel="stylesheet">


  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" >
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?=base_url()?>">DouCoin</a>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="邮箱" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="密码" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">登陆</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </div>

    <!--注册表单-->
    <div class="container">
      <form class="form-horizontal" method="post" action="<?=base_url().'index.php/register/registering"'?>" >
        <fieldset>
          <legend>用户注册<?php if(isset($filled)) echo $filled;?></legend>
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">邮箱</label>
          <div class="col-sm-10">
          <?php if(isset($eemail)) echo $eemail;?>
            <input type="email" class="form-control" name="email" id="email" placeholder="邮箱" 
            <?php if(isset($email)) echo 'value="'.$email.'"';?>>
          </div>
        </div>
        <div class="form-group">
          <label for="phone" class="col-sm-2 control-label">手机</label>
          <div class="col-sm-10">
          <?php if(isset($ephone)) echo $ephone;?>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="手机"
            <?php if(isset($phone)) echo 'value="'.$phone.'"';?>>
          </div>
        </div>
        <div class="form-group">
          <label for="spwd" class="col-sm-2 control-label">登陆密码</label>
          <div class="col-sm-10">
            <input type="password" class="form-control" name="spwd" id="spwd" placeholder="密码">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">确认登陆密码</label>
          <div class="col-sm-10">
          <?php if(isset($espwd)) echo $espwd;?>
            <input type="password" class="form-control" name="cspwd" id="cspwd" placeholder="确认登陆密码">
          </div>
        </div>
        <div class="form-group">
          <label for="tpwd" class="col-sm-2 control-label">交易密码</label>
          <div class="col-sm-10">
          
            <input type="password" class="form-control" name="tpwd" id="tpwd" placeholder="交易密码">
          </div>
        </div>
        <div class="form-group">
          <label for="ctpwd" class="col-sm-2 control-label">确认交易密码</label>
          <div class="col-sm-10">
          <?php if(isset($etpwd)) echo $etpwd;?>
            <input type="password" class="form-control" name="ctpwd" id="ctpwd" placeholder="确认交易密码">
          </div>
        </div>
       <!--  <div class="form-group">
          <label for="vcode" class="col-sm-2 control-label">验证码</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="vcode" id="vcode" placeholder="请输入验证码">
            <a><img></a>
          </div> -->
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <input type="submit" value="注册" class="btn btn-primary">
            <input type="reset" value="重置" class="btn btn-primary">
          </div>
        </div>
        </fieldset>

      </form>
      <footer>
      <hr>
        <p>&copy; 有关部门</p>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?=base_url().'js/jquery-1.11.0.min.js'?>"></script>
    <script src="<?=base_url().'js/bootstrap.min.js'?>"></script>
  </body>
</html>
