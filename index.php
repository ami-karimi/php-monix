<?php
    /* Please observe the publisher's rights
    * website : munix.ir
     * forum : forum.munix.ir
     * Iran
     *  Edit Date : 2018-06-15
     * Monix native script open source
    */

    // Display Error log
   // 1 On 0 Off
     error_reporting(0);
     // Check Install Script
     if(!is_file('app/config.php')){
         header('location: install/index.php ');
         // check Remove Install Dir
     }elseif(is_dir('install')) {
         die('لطفا قبل از اجرای برنامه پوشه install را حذف نمایید');
     }
     // Start Script
     else{
         session_start();
         $time_start = microtime(true);
         require_once('Monix.php');
         $time_end = microtime(true);
         $execution_time = ($time_end - $time_start) / 60;
     }