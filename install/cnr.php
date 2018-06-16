<?php
 session_start();
 if(isset($_SESSION['step'])){
 $step = "مرحله ".$_SESSION['step'];
}else{
     $step = "مرحله 1";
}
 function list_tables($pdo)
{
        $sql = 'SHOW TABLES';
        $query = $pdo->query($sql);
        return $query->fetchAll(PDO::FETCH_COLUMN);
}

 if($_SERVER['REQUEST_METHOD'] == "POST"){
     if(!isset($_SESSION['step'])){
         if($_POST['term'] == "on"){
           $_SESSION['step'] = 2;
         }else{
             $check = 0;
             $msg = "شما باید قوانین را بپذیرید.";
         }
     }elseif($_SESSION['step'] == 2){
         $host = $_POST['host'];$username = $_POST['username'];$password = $_POST['password'];$name = $_POST['name'];
         try {
             $dbh = new pdo("mysql:host={$host};dbname={$name}",
                 "{$username}",
                 "{$password}",
                 array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
             $check = list_tables($dbh);
             if (count($check) > 0) {
                 $msg = "دیتا بیس شما خالی نمیباشد";
                 $check = 0;
             } else {
                 $check = 1;
                 $file = file('sqlfile.sql');
                 $file = array_filter($file,
                     create_function('$line',
                         'return strpos(ltrim($line), "--") !== 0;'));
                 $file = array_filter($file,
                     create_function('$line',
                         'return strpos(ltrim($line), "/*") !== 0;'));
                 $sql = "";
                 $del_num = false;
                 foreach ($file as $line) {
                     $query = trim($line);
                     $delimiter = is_int(strpos($query, "DELIMITER"));
                     if ($delimiter || $del_num) {
                         if ($delimiter && !$del_num) {
                             $sql = "";
                             $sql = $query . "; ";
                             $del_num = true;
                         } else if ($delimiter && $del_num) {
                             $sql .= $query . " ";
                             $del_num = false;
                             $dbh->exec($sql);
                             $sql = "";
                         } else {
                             $sql .= $query . "; ";
                         }
                     } else {
                         $delimiter = is_int(strpos($query, ";"));
                         if ($delimiter) {
                             $dbh->exec("$sql $query");
                             $sql = "";
                         } else {
                             $sql .= " $query";
                         }
                     }
                 }
                 $my_file = "../app/config.php";
                 $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
                 $data = "<?php
// Db Config
define('DBHost', '{$host}');
define('DBName', '{$name}');
define('DBUser', '{$username}');
define('DBPassword', '{$password}');";
                 fwrite($handle, $data);
                 $_SESSION['step'] = 3;
                 header('location: /install/index.php');
         }
         }
         catch(PDOException $ex){
            $check = 0;
            $msg = "اتصال به دیتابیس انجام نشد.";
         }
     }elseif($_SESSION['step'] == 3){
         EditData();
         $_SESSION['step'] = 4;
         header('location: /install/index.php');
     }
 }
function passwordHash($str){
    $hash=md5(crypt(Md5($str),'7c348d0e3baaca53419cd7eb74b56b1e'));
    return $hash;
}
 function EditData() {
     require_once('../app/config.php');
     try {
         $db = new pdo("mysql:host=".DBHost.";dbname=".DBName.";charset=utf8", DBUser, DBPassword,
             array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
         // First of all, let's begin a transaction
         $db->beginTransaction();

         // A set of queries; if one fails, an exception should be thrown
         $db->query("UPDATE td_setting SET se_value = '".$_POST['title']."' WHERE se_Key= 'site_title'");
         $db->query("UPDATE td_setting SET  se_value = '".$_POST['adminpanel']."' WHERE se_Key= 'admin_file_name'");
         $db->query("UPDATE td_asmin SET am_fname = '".$_POST['name']."', am_username = '".$_POST['username']."', am_password = '".passwordHash($_POST['password'])."' WHERE id_am = '1' ");

         // If we arrive here, it means that no exception was thrown
         // i.e. no query has failed, and we can commit the transaction
         $db->commit();
     } catch (Exception $e) {
         // An exception has been thrown
         // We must rollback the transaction
         $db->rollback();
     }

 }