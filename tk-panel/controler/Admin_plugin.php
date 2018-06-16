<?php

 require_once(ClASSES_DIR.'plugin.class.php');
 $plugin = new Plugin();
 $check = $plugin->check_Admin_Plugin($_GET['short_name'],$_GET['plugin']);