<html>
<head>
	<meta charset="utf-8">
	<title>{$MainTitle}   | ارسال درخواست به عنوان مهمان</title>
	<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0" />
	<link href="{$tehemPatch}/css/home.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="{$tehemPatch}/js/home.js"></script>

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
				<li <?php if(!$page_num){ echo 'class="active"';}?>><a href="/">میزکار</a></li>
				<li <?php if(isset($page_num) and $page_num=="1"){ echo 'class="active"';}?>><a  href="?route=Create_new_tiket">ایجاد درخواست جدید</a></li>
				<li <?php if(isset($page_num) and $page_num =="5"){ echo 'class="active"';}?>><a href="?route=manage_tiket&open_tiket">درخواست های باز</a></li>
				<li <?php if(isset($page_num) and $page_num =="4"){ echo 'class="active"';}?>><a href="?route=manage_tiket">همه درخواست ها</a></li>
				<li <?php if(isset($page_num) and $page_num =="6"){ echo 'class="active"';}?>><a href="?route=setting_account">ویرایش حساب</a></li>
				<li><a href="?logout">خروج</a></li>
			</ul>
		</div><!-- /.nav-collapse -->
	</div><!-- /.container -->
</nav>


<div class="main-container margin-sm">
	<div class="row" style="margin: 0px;">
		<div class="side-right hidden-xs col-lg-2">
			<div class="search-box">
				<input type="text" placeholder="جستجو..." >
				<i class="fa fa-search" aria-hidden="true"></i>
			</div>

			<ul class="menu-tab active">
				<li> <i class="fa fa-tachometer" aria-hidden="true"></i><a href="#"> داشبرد </a>
					<ul>
						<li ><a href="?Guest&track"> پیگیری درخواست</a> </li>
						<li class="current" ><a href="?Guest"> ایجاد درخواست جدید </a></li>
					</ul>
				</li>

			</ul>




			<ul class="menu-tab">
				<li> <i class="fa fa-sign-in" aria-hidden="true"></i> <a href="/"> عضویت </a> </li>
				<li> <i class="fa fa-sign-in" aria-hidden="true"></i> <a href="/"> ورود </a> </li>

			</ul>


		</div>



		<div class="page-wapper">

			<div class="col-lg-10 col-md-10 col-sm-10" style="padding: 0;">
				{if !isset($id_show) }
				<ol class="breadcrumb">
					<li><a href="?Guest">خانه</a></li>
					<li><a class="active">ارسال درخواست به عنوان میهمان</a></li>
				</ol>


				<div class="content-page">



					{if !isset($id_dep) }
						<h4> دپارتمان  مورد نظر </h4>

						{foreach $department as $row }
							<a  href="?Guest&send_tiket&dep_id={$row.id_dep}">
								<div class="alert alert-info" role="alert">
									<strong><i class="fa fa-comment" aria-hidden="true"></i>{$row.dep_title}</strong> </br>
									{$row.dep_dicription}
								</div>
							</a>
							{foreachelse}
							<div class="alert alert-warning" role="alert">
								<strong>دپارتمانی موجود نیست !</strong></br>
								متاسفانه دپارتمانی  جهت ارسال  درخواست  موجود  نیست
							</div>
						{/foreach}


					{/if}

					{if isset($id_dep) and !isset($id_show) }
						{if count($department) > 0 }
							<form action="{$_SERVER["REQUEST_URI"]}" id="form-req" method="POST" enctype="multipart/form-data">
								{csrf_token()}
								<h4> ارسال درخواست </h4>
								<div class="col-lg-5">

									<div class="form-group">
										<label> فایل ضمیمه  </label>
										<input name="file" id="file_1" type="file"  >
										<span style="display: inline-block;"  name="file" class="label label-info fa-number">پسوند  مجاز : .zip </br>
											حجم مجاز : 1 مگابایت </span>
									</div>

								</div>
								<div class="col-lg-7" style="float:right;">

									<div class="form-group">
										<label> ایمیل </label>
										<input class="form-control" type="email" value="{if isset($data['f5']) } {$data.f5} {/if}" name="f5" placeholder="ایمیل  خود را وارد نمایید">
									</div>


									<div class="form-group">
										<label> موضوع درخواست </label>
										<input class="form-control" value="{if isset($data['f1']) } {$data.f1} {/if} " name="f1" placeholder="موضوع درخواست را وارد نمایید">
									</div>
									<div class="form-group">
										<label> دپارتمان </label>
										<select   name="f2" style="padding: 0 10px;" class="form-control">
											{foreach $Department_all as $row }
												<option {if $row.id_dep == $id_dep } selected {/if} value="{$row.id_dep}" > {$row.dep_title}</option>
											{/foreach}
										</select>

									</div>

									<div class="form-group">
										<label> اولویت </label>
										<select   name="f3" style="padding: 0 10px;" class="form-control">
											<option {if isset($data['f3']) }{if $data['f3'] == "1" } selected {/if}{/if} value="1" > کم</option>
											<option {if isset($data['f3']) }{if $data['f3'] == "2" } selected {/if}{/if} value="2" > متوسط</option>
											<option {if isset($data['f3']) }{if $data['f3'] == "3" } selected {/if}{/if} value="3" > زیاد</option>
										</select>

									</div>


									<div class="form-group">
										<label> متن درخواست </label>
										<textarea   name="f4" class="form-control" rows="4"  placeholder="متن درخواست  خود را وارد نمایید">{if isset($data['f4']) } {$data.f4} {/if}</textarea>
									</div>



									<p>
										<button type="button" onClick="send_tikets()" class="btn btn-primary">ارسال درخواست</button>
										<button type="reset" class="btn btn-default">از  نو</button>
									</p>
								</div>
							</form>
						{else}
							<div class="alert alert-warning" role="alert">
								<strong>دپارتمانی موجود نیست !</strong></br>
								متاسفانه دپارتمانی  جهت ارسال  درخواست  موجود  نیست
							</div>
						{/if}
					{/if}

					{elseif isset($id_show) }
					{if count($get_code) > 0 }
						<div class="alert alert-success" role="alert">
							<strong>درخواست شما  ارسال شد</strong> <br>
							با تشکر  درخواست شما با   کد   <a href="?Guest&track&show_tiket&tiket_code={$get_code.tk_code}" class="fa-number">#{$get_code.tk_code}</a>  با  موفقیت  ارسال شد  منتظر  پاسخ از سوی  کارشناسان باشید      </div>
					{else}
						<div class="alert alert-warning" role="alert">
							<strong>چیزی یافت نشد!</strong></br>
							متاسفانه  درخواستی با این  ای دی  یافت نشد !
						</div>
					{/if}
					{/if}


				</div>
				<!-- Content -->

			</div>

		</div>


	</div>
</div>

</body>
</html>
 
