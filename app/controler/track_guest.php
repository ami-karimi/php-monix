 <?php
  if($_SERVER['REQUEST_METHOD'] == "POST") {
    $token = $_POST['CSRF_TOKEN'];   
	 if($security->get($token)) {
      $security->delete($token);   
	   $id_track = intval($_POST['track_code']);
         $tmp->assign("id_track", $id_track, true);
	   $track = $db->row("SELECT * FROM td_tiket WHERE tk_code = '{$id_track}'  and tk_user_id ='0' ");
         $tmp->assign("track", $track, true);
	   if(count($track['id_tiket']) > 0){
		  header('location:?Guest&track&show_tiket&tiket_code='.$track['tk_code']);
		  echo  "<script>window.location= '?Guest&track&show_tiket&tiket_code=".$track['tk_code']."';</script>";
	   }
	 }else{
		 die('object Moved');  
	 }
  }
  

    if(isset($_GET['show_tiket'])){
   $id = intval($_GET['tiket_code']);
   $tmp->assign("id", $id, true);
   if(!empty($id)){
 $tiket = $db->row("SELECT * FROM td_tiket 
 INNER JOIN td_Department ON td_tiket.tk_departmen =  td_Department.id_dep
 WHERE tk_user_id = '0' and tk_code = '{$id}' and tk_parent ='0' ");
 $_SESSION['tiket_code'] = $id;
       $tmp->assign("tiket", $tiket, true);
 $tiket_all = $db->query("SELECT * FROM td_tiket WHERE tk_user_id = '0'  and tk_parent ='{$id}' ");
       $tmp->assign("tiket_all", $tiket_all, true);
   if(isset($_GET['close_tiket'])){
       $db->query("UPDATE td_tiket SET tk_state = '4' WHERE tk_code = :id",array('id'=>$tiket['tk_code']));
       header('location: /?Guest&track&show_tiket&tiket_code='.$tiket['tk_code']);
   }
   if(count($tiket['id_tiket']) < 1){
	header('location:/');    
	echo  "<script>window.location= '/';</script>";
    }  
   }else{
	header('location:/');    
	   echo  "<script>window.location= '/';</script>";
   }
	} 