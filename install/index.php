<?php
require 'cnr.php';
?>
<!DOCTYPE html>
<html>
 <head>
     <title>نصب - اسکریپت بومی پشتیبانی کاربران مونیکس</title>
     <link href="css/style.css" rel="stylesheet">
 </head>
<body>
 <div class="wrapper">
   <?php if(isset($msg)){echo $msg;}?>
   <div><strong> (<?=$step;?>)  نصب - اسکریپت بومی پشتیبانی کاربران مونیکس </strong></div>
   <form method="POST" action="<?=$_SERVER['REQUEST_URI'];?>">
        <?php if(!isset($_SESSION['step'])){?>
     <div class=" box-term center">
         <strong> قوانین استفاده از مونیکس</strong>
         <div class="margin-20 box">
             <p>1 - هرگونه کد کردن و دسبرد در اسکریپت غیر قانونی میباشد و ممنوع است. </p>
             <p>2 - هرگونه دسبرد در کپی رایت ممنوع و پیگرد قانونی دارد.</p>
             <p>  3 - مونیکس بصورت رایگان منتشر شده است و هرگونه فروش آن غیر قانونی میباشد</p>
             <p>4 - هرگونه سو استفاده از اسکریپت ممنوع بوده و پیگرد قانونی دارد.</p>
             <p> 5 - از آنجایی که امنیت مونیکس تست شده است از جانب ما تایید شده و هرگونه هک و... وبسایت شما بر عهده مونیکس نمیباشد.</p>
         </div>
     </div>
     <div  style="width: 300px" class="margin-20 center">
     <label> با قوانین ذکر شده بالا موافقت مینمایم. <input type="checkbox" name="term"></label>
         <button class="margin-20 btn" type="submit"><span>مرحله بعد</span></button>
     </div>
       <?php }elseif($_SESSION['step'] == 2){?>
       <div class="margin-20"  <strong>اطلاعات دیتابیس</strong></div>

 <div class="group">
     <input name="host" type="text" value="localhost" required>
     <span class="highlight"></span>
     <span class="bar"></span>
     <label>Host</label>
 </div>

 <div class="group">
     <input name="name" type="text"  required>
     <span class="highlight"></span>
     <span class="bar"></span>
     <label>نام پایگاه داده</label>
 </div>
 <div class="group">
     <input name="password" type="password"  >
     <span class="highlight"></span>
     <span class="bar"></span>
     <label>کلمه عبور</label>
 </div>
 <div class="group">
     <input name="username" type="text"  required>
     <span class="highlight"></span>
     <span class="bar"></span>
     <label>نام کاربری</label>
 </div>
 <button class="margin-20 btn" type="submit"><span>مرحله بعد</span></button>
 <?php }elseif($_SESSION['step'] == 3){?>
     <div class="margin-20"  <strong>اطلاعات وبسایت</strong></div>
     <div class="group">
         <input name="title" type="text"  required>
         <span class="highlight"></span>
         <span class="bar"></span>
         <label>عنوان وبسایت</label>
     </div>
     <div class="group">
         <input name="adminpanel" type="text"  required>
         <span class="highlight"></span>
         <span class="bar"></span>
         <label>آدرس مدیریت</label>
     </div>
     <div class="group">
         <input name="name" type="text"  required>
         <span class="highlight"></span>
         <span class="bar"></span>
         <label>نام مدیریت</label>
     </div>
     <div class="group">
         <input name="username" type="text"  required>
         <span class="highlight"></span>
         <span class="bar"></span>
         <label>نام کاربری مدیریت</label>
     </div>
     <div class="group">
         <input name="password" type="password"  required>
         <span class="highlight"></span>
         <span class="bar"></span>
         <label>رمز عبور مدیریت</label>
     </div>
     <button class="margin-20 btn" type="submit"><span>نصب</span></button>
 <?php }elseif($_SESSION['step'] == 4){?>
     <div class=" box-term center">
         <strong> با موفقیت نصب شد </strong>
         <div class="margin-20 box">
             <p> اسکریپت شما با موفقیت نصب شد .</p>
             <p>بروزر هرگونه مشکل به وبسایت مونیکس مراجعه نمایید به آدرس  <a href="http://munix.ir" target="_blank"> Munix</a></p>
             <p> برای ورود به ناحیه مدیریتی http://yourDomin.ltd/آدرس-پنل-اختصاصی  </p>
             <p> <strong>توجه : </strong>  پوشه install  را حذف نمایید</p>
         </div>
     </div>
     <div class="center maargin-20">
         <button class="btn" type="button" onclick="window.location='http://<?=$_SERVER['HTTP_HOST'];?>'"><span>  مشاهده وبسایت</span> </button>
     </div>
 <?php }?>
   </form>
 </div>


</body>
</html>