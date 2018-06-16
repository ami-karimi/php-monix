<?php
 require_once(ClASSES_DIR.'plugin.class.php');
 $plugin = new Plugin();
 $list = $plugin->Plugin_List();
 $plugin->pagination = new pagination($list, (isset($_GET['page']) ? $_GET['page'] : 1), 10);
 
   if(isset($_GET['Disable'])){
	   $plugin->Disable_Plugin($_GET['short_name'],$_GET['plugin']);
	   header('location: manage_plugin');
   }
   elseif(isset($_GET['Active'])){
	   $plugin->ActivePlugin($_GET['short_name'],$_GET['plugin']);
	   header('location: manage_plugin');
   }
   elseif(isset($_GET['Uninstall'])){
	  $msg_install = $plugin->UninstallPlugin($_GET['short_name'],$_GET['plugin']);
   }
   elseif(isset($_GET['install'])){
	   $msg_install =  $plugin->installPlugin($_GET['short_name'],$_GET['plugin']);
   }
   elseif($_SERVER['REQUEST_METHOD'] == "POST"){
       $status = "";
       $up = $plugin->upload_Plugin();
       if($up['check'] == 1){
           $dir = $_SERVER['DOCUMENT_ROOT'] . "/Connect/Plugin";
           require_once ClASSES_DIR . 'unzip.php';
           $zip = new Zip();
           $zip->unzip_file($up['file']);
           if($zip->unzip_to($dir)) {
               unlink($up['file']);
               header('location: manage_plugin');
           }
       }
   }
 $page_num = "45";
 $page_title = "مدیریت پلاگین ها";
 