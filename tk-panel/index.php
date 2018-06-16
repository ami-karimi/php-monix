<?php
 if(!defined('APP_NAME')){die(header('HTTP/1.0 403 Forbidden'));}
    $db = new Db();
	global $hooks;
    $user = user();
    require ADMIN_CONTLORER_DIR."{$route}.php";
	require ADMIN_THEME_DIR.'header.php';
    require ADMIN_THEME_DIR."{$route}.php";
	require ADMIN_THEME_DIR.'footer.php';
  