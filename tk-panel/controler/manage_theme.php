<?php
 require_once(ClASSES_DIR.'theme.class.php');
 $theme = new Theme();
 $list = $theme->Theme_List();
 $theme->pagination = new pagination($list, (isset($_GET['page']) ? $_GET['page'] : 1), 2);
 if(isset($_GET['install'])){
     $g = trim($_GET['short_name']);
     $theme->ActiveTheme($g);
 }
 $page_num = "46";
 $page_title = "مدیریت قالب ها";