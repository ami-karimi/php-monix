<?php
  define('ROOT_DIR', '../'.DIRECTORY_SEPARATOR);
  define('ClASS_DIR', ROOT_DIR .'app/class'.DIRECTORY_SEPARATOR);
  define('ClASSES_DIR', ROOT_DIR .'app/classes'.DIRECTORY_SEPARATOR);
  require_once(ROOT_DIR.'app/config.php');
  require_once(ClASS_DIR.'Db.class.php');
  $db = new Db();

// Check Admin State
 require ClASSES_DIR.'admin.class.php';
 $admin = new admin();
 $admin->ResAdmin();
<?php

 // Db Config
 define('DBHost', 'localhost');
 define('DBName', 'new');
 define('DBUser', 'root');
 define('DBPassword', '');
