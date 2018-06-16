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

        <ol class="breadcrumb">
          <li><a href="?Guest">خانه</a></li>
          <li><a class="active">پیگیری درخواست پشتیبانی</a></li>
        </ol>


        <div class="content-page">
          {if !isset($id) }

          <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
              <form method="POST" action="" id="track_form">
                {csrf_token()}
                <div class="input-group" style="direction: ltr;">
	   <span class="input-group-btn">
	   <button class="btn btn-track btn-default" onClick="track()" type="button">بگرد!</button> 
	   </span>
                  <input class="form-control" style="text-align: right;" value="{if $id_track } {$id_track} {/if}" name="track_code" placeholder="کد پیگیری را وارد نمایید">
                </div>

                {if count($track['id_tiket']) < 1 and isset($id_track) }
                  <div style="margin-top:20px;" class="alert alert-danger" role="alert">
                    <strong>یافت نشد !</strong> </br>
                    متاسفانه درخواستی با این کد رهگیری یافت نشد </div>
                {/if}
            </div>
            </form>
          </div>

          {elseif isset($id) }

          <table class="table">
            <thead>
            <tr>
              <th>کد - موضوع</th>
              <th>دپارتمان</th>
              <th>اخرین بروزرسانی</th>
              <th>آخرین پاسخ از</th>
              <th>وضعیت</th>
              <th>عملیات</th>
            </tr>
            </thead>
            <tbody>

            <tr>
              <td class="fa-number"><a class="btn btn-xs btn-primary" href="?route=show_tiket&tiket_code={$tiket.tk_code}">{$tiket.tk_code}#-{$tiket.tk_title}</a></td>
              <td  class="fa-number">{$tiket.dep_title}</td>
              <td  class="fa-number">{ago($tiket.tk_timestamp_res)}</td>
              <td >{last_massage($tiket.tk_last_req)}</td>
              <td >{state_tiket($tiket.tk_state)}</td>
              <td  class="hidden-xs"><a href="?Guest&track&show_tiket&tiket_code={$tiket.tk_code}&close_tiket" class="btn btn-xs btn-default">بستن درخواست</a></td>
            </tr>
            </tbody>
          </table>


          <div class="tiket_parent">
            <div class="icon-user">
              <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="type-sender"> {last_massage_nocolor($tiket.tk_last_req)}</div>
            <div class="maxwidth panel-content">
              <div class="started"> مشکل </div>
              <p>
                <strong>{if $tiket.tk_user_id !== 0} {$user.s_full_name} {/if}
                </strong></br>
                <span class="fa-number" style="font-size: 12px;font-family: wyekan;color: #989898;"> {$tiket.tk_date_in}</span> - <label class="fa-number" style="font-size: 12px;font-family: wyekan;color: #989898;">{ago($tiket['tk_timestamp_in'])}</label>  </span>
              </p>
              <p>
                {assign   var=lines value=explode("\n", $tiket.tk_massage)}
                {foreach $lines as  $line }
                  {$line}
                {/foreach}
              </p>
              <p>
                {if  $tiket.tk_file !=="0"}
                  {assign   var=file value=get_file($tiket['tk_code'])}
                  {if $file !== "0"}
                    <a id="file-{$file.id_fl}" onClick="download_file('{$file.id_fl}','{$file.fl_filename}')" class="donwload-btn btn btn-xs btn-danger"> [فایل ضمیمه] - {formatSizeUnits($file.fl_size)} </a>
                  {/if}{/if}
              </p>
            </div>

          </div>



          {foreach $tiket_all as $row}
            <div class="tiket_parent{if  $row['tk_last_req'] == "1" } admin-message {/if}">
              <div class="icon-user">
                <i class="fa fa-user" aria-hidden="true"></i>
              </div>
              <div class="type-sender"> {last_massage_nocolor($row.tk_last_req)} </div>
              <div class="panel-content">
                <p>
                  <strong> {if $row.tk_last_req == "0" and $tiket.tk_user_id !== 0 } {$user.s_full_name} {elseif $row.tk_last_req == "1"} { {get_admin_name($row.admin_id_res)} {/if} </strong></br>
                  <span class="fa-number" style="font-size: 12px;font-family: wyekan;color: #989898;"> {$row.tk_date_in}</span> - <label class="fa-number" style="font-size: 12px;font-family: wyekan;color: #989898;"> {ago($row.tk_timestamp_in)}</label>  </span>
                </p>
                <p>
                  {assign   var=lines value=explode("\n", $row.tk_massage)}
                  {foreach $lines as  $line }
                    {$line}
                  {/foreach}
                </p>
                <p>
                  {if  $row.tk_file !=="0"}
                    {assign   var=file value=get_file($row['tk_code'])}
                    {if $file !== "0"}
                      <a id="file-{$file.id_fl}" onClick="download_file('{$file.id_fl}','{$file.fl_filename}')" class="donwload-btn btn btn-xs btn-danger"> [فایل ضمیمه] - {formatSizeUnits($file.fl_size)} </a>
                    {/if}{/if}
                </p>
              </div>

            </div>
          {/foreach}


          <div class="result_send_new">
          </div>


        </div>


        <button type="button" data-toggle="modal" data-target="#show_models"  class="new_tiket">
          <p> ارسال پاسخ </p>
          <i class="fa fa-plus" aria-hidden="true"></i>
        </button>

        <div  id="results"></div>



        <!-- Modal -->
        <div id="show_models" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ارسال پاسخ جدید</h4>
              </div>
              <div class="modal-body">
                <form  id="message_form" method="POST">
                  <div class="form-group">
                    <label> پاسخ :  </label>
                    <textarea name="f1" class="form-control" rows="4" placeholder="پاسخ خود را وارد نمایید ... "></textarea>
                  </div>
                  <div class="form-group">
                    <label> فایل ضمیمه  </label>
                    <input name="file" id="file_1" type="file">
                    <span style="display: inline-block;" name="file" class="label label-info fa-number">پسوند  مجاز : .zip <br>
			   حجم مجاز : ۱ مگابایت </span>
                  </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">انصراف</button>
                <button type="button" onclick="send_new_massage()" class="btn btn-send-message btn-primary" >ارسال  پاسخ</button>
                </form>
              </div>
            </div>

          </div>
        </div>
        {/if}

      </div>

    </div>

  </div>


</div>
</div>

</body>
</html>

