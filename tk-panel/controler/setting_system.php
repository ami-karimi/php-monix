<?php
  if($_SERVER['REQUEST_METHOD'] == "POST"){
   $save = new se_save();
   $save->db = new Db();
   $save->save_se('site_title',$_POST['f1'],'monix');
   $save->save_se('max_len_file',$_POST['f2'],'monix');
   $save->save_se('admin_file_name',$_POST['f100'],'monix');
   $save->save_se('send_tiket_goust',$_POST['f3'],'monix'); 
   $save->save_se('register_new_user',$_POST['f4'],'monix');
   $save->save_se('min_len_pass',$_POST['f5'],'monix');
   $save->save_se('max_len_pass',$_POST['f6'],'monix');
   $save->save_se('min_len_username',$_POST['f7'],'monix'); 
   $save->save_se('max_len_username',$_POST['f8'],'monix'); 
   $save->save_se('max_len_dicirption_user',$_POST['f9'],'monix');  
   $save->save_se('admin_email',$_POST['f10'],'monix'); 
   $save->save_se('mail_stamp',$_POST['f11'],'mail');  
   $save->save_se('SMTP_username',$_POST['f12'],'mail');  
   $save->save_se('SMTP_password',$_POST['f13'],'mail');  
   $save->save_se('SMTP_port',$_POST['f14'],'mail');  
   $save->save_se('SMTP_HOST',$_POST['f15'],'mail');  
  if(!empty($_FILES['logo_site']['name'])){
   $handle = new upload($_FILES['logo_site']);
   if ($handle->uploaded) {
    $handle->file_name_body_pre = 'logo_';
	$handle->allowed = array('image/*');
    $handle->process(UPLOAD_DIR.'pic/site');
      if ($handle->processed) {
	   $file = UPLOAD_PATH."/pic/site/".$handle->file_dst_name_body.".".$handle->file_dst_name_ext;
       $save->save_se('site_logo',$file,'monix');  
       $handle->clean();
       }
      }
    }
	
  if(!empty($_FILES['fav_site']['name'])){
   $handle = new upload($_FILES['fav_site']);
   if ($handle->uploaded) {
    $handle->file_name_body_pre = 'fav_';
	$handle->allowed = array('image/*');
    $handle->process(UPLOAD_DIR.'pic/site');
      if ($handle->processed) {
	   $file = UPLOAD_PATH."/pic/site/".$handle->file_dst_name_body.".".$handle->file_dst_name_ext;
       $save->save_se('fav_logo',$file,'monix');  
       $handle->clean();
       }
      }
    }
	
  }


  $page_num = "66";
  $page_title = "تنظیمات سیستم";     