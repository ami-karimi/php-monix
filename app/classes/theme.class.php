<?php
/**
 * Return first doc comment found in this file.
 * 
 * @return string
 */
 
 class Theme {
	 var $pagination;
	 var $page;

	 
	function  __construct() {
		global $db;
		$this->db = $db;
 
	 }
	 function Theme_List(){
	   $array = array();
       if ($handle = opendir(THEME_DIR)) {
         while (false !== ($entry = readdir($handle))) {
          $Not_allow = array('.','..','shell');
          if (!in_array($entry,$Not_allow)){
            array_push($array,array( 
			  "Title_folder" => $entry
		     )
			);
         }
        }
       closedir($handle);
      } 
	  return $array;
	 }
	  function Cleare_Comment($str){
		$text = str_replace('Theme URI:','',$str);
		$text = str_replace('Theme Name:','',$text); 
		$text = str_replace('Description:','',$text); 
		$text = str_replace('Version:','',$text); 
		$text = str_replace('Author:','',$text);
		$text = str_replace('Author URI:','',$text);
		$text = str_replace('Short Name:','',$text);
		$text = str_replace('Theme update URI:','',$text);
		return $text;
	  }
      function getFileDocBlock($dir)
      {
          $docComments = array_filter(
              token_get_all( file_get_contents( $dir ) ), function($entry) {
            return $entry[0] == T_DOC_COMMENT;
              }
          );
          $fileDocComment = array_shift( $docComments );
           $parts = explode("\n",$fileDocComment[1]);
           $comment[1] = trim($parts[1]," *");
		   $comment[2] = trim($parts[2]," *");
		   $comment[3] = trim($parts[3]," *");
		   $comment[4] = trim($parts[4]," *");
		   $comment[5] = trim($parts[5]," *");
		   $comment[6] = trim($parts[6]," *");
		   $comment[7] = trim($parts[7]," *");
		   $comment[8] = trim($parts[8]," *");
		   
		   return array( 
		        'Theme_Name' => $this->Cleare_Comment($comment[1]),
				'Theme_URI' => str_replace(' ','',$this->Cleare_Comment($comment[2])),
				'Description' => $this->Cleare_Comment($comment[3]),
				'Version' => str_replace(' ','',$this->Cleare_Comment($comment[4])),
				'Author' => $this->Cleare_Comment($comment[5]),
				'Author_URI' => str_replace(' ','',$this->Cleare_Comment($comment[6])),
				'Short_Name' => str_replace(' ','',$this->Cleare_Comment($comment[7])),
				'Theme_update_URI' => str_replace(' ','',$this->Cleare_Comment($comment[8]))
		   );
      }
	  function Check_InstallTheme($short_Name){
		$short_Name = trim($short_Name);
		$data = $this->db->row("SELECT se_key,se_value FROM td_setting WHERE se_Key = 'website_template'  ");
         if($data['se_value'] == $short_Name){
             return 1;
		 }else{
			 return 0;
		 }
	  }
	  function GetClassColor($short_Name){
		$short_Name = trim($short_Name);
		$data = $this->db->row("SELECT pr_key FROM td_personaliz WHERE pr_key = '{$short_Name}'  and pr_group = 'Theme' "); 
         if($data['pr_key'] == $short_Name){
			 $data  = $this->db->row("SELECT pr_value FROM td_personaliz WHERE pr_key = :id", array("id"=> $short_Name));
			 if($data['pr_value'] == 1){
				return 'success';
			 }elseif($data['pr_value'] == 0){
				return 'warning'; 
			 }
		 }else{
			 return 'danger';
		 }
	  }
	  
	  function Btn_InstallTheme($shortName){
		$check = $this->Check_InstallTheme($shortName);  
		 if($check == 0){
			 return '<a class="btn btn-xs btn-success" href="manage_theme?install&short_name='.$shortName.'" > فعال سازی </a>';
		 }elseif($check == 1){
			return 'نصب شده';
		 }
		 return 'نا مشخص';
	  }

	 function Get_Theme(){
        $productPages = $this->pagination->getResults();
        if (count($productPages) != 0) {
           $this->page = '<div class="numbers">'.$this->pagination->getLinks().'</div>';
          echo '<div class="no-touch"><ul class="grid cs-style-3">';
		 foreach ($productPages as $productArray) {
            $dic =  $this->getFileDocBlock(THEME_DIR.$productArray['Title_folder']."/index.php");  
            $dir = $productArray['Title_folder'];
  		    echo '
			    <li>
                              <figure>
                                  <img src="/'.THEME_DIR.$productArray['Title_folder']."/screenshot.jpg".'" alt="img04">
                                  <figcaption>
                                      <h3>'.$dic['Theme_Name'].'  (Vr.'.$dic['Version'].')</h3>
                                      <span>'.$dic['Description'].'</span>
                                      '.$this->Btn_InstallTheme($dir).'
                                  </figcaption>
                              </figure>
                          </li>
			';
         }
		 echo '</ul></div>';
        }
	 }
	 
	 function Get_Paging(){
		echo  $this->page;
	 }
	 function CheckEr_file($so){
		 return  false;
	 }


	 function UNInstall_Theme($short_name,$dir_name){
		 $dir  = Theme_DIR.$dir_name;
		 if(is_dir($dir)){
			if(is_file($dir."/index.php")){
			 $check = $this->Check_InstallTheme($short_name);
			  if($check !== 0){
               $this->db->query("DELETE FROM td_personaliz WHERE pr_key = :id and pr_group = :pr_group ", array("pr_group"=>"Theme","id"=> $short_name));

 			   $check = 1;
			  }else{
			   $check  = 8;
			  }
			}else{
			 $check  = 9;
			}
		 }else{
			 $check  = 10;
		 }
		 return $check;
	 }
     function UninstallTheme($short_name,$dir){
		$check = $this->UNInstall_Theme($short_name,$dir);
		if($check == 1){
		 Redirect('manage_theme');
		}elseif($check == 8){
		 return '<div class="alert alert-danger"><strong> لغو نصب نشد !</strong> پلاگین مورد نظر هنوز نصب نشده است </div>';
		}elseif($check == 9){
		  return '<div class="alert alert-danger"><strong> لغو نصب نشد  !</strong> فایل <b>index.php</b> یافت نشد در مسیر پلاگین ها</div>';
		}elseif($check == 10){
 		  return '<div class="alert alert-danger"><strong> لغو نصب نشد  !</strong>پوشه <b>'.$dir.'</b> یافت نشد در مسیر پلاگین ها</div>';
		}
     }

	 function Active_Theme($short_name,$dir){
		 if(is_dir($dir)){
			if(is_file($dir."/index.php")){
			 $check = $this->Check_InstallTheme($short_name);
			  if($check == 0){
			   $this->db->query("UPDATE td_setting SET se_value = :short WHERE se_key = :id ", array("id"=> 'website_template','short'=>$short_name));
               global $hooks;
			   require_once($dir."/index.php");
			   $check = 1;
			  }else{
			   $check  = 8;
			  }
			}else{
			 $check  = 9;
			}
		 }else{
			 $check  = 10;
		 }
		 return $check;
	 }

    function ActiveTheme($short_name){
	    $dir = THEME_DIR.$short_name;
		$check = $this->Active_Theme($short_name,$dir);
		if($check == 1){
		 Redirect('manage_theme');
		}elseif($check == 8){
		 return '<div class="alert alert-danger"><strong> فعال نشد !</strong> پلاگین مورد نظر از قبل فعال شده است </div>';
		}elseif($check == 9){
		  return '<div class="alert alert-danger"><strong> فعال نشد  !</strong> فایل <b>index.php</b> یافت نشد در مسیر پلاگین ها</div>';
		}elseif($check == 10){
 		  return '<div class="alert alert-danger"><strong> فعال نشد  !</strong>پوشه <b>'.$dir.'</b> یافت نشد در مسیر پلاگین ها</div>';
		}
	}

    function check_Admin_Theme($short_name,$dir){
	     $dir_name  = Theme_DIR.$dir;
		 if(is_dir($dir_name)){
			if(is_file($dir_name."/admin.php")){
			 $checks = $this->Check_InstallTheme($short_name);
			  if($checks == 1){
			   $check = 1;
			  }else{
			   $check  = 8;
			  }
			}else{
			 $check  = 9;
			}
		 }else{
			 $check  = 10;
		 }
		if($check == 1){
		 return 1;
		}elseif($check == 8){
		 Redirect('manage_theme');
		}elseif($check == 9){
		 Redirect('manage_theme');
		}elseif($check == 10){
		 Redirect('manage_theme');
		}
	}
 } 
 
