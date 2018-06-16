<html>
<head>
  <meta charset="utf-8">
  <title> {$MainTitle} </title>
   <meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
    <link href="{$tehemPatch}/css/home.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{$tehemPatch}/js/home.min.js"></script>
	{php}
		global $hooks;
		$hooks->do_action('User_Header');
	{/php}
  </head>
    <body> 
	<nav class="navbar navbar-fixed-top navbar-inverse hidden-lg hidden-md hidden-sm">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li {if !$page_num } class="active" {/if}><a href="/">میزکار</a></li>
            <li {if isset($page_num) and $page_num=="1" } class="active" {/if}><a  href="?route=Create_new_tiket">ایجاد درخواست جدید</a></li>
            <li {if isset($page_num) and $page_num =="5" } class="active" {/if}><a href="?route=manage_tiket&open_tiket">درخواست های باز</a></li>
            <li {if isset($page_num) and $page_num =="4" } class="active" {/if}><a href="?route=manage_tiket">همه درخواست ها</a></li>
            <li {if isset($page_num) and $page_num =="6" } class="active" {/if}><a href="?route=setting_account">ویرایش حساب</a></li>
            <li><a href="/logout">خروج</a></li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav>
	
     
	 <div class="main-container margin-sm">
	 <div class="row" style="margin: 0px;">
	  <div class="side-right col-lg-2 hidden-xs">
	   <div class="search-box">
	    <input type="text" placeholder="جستجو..." >
	    <i class="fa fa-search" aria-hidden="true"></i>
	   </div>
	  
	   <ul class="menu-tab active">
     	  <li> <i class="fa fa-tachometer" aria-hidden="true"></i><a href="#"> داشبرد </a> 
		   <ul>
		     <li {if !$page_num } class="current" {/if} ><a href="/"> میزکار  </a> </li>
		     <li {if isset($page_num) and $page_num == "1" } class="current" {/if}><a href="?route=Create_new_tiket"> ایجاد درخواست جدید </a></li>
		   </ul>
	    </li> 
          
	   </ul>
		  {php}
			  global $hooks;
			  $hooks->do_action('User_Menu');
		  {/php}
	   <ul class="menu-tab">
     	  <li> <i class="fa fa-ticket" aria-hidden="true"></i><a href="#"> مدیریت درخواست ها </a> 
		   <ul> 
		     <li {if isset($page_num) and $page_num == "5" } class="current" {/if}><a href="?route=manage_tiket&open_tiket"> درخواست های باز  </a> </li>
		     <li {if isset($page_num) and $page_num == "4" } class="current" {/if}><a href="?route=manage_tiket" > همه درخواست ها </a></li>
		   </ul>
	    </li>
         
	   </ul>
	   <ul class="menu-tab">
     	  <li  > <i class="fa fa-cog" aria-hidden="true"></i><a href="#"> مدیریت  حساب </a> 
		   <ul>  
		     <li {if isset($page_num) and $page_num =="6" } class="current" {/if}><a href="?route=setting_account"> ویرایش حساب </a> </li>
		   </ul>
	    </li>
         
	   </ul>
	   
	 <ul class="menu-tab">
     	  <li> <i class="fa fa-sign-out" aria-hidden="true"></i> <a href="/logout"> خروج </a> </li>
         
	   </ul>
	   
	   
	 </div> 
	 