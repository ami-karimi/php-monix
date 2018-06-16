<?php

$router->filter('auth', function(){    
    if(!isset($_SESSION['admin_login'])) 
    {
		require ADMIN_CONTLORER_DIR.'login.php';
        require ADMIN_THEME_DIR.'login.php';
    }
});

$router->group(['before' => 'auth'], function($router){
 // Admin Route
 $router->group(['prefix' => se('admin_file_name')], function($router){
    $router->get('/', function(){
		$route = "main";
		require ADMIN_DIR."index.php";
    });

    $router->any('manage_tiket', function(){
		$route = "manage_tiket";
		require ADMIN_DIR."index.php";
    });
    $router->get('manage_tiket/show_tiket/{id:i}', function($id){
		$route = "show_tiket";
		require ADMIN_DIR."index.php";
    });
    $router->any('create_tiket', function(){
		$route = "create_tiket";
		require ADMIN_DIR."index.php";
    });
    $router->any('manage_theme', function(){
		$route = "manage_theme";
		require ADMIN_DIR."index.php";
    });
    $router->any('manage_plugin', function(){
		$route = "manage_plugin";
		require ADMIN_DIR."index.php";
    });
    $router->any('manage_user', function(){
		$route = "manage_user";
		require ADMIN_DIR."index.php";
    });
    $router->any('manage_Operator', function(){
		$route = "manage_Operator";
		require ADMIN_DIR."index.php";
    });
    $router->any('edit_Operator', function(){
		$route = "edit_Operator";
		require ADMIN_DIR."index.php";
    });
    $router->any('Admin_plugin', function(){
		$route = "Admin_plugin";
		require ADMIN_DIR."index.php";
    });
    $router->any('Manage_Department', function(){
		$route = "Manage_Department";
		require ADMIN_DIR."index.php";
    });
    $router->any('setting_system', function(){
		$route = "setting_system";
		require ADMIN_DIR."index.php";
    });
     $router->any('show_user', function(){
         $route = "show_user";
         require ADMIN_DIR."index.php";
     });
    $router->get('logout', function(){
	  if($_SESSION['admin_login'] == true){
       session_destroy();   
       session_unset(); 
	   Redirect('/');
      }
    });
	
   });
   
 
});

 $router->filter('checkapi', function(){  
 	$head = getallheaders();
    if(isset($_GET['API_KEY'])){
     $key = _clear($_GET['API_KEY']);
	}else{
	 $key = "";	
	}
	$url = "http://".$head['Host'];
    $api = new Api();
	$api->Api_key = $key;
	$result = $api->ApiCheck($url);
     if($result['check'] == 0){
		 header("Content-Type: application/json;charset=utf-8");
		 echo json_encode($result);
		 die();
	 }
 });
$router->group(['before' => 'checkapi'], function($router){
    $router->group(['prefix' => 'api'], function($router){
           $router->get('/', function(){});  
           $router->post('/register_user', function(){
              $api = new Api();
			  $parm = array('f1'=>_clear($_POST['f1']),'f2'=>_clear($_POST['f2']),'f3'=>_clear($_POST['f3']),'f4'=>_clear($_POST['f4']),'f5'=>_clear($_POST['f5']));
		      $api->register_user($parm);
		      die();
           });
           $router->get('/login_user', function(){
              $api = new Api();
		      $api->login_user($_POST['parm']);
		      die();
           });
           $router->get('/user_profile', function(){
              $api = new Api();
		      $api->user_profile($_GET['username'],$_GET['password']);
		      die();
           });
           $router->get('/Manage_tiket', function(){
              $api = new Api();
		      $api->Manage_tiket($_GET['username'],$_GET['password']);
		      die();
           });
           $router->get('/show_tiket', function(){
              $api = new Api();
		      $api->show_tiket($_GET['username'],$_GET['password'],$_GET['tk_code']);
		      die();
           });
		   
    });
});