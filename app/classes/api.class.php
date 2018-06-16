<?php
/**
 * Return first doc comment found in this file.
 * 
 * @return string
 */
 
 class Api {
	 public $Api_key;
 
	function  __construct() {
		global $db;
		$this->db = $db;
	 }
	 public function ApiCheck($url){
		 $er_re = array();
		 $check = 0;
		  if(!empty($this->Api_key)){
		 $key =  $this->db->query("SELECT se_value FROM td_setting WHERE se_Key = 'api_key' ");
		 if($this->db->querycount > 0){
	       foreach($key as $val){
			   $de = json_decode($val['se_value'],true);
			   if($de['api_key'] == $this->Api_key and $de['url'] == $url and (int) $de['state'] == 1){
			      $check = $check + 1;
			     array_push($er_re,'1'); 
			   }
		      }
		 }else{
			 $check = 0;
			 array_push($er_re,'-1');
		 }
		  }else{
			 $check = 0;
			 array_push($er_re,'0');  
		  }
		 return array('url_request'=>$url,'check'=>$check,'msg'=>implode(' ',$er_re));
	 }
	 function register_user($parm){
		 $reg = new register_user();
		 $reg->db = new Db();
	     $reg_user = $reg->create_user($parm['f1'],$parm['f2'],$parm['f3'],$parm['f4'],$parm['f5']);
         header("Content-Type: application/json;charset=utf-8");
		 if($reg_user !== 'true'){
	      echo  json_encode(array('check'=>0,'msg'=>implode(' ',$reg_user)));
		 }else{
	      echo json_encode(array('check'=>1,'msg'=>$reg_user));
	     }
	 }
	 
	 function login_user($parm,$type = 0){
		 $user_id = "0";
		 if(isset($parm['username']) and isset($parm['password'])){
		 $username =  _clear($parm['username']);
	     $password =  passwordHash(_clear($parm['password']));
	    $query = $this->db->row("SELECT * FROM  td_user WHERE  s_username = :username and s_password = :pass", array("username"=>$username,'pass' => $password));
         	if($query > 0){
	         if($query['s_username'] == $username and $password == $query['s_password']) {
		       if($query['s_state'] == "1"){
		       $check = "1";
			   if($type == 0){
		        $_SESSION['user_login'] = true; 
		        $_SESSION['user_id'] = $query['id_user'];
			   }
			   $user_id = $query['id_user'];
			   $log = new user();
			   $log->db = new Db();
			   $log->update_last_log($query['id_user']);  
		      }else{
		       $check = "-2";
		     }
	      }else{
	 	   $check = "-1";
	       }  
	   }else{
		 $check = "0"; 
	   }
		 }else{
			$check = "-3"; 
		 }
		 
	     header("Content-Type: application/json;charset=utf-8");
	     $export = array('check' => $check,'user_id'=>$user_id);
		 if($type == 0){
	      echo json_encode($export);
		 }else{
		 return json_encode($export);
		 }
	 }
	 function user_profile($user,$pass){
          $data = '0';
		 if(!empty($user) and !empty($pass)){
		 $parm = array('username'=>$user,'password'=>$pass);
		 $user = json_decode($this->login_user($parm,1),true);
		  if($user['check'] == "1"){
			$check  = "1";
			$user_id = $user['user_id'];
			$rows =  $this->db->row("SELECT s_full_name,s_username,s_email,s_reg_in_date,s_reg_in_time,s_lastlog_time,s_state,s_dicription FROM td_user  WHERE id_user = '{$user_id}' ");
		    if($this->db->querycount > 0){
			 $data = $rows;
			}else{
			 $check  = '-5';	
			}
		  }else{
			$check  = $user['check'];
		  }
		 }else{
			 $check  = '-4';
		 }
		  header("Content-Type: application/json;charset=utf-8");
	      $export = array('check' => $check,'data'=>$data);
	      echo json_encode($export);
	 }
	 function Manage_tiket($user,$pass){
		 $data = '0';
		 if(!empty($user) and !empty($pass)){
		 $parm = array('username'=>$user,'password'=>$pass);
		 $user = json_decode($this->login_user($parm,1),true);
		  if($user['check'] == "1"){
			$check  = "1";
			$user_id = $user['user_id'];
			$rows =  $this->db->query("SELECT * FROM td_tiket  INNER JOIN td_Department ON td_tiket.tk_departmen =  td_Department.id_dep WHERE tk_user_id = '{$user_id}'   ORDER BY id_tiket DESC");
		    if($this->db->querycount > 0){
			 $data = $rows;
			}else{
			 $check  = '-5';	
			}
		  }else{
			$check  = $user['check'];
		  }
		 }else{
			 $check  = '-4';
		 }
		  header("Content-Type: application/json;charset=utf-8");
	      $export = array('check' => $check,'data'=>$data);
	      echo json_encode($export);
	 }
	 
	 function show_tiket($user,$pass,$tk_code){
		 $data = '0';
		 if(!empty($user) and !empty($pass) and !empty($tk_code)){
		 $parm = array('username'=>$user,'password'=>$pass);
		 $user = json_decode($this->login_user($parm,1),true);
		  if($user['check'] == "1"){
			$check  = "1";
			$user_id = $user['user_id'];
			$rows =  $this->db->row("SELECT * FROM td_tiket  INNER JOIN td_Department ON td_tiket.tk_departmen =  td_Department.id_dep WHERE tk_user_id = '{$user_id}'    and tk_code  = '{$tk_code}' ");
		    if($this->db->querycount > 0){
			  $data = $rows;
			}else{
			 $check  = '-5';	
			}
		  }else{
			$check  = $user['check'];
		  }
		 }else{
			 $check  = '-4';
		 }
		  header("Content-Type: application/json;charset=utf-8");
	      $export = array('check' => $check,'data'=>$data);
	      echo json_encode($export); 
	 }
 } 
 
