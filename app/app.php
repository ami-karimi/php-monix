<?php
// ************************************* //
//            Monix Tiketing System     //
//              http://monix.ir        //
// *************************************//
if(isset($_SESSION['admin_id'])) {
    $admin = new admin();
    $admin->ChangeAdminState();
}
 $_SESSION['token'] = md5(base64_decode(rand(1,500000)));

	   
  if(isset($_GET['ajax'])){
	  require_once('controler/ajax.php');
  }
   if(isset($_SESSION['admin_login'])){
         if(show_tikets() !== '0') {
	    $allow_operator = array('manage_tiket','create_tiket','show_tiket','main','edit_profile');
    }else{
			$allow_operator = array();
		}
		
   }

	 if(isset($_GET['route'])){
	 $route = htmlentities($_GET['route']);
	 $path = APP_DIR."/controler/".$route.".php";
	 if(preg_match("/^[a-zA-Z_]*$/", $route) == 1 ){
	  if(isset($_GET['route'])){ 
		if(is_file($path)){
		 $contlorer = $route;
		}else{
	    $contlorer = "main";			
	    }  		   
	  }else{
	  $contlorer = "main";	   
	  }
	 }else{
		 $contlorer = "main";	
	 }
	  }else{
		 $contlorer = "main";	
	 }
      define('VIEW',$contlorer);	
      define('route',$contlorer);