<?php
 $id= intval($_GET['tiket_code']);      
 $tmp->assign("id", $id, true); 
 if(!empty($id)){
 $tiket = $db->row("SELECT * FROM td_tiket 
 INNER JOIN td_department ON td_tiket.tk_departmen =  td_department.id_dep
 WHERE tk_user_id = '".$_SESSION['user_id']."' and tk_code = '{$id}' and tk_parent ='0' ");  
 $_SESSION['tiket_code'] = $id;
 $tmp->assign("tiket", $tiket, true);  
 $tiket_all = $db->query("SELECT * FROM td_tiket WHERE tk_user_id = '".$_SESSION['user_id']."'  and tk_parent ='{$id}' ");  
 $tmp->assign("tiket_all", $tiket_all, true);  
 if(count($tiket['id_tiket']) < 1){
	header('location:/');   
 }elseif(isset($_GET['close_tiket'])){
     $db->query("UPDATE td_tiket SET tk_state = '4' WHERE tk_code = :id",array('id'=>$tiket['tk_code']));
     header('location: /?route=show_tiket&tiket_code='.$tiket['tk_code']);
 }
 }else{
     header('location:/');
 }

 $page_num= "3";
 $page_title =" نمايش درخواست ".$tiket['tk_title'];
$tmp->assign("page_num", $page_num, true);
$tmp->assign("page_title", $page_title, true);