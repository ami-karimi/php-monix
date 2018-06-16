<?php
$security = new \security\CSRF;
$token = $security->set(3, 3600);

$tmp->assign("MainTitle", se('site_title'), true);
$tmp->assign("tehemPatch", THEME_PATH, true);
$tmp->assign("setting", new setting(), true);
$tmp->assign("user", users(), true);
$tmp->assign("REQUEST_URI", $_SERVER["REQUEST_URI"], true);
$tmp->assign("lang_js", lang_jsurl(), true);
if(defined('LANG_DEFINE')){
    $L=new LangQuery(FALSE);
    $L->load(LANG_DEFINE,FALSE);
    $tmp->assign('l',$L);
}


if(isset($_SESSION['user_id'])){
    // Open Tiket array
    $open_tiket = $db->query("SELECT * FROM td_tiket 
  INNER JOIN td_department ON td_tiket.tk_departmen =  td_department.id_dep
  WHERE tk_user_id = '".$_SESSION['user_id']."' and  tk_state != '4' and dep_state = '1' ORDER BY tk_timestamp_res DESC LIMIT 0,10");
    $tmp->assign("open_tiket", $open_tiket, true);
    // All Request Count
    $all_request = counter("SELECT id_tiket FROM td_tiket WHERE tk_parent='0' and tk_user_id='".$_SESSION['user_id']."' ");
    // Open Request Count
    $open_request_total = counter("SELECT id_tiket FROM td_tiket WHERE tk_parent='0' and tk_user_id='".$_SESSION['user_id']."' and tk_state !='4' ");
    // Close Request Count
    $close_request_total = counter("SELECT id_tiket FROM td_tiket WHERE tk_parent='0' and tk_user_id='".$_SESSION['user_id']."' and tk_state ='4' ");
    $tmp->assign("count", array('all_request'=>$all_request,'open_request_total'=>$open_request_total,'close_request_total'=>$close_request_total), true);
}


if(isset($_GET['route']) and isset($_SESSION['user_login'])){
    if($_GET['route'] == "Create_new_tiket"){
        require_once(ROOT_DIR.'app/controler/Create_new_tiket.php');
        $tmp->assign("Department", $Department, true);
    }else if($_GET['route'] == "show_tiket"){
        require_once(ROOT_DIR.'app/controler/show_tiket.php');
    }else if($_GET['route'] == "manage_tiket"){
        require_once(ROOT_DIR.'app/controler/manage_tiket.php');
    }else if($_GET['route'] == "setting_account"){
        require_once(ROOT_DIR.'app/controler/setting_account.php');
    }


}elseif(isset($_GET['Guest']) and se('send_tiket_goust') == "1"){
    if(isset($_GET['track'])){
        require_once APP_DIR."controler/track_guest.php";
    }else {
        require_once APP_DIR . "controler/Guest.php";
    }
}
