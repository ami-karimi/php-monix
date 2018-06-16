 <?php
  if(!isset($_GET['open_tiket'])){
    $page_num = "4";
    $page_title ="همه درخواست  ها";
    $tmp->assign("page_num", $page_num, true);
    $tmp->assign("page_title", $page_title, true);

    $pages = new Paginator('10','p');

    $pages->set_total('100000'); 
    $rows =  $db->query("SELECT * FROM td_tiket 
    INNER JOIN td_department ON td_tiket.tk_departmen =  td_department.id_dep
    WHERE tk_user_id = '".$_SESSION['user_id']."'   ORDER BY id_tiket DESC");
     $total = count($rows); 
    
  //pass number of records to 
   $pages->set_total($total);   
   $tiket = $db->query("SELECT * FROM td_tiket 
    INNER JOIN td_department ON td_tiket.tk_departmen =  td_department.id_dep
    WHERE tk_user_id = '".$_SESSION['user_id']."'   ORDER BY id_tiket DESC ".$pages->get_limit()); 
    $tmp->assign("tiket", $tiket, true);
    $tmp->assign("pages", $pages, true);
  }else{  
    $pages = new Paginator('10','p');
    $pages->set_total('100000'); 
    $rows =  $db->query("SELECT * FROM td_tiket 
    INNER JOIN td_department ON td_tiket.tk_departmen =  td_department.id_dep
    WHERE tk_user_id = '".$_SESSION['user_id']."' and tk_state !='4'  ORDER BY id_tiket DESC");
     $total = count($rows); 
    
  //pass number of records to 
   $pages->set_total($total);   
   $tiket = $db->query("SELECT * FROM td_tiket 
    INNER JOIN td_department ON td_tiket.tk_departmen =  td_department.id_dep
    WHERE tk_user_id = '".$_SESSION['user_id']."' and tk_state !='4'  ORDER BY id_tiket DESC ".$pages->get_limit()); 
    $tmp->assign("tiket", $tiket, true);
    $page_num = "5";
    $page_title ="درخواست های باز";   
    $tmp->assign("pages", $pages, true);
      $tmp->assign("page_num", $page_num, true);
      $tmp->assign("page_title", $page_title, true);
  }

 