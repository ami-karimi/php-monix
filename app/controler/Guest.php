 <?php  
  if(se('send_tiket_goust') == "1"){
    if(isset($_GET['show_code'])){  
	$id_show = filter($_GET['show_code']);
	$tmp->assign("id_show", $id_show, true);
	$get_code = $db->row("SELECT * FROM td_tiket WHERE tk_code = '{$id_show}' and  tk_user_id = '".$_SESSION['user_id']."' LIMIT 1 ");
	$tmp->assign("get_code", $get_code, true);
       if(empty($get_code['id_tiket'])){
          header('location: /');  
       }  
	}   
	if(isset($_GET['send_tiket'])){    
	    $id_dep =intval($_GET['dep_id']);
        $tmp->assign("id_dep", $id_dep, true);
		$where = "WHERE dep_state = '1' and id_dep = '{$id_dep}' ";
		$Department_all = $db->query("SELECT * FROM td_department WHERE dep_state = '1'  ");
        $tmp->assign("Department_all", $Department_all, true);
		 if($_SERVER['REQUEST_METHOD'] == "POST"){
			 $token = $_POST['CSRF_TOKEN'];   
	         if($security->get($token)) {  
             $security->delete($token);    
			 $data['f1'] = xss_cleaner(filter($_POST['f1']));
			 $data['f2'] = xss_cleaner(filter($_POST['f2'])); 
			 $data['f3'] = xss_cleaner(filter($_POST['f3']));
			 $data['f4'] = xss_cleaner(filter($_POST['f4']));
			 $data['f5'] = xss_cleaner(filter($_POST['f5']));
             $files = "0";			 
             if(!empty($_FILES['file']['name'])){ $handle = new Upload($_FILES['file']);
                 if ($handle->uploaded) {
                     $dir = $_SERVER['DOCUMENT_ROOT']."/Connect/upload/zip/";
                     $handle->allowed = array('application/x-rar-compressed', 'application/octet-stream', 'application/zip', 'application/x-zip-compressed', 'multipart/x-zip');
                     $handle->file_max_size  = 1024;
                     $fileSize = $handle->file_src_size;
                     $handle->Process($dir);
                     if ($handle->processed) {
                         $check = 1;
                         $handle->Clean();
                         $fileName = $handle->file_dst_name_body.".zip";
                         $min_path = "../Connect/upload/zip/{$fileName}";
                         $full_path = "http://".$_SERVER["HTTP_HOST"]."/Connect/upload/zip/{$fileName}";
                         $insert   =  $db->query("INSERT INTO  td_file(fl_filename,fl_code,fl_type,fl_min_path,fl_full_path,fl_user_id,fl_state,fl_timestamp,fl_size) VALUES
					     (:fl_filename,:fl_code,:fl_type,:fl_min_path,:fl_full_path,:fl_user_id,:fl_state,:fl_timestamp,:fl_size)", array("fl_filename"=>$fileName,"fl_code"=>$_SESSION['code_request'],'fl_type'=>'application/zip','fl_min_path'=>$min_path,'fl_full_path'=>$full_path,'fl_user_id'=>'0','fl_state'=>'1','fl_timestamp'=>time(),'fl_size'=>$fileSize));
                         $files =  $db->lastInsertId();
                         $check ="1";
                     } else {
                         $check = "0";
                         $msg = 	$msg=  "<script > show_massage('".$handle->error."','danger') </script>";
                     }
                 } else {
                     $check = "0";
                     $msg=  "<script > show_massage('خطا در بارگذاری','danger') </script>";
                 }
			 }

           if(empty($data['f1'])){
			   $msg=  "<script > show_massage('موضوع درخواست را فراموش  نموده اید','danger') </script>";
               $check = "0";			   
		   }
           if($data['f3'] < 0 or $data['f3'] > 3 ){
			   $msg=  "<script > show_massage('اولویت بندی  اشتباه!','danger') </script>"; 
               $check = "0";			   
		   }
           if(empty($data['f4'])){
			   $msg=  "<script > show_massage('متن درخواست را فراموش  نموده اید !','danger') </script>";
               $check = "0";			   
		   }
		   if (!filter_var($data['f5'], FILTER_VALIDATE_EMAIL)) {
			   $msg=  "<script > show_massage('لطفا یک ایمیل  معتبر  وارد  نمایید','danger') </script>";
               $check = "0";	
             }
		   if($check !=="0"){ 
			 $insert= $db->query("INSERT INTO td_tiket(tk_email,tk_code,tk_title,tk_massage,tk_olaviat,tk_departmen,tk_state,tk_parent,tk_user_id,tk_timestamp_in,tk_timestamp_res,tk_date_in,tk_date_res,tk_last_req,tk_file) 
			 VALUES(:tk_email,:tk_code,:tk_title,:tk_massage,:tk_olaviat,:tk_departmen,:tk_state,:tk_parent,:tk_user_id,:tk_timestamp_in,:tk_timestamp_res,:tk_date_in,:tk_date_res,:tk_last_req,:tk_file)",
			 array("tk_email"=>$data['f5'],"tk_code"=>$_SESSION['code_request'],"tk_title"=>$data['f1'],"tk_massage"=>$data['f4'],"tk_olaviat"=>$data['f3'],"tk_departmen"=>$data['f2'],"tk_state"=>'1',"tk_parent"=>'0',"tk_user_id"=> '0',"tk_timestamp_in"=> time(),"tk_timestamp_res"=> time(),"tk_date_in"=> jdate('Y-m-d H:i:s'),"tk_date_res"=> jdate('Y-m-d H:i:s'),"tk_last_req" => '0',"tk_file" => $files));
			  if($insert > 0){  
				  $id= $db->lastInsertId();
				  Redirect("?Guest&send_tiket&dep_id=1&show_code=".$_SESSION['code_request']);
				  $data = array('code'=>$_SESSION['code_request'],'title'=>$data['f1'],'email'=>$data['f5'],'name'=>"میهمان");
                  sendmail('code',$data);				  
			  }
		    } 
		   }else{
			   die('object Moved');   
		   } // End  check CSRF 
		 }else{
			 $_SESSION['code_request'] = get_last_code().rand(1,50000);
		 }
		 
		 // End Check POST REQ
	}else{
		$where = "WHERE dep_state = '1'"; 
	}

   $Department = $db->query("SELECT * FROM td_department {$where} ");
    $tmp->assign("department", $Department, true);
  }else{
	  header('location: /');
  }