<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>ورود مدیریت | مونیکس</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php asset('css/bootstrap.min.css');?>" rel="stylesheet">
    <link href="<?php asset('css/bootstrap-reset.css');?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php asset('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php asset('css/style.css');?>" rel="stylesheet">
    <link href="<?php asset('css/style-responsive.css');?>" rel="stylesheet" />
	
    <script src="<?php asset('js/jquery-1.8.3.min.js');?>"></script>
    <script src="<?php asset('js/sweetalert.min.js');?>"></script>
    <script src="<?php asset('js/login.js');?>"></script>
		 
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php asset('js/html5shiv.js');?>"></script>
    <script src="<?php asset('js/respond.min.js');?>"></script>
    <![endif]-->
</head>

  <body class="login-body">
    <div class="container">

      <form class="form-signin" id="form-signin" method="POST" action="?">
	     <input type="hidden" name="_CSRF_TOKEN" value="<?=$token;?>" />
        <h2 class="form-signin-heading">ورود به پنل مدیریت V1</h2>
        <div class="login-wrap">
		     <div id="results"></div>
			 
            <input type="text" id="input_user" name="tkcr5kf(user$name$input)"  value="" class="form-control" placeholder="نام کاربری" autofocus>
            <input autocomplete="off"  id="input_pass" type="password" name="tkcr5kf(pass$word$input)"  class="form-control" placeholder="رمز عبور">
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> مرا به خاطر بسپار
                <span class="pull-right"> <a href="#"></a></span>
            </label>
            <button class="btn btn-lg btn-login btn-block" onClick="login()" type="button">ورود</button>
            <span><i class="icon-unlock" aria-hidden="true"></i> ای پی شما جهت ورود امن ثبت شد : &nbsp;&nbsp;<?=getUserIP();?></span>
            <a href="#"> فراموشی رمز عبور </a>

        </div>

      </form>

    </div>
     
	 <!-- لطفا قانون کپی رایت را رعایت  نمایید هم وطن گرامی -->
	 <a href="http://monix.ir">Copy &#9400; right by Monix</a>
	 <script>
	  function login(){
  var username_input = $('#input_user').val();
  var password_input = $('#input_pass').val(); 
  
  if(username_input !=="" && password_input !==""){
   $('.btn-login').text('کمی صبر کنید...');
   $('.btn-login').prop('disabled',true);
   var myform = document.getElementById('form-signin');
    var fd = new FormData(myform);
    $.ajax({
        url: '?ajax=login_admin',
        data: fd,
        cache: false,
        processData: false,
        contentType: false, 
        type: 'POST',
        success: function (data) {
		   $('.btn-login').text('ورود');
           $('.btn-login').prop('disabled',false);
		   var exports = $.parseJSON(data);	 
		   var results = $('#results');
           var alert_notvalidate = '<div class="alert alert-danger">نام  کاربري و يا کلمه عبور صحيح نميباشد</div>';
		   var alert_success = '<div class="alert alert-success">با موفقيت وارد شده ايد اکنون به پنل  خود هدايت ميشويد ...</div>';
		   var user_state = '<div class="alert alert-warning">نام کاربري شما از  پنل  مديريت غير فعال شده است لطفا با پشتيباني  تماس حاصل فرماييد</div>';
			 if(exports.state_login == "0"){
				results.html(alert_notvalidate); 
			 } if(exports.state_login == "1"){
				results.html(alert_success); 
				window.location = "<?=Mo_url(AdminTarget()."/");?>";
			 } if(exports.state_login == "2"){
				results.html(user_state); 
			 }				 
        }

    });

    return false;    //<---- Add this line
  }
 }
	 </script>
  </body>
</html>
