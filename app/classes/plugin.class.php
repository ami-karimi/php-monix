<?php
/**
 * Return first doc comment found in this file.
 * 
 * @return string
 */
 
 class Plugin
 {
     var $pagination;
     var $page;
     var $db;

     function __construct()
     {
         $this->db = new Db();

     }

     function Plugin_List()
     {
         $array = array();
         if ($handle = opendir(PLUGIN_DIR)) {
             while (false !== ($entry = readdir($handle))) {
                 $Not_allow = array('.', '..', 'shell');
                 if (!in_array($entry, $Not_allow)) {
                     array_push($array, array(
                             "Title_folder" => $entry
                         )
                     );
                 }
             }
             closedir($handle);
         }
         return $array;
     }

     function Cleare_Comment($str)
     {
         $text = str_replace('Plugin URI:', '', $str);
         $text = str_replace('Plugin Name:', '', $text);
         $text = str_replace('Description:', '', $text);
         $text = str_replace('Version:', '', $text);
         $text = str_replace('Author:', '', $text);
         $text = str_replace('Author URI:', '', $text);
         $text = str_replace('Short Name:', '', $text);
         $text = str_replace('Plugin update URI:', '', $text);
         return $text;
     }

     function getFileDocBlock($dir)
     {
         $docComments = array_filter(
             token_get_all(file_get_contents($dir)), function ($entry) {
             return $entry[0] == T_DOC_COMMENT;
         }
         );
         $fileDocComment = array_shift($docComments);
         $parts = explode("\n", $fileDocComment[1]);
         $comment[1] = trim($parts[1], " *");
         $comment[2] = trim($parts[2], " *");
         $comment[3] = trim($parts[3], " *");
         $comment[4] = trim($parts[4], " *");
         $comment[5] = trim($parts[5], " *");
         $comment[6] = trim($parts[6], " *");
         $comment[7] = trim($parts[7], " *");
         $comment[8] = trim($parts[8], " *");

         return array(
             'Plugin_Name' => $this->Cleare_Comment($comment[1]),
             'Plugin_URI' => str_replace(' ', '', $this->Cleare_Comment($comment[2])),
             'Description' => $this->Cleare_Comment($comment[3]),
             'Version' => str_replace(' ', '', $this->Cleare_Comment($comment[4])),
             'Author' => $this->Cleare_Comment($comment[5]),
             'Author_URI' => str_replace(' ', '', $this->Cleare_Comment($comment[6])),
             'Short_Name' => str_replace(' ', '', $this->Cleare_Comment($comment[7])),
             'Plugin_update_URI' => str_replace(' ', '', $this->Cleare_Comment($comment[8]))
         );
     }

     function Check_InstallPlugin($short_Name)
     {
         $short_Name = trim($short_Name);
         $data = $this->db->row("SELECT pr_key FROM td_personaliz WHERE pr_key = '{$short_Name}'  and pr_group = 'plugin' ");
         if ($data['pr_key'] == $short_Name) {
             $data = $this->db->row("SELECT pr_value FROM td_personaliz WHERE pr_key = :id", array("id" => $short_Name));
             if ($data['pr_value'] == '1') {
                 return 1;
             } elseif ($data['pr_value'] == '0') {
                 return 2;
             }
         } else {
             return 0;
         }
     }

     function GetClassColor($short_Name)
     {
         $short_Name = trim($short_Name);
         $data = $this->db->row("SELECT pr_key FROM td_personaliz WHERE pr_key = '{$short_Name}'  and pr_group = 'plugin' ");
         if ($data['pr_key'] == $short_Name) {
             $data = $this->db->row("SELECT pr_value FROM td_personaliz WHERE pr_key = :id", array("id" => $short_Name));
             if ($data['pr_value'] == 1) {
                 return 'success';
             } elseif ($data['pr_value'] == 0) {
                 return 'warning';
             }
         } else {
             return 'danger';
         }
     }

     function Btn_InstallPlugin($shortName, $dir)
     {
         $check = $this->Check_InstallPlugin($shortName);
         if ($check == 0) {
             return '<a href="/' . se('admin_file_name') . '/manage_plugin?install&short_name=' . $shortName . '&plugin=' . $dir . '" > نصب </a>';
         } elseif ($check == 1) {
             return '<a href="/' . se('admin_file_name') . '/manage_plugin?Uninstall&short_name=' . $shortName . '&plugin=' . $dir . '" > حذف نصب </a>';
         } elseif ($check == 2) {
             return '<a href="/' . se('admin_file_name') . '/manage_plugin?Active&short_name=' . $shortName . '&plugin=' . $dir . '" > فعال سازی </a>';
         }
     }

     function Delete_Btn($ShortName, $dir)
     {
         $check = $this->Check_InstallPlugin($ShortName);
         if ($check == 0 or $check == 2) {
             return '<a href="/' . se('admin_file_name') . '/manage_plugin?delete&short_name=' . $shortName . '&plugin=' . $dir . '" > حذف </a>';
         } else {
             return '';
         }
     }

     function Disable_Btn($ShortName, $dir)
     {
         $check = $this->Check_InstallPlugin($ShortName);
         if ($check == 1) {
             return '<a href="/' . se('admin_file_name') . '/manage_plugin?Disable&short_name=' . $ShortName . '&plugin=' . $dir . '" > غیرفعال کن </a>';
         } else {
             return '';
         }

     }

     function Admin_Btn($ShortName, $dir_name)
     {
         $check = $this->Check_InstallPlugin($ShortName);
         if ($check == 1) {
             $dir = PLUGIN_DIR . $dir_name . "/admin.php";
             if (is_file($dir)) {
                 return '<a href="/' . se('admin_file_name') . '/Admin_plugin?Admin&short_name=' . $ShortName . '&plugin=' . $dir_name . '" > پیکربندی </a>';
             } else {
                 return '';
             }

         } else {
             return false;
         }
     }

     function Get_plugin()
     {
         $productPages = $this->pagination->getResults();
         if (count($productPages) > 0) {
             $this->page = '<div class="numbers">' . $this->pagination->getLinks() . '</div>';
             foreach ($productPages as $productArray) {
                 $dic = $this->getFileDocBlock(PLUGIN_DIR . $productArray['Title_folder'] . "/index.php");
                 $dir = $productArray['Title_folder'];
                 echo '<tr class="' . $this->GetClassColor($dic['Short_Name']) . '">
			       <td><input type="checkbox"></td>
			       <td>' . $dic['Plugin_Name'] . '</td>
				   <td>' . $dic['Description'] . '</br>نسخه :' . $dic['Version'] . '|توسط :<a href="' . $dic['Author_URI'] . '" target="_blank">' . $dic['Author'] . '</a>|<a href="' . $dic['Author_URI'] . '" target="_blank">سایت پلاگین</a></td>
				   <td></td>
				   <td>' . $this->Disable_Btn($dic['Short_Name'], $dir) . '</td>
				   <td>' . $this->Btn_InstallPlugin($dic['Short_Name'], $dir) . '</td>
				   <td>' . $this->Delete_Btn($dic['Short_Name'], $dir) . '</td>
				   <td>' . $this->Admin_Btn($dic['Short_Name'], $productArray['Title_folder']) . '</td>
			</tr>
			';
             }
         }else{
             echo '<tr>
			       <td></td>
			       <td></td>
			       <td></td>
			       <td>افزونه ای موجود نیست</td>
			       <td></td>
			       <td></td>
			       <td></td>
			       </tr>
			       ';
         }
     }

     function Get_Paging()
     {
         echo $this->page;
     }

     function CheckEr_file($so)
     {
         return false;
     }

     function Check_AllowFor_Install($short_name, $dir_name)
     {
         $dir = PLUGIN_DIR . $dir_name;
         if (is_dir($dir)) {
             if (is_file($dir . "/index.php")) {
                 $so = file_get_contents($dir . "/index.php");
                 $checkSo = $this->CheckEr_file($so);
                 if ($checkSo == false) {
                     $check = $this->Check_InstallPlugin($short_name);
                     if ($check == 0) {
                         $this->db->query("INSERT INTO td_personaliz(pr_key,pr_value,pr_group,pr_setting) VALUES(:k,:v,:g,:pr_setting)", array("k" => $short_name, "v" => "1", "g" => "plugin", "pr_setting" => $dir_name));
                         global $hooks;
                         require_once($dir . "/index.php");
                         $hooks->do_action('register_plugin');
                         $check = 1;
                     } else {
                         $check = 8;
                     }
                 } else {
                     $check = 7;
                 }
             } else {
                 $check = 9;
             }

         } else {
             $check = 10;
         }
         return $check;
     }

     function installPlugin($short_name, $dir)
     {
         $check = $this->Check_AllowFor_Install($short_name, $dir);
         if ($check == 1) {
             Redirect('manage_plugin');
             return '<div class="alert alert-success"><strong>نصب شد !</strong>پلاگین مورد نظر با موفقیت نصب شد</div>';
         } elseif ($check == 8) {
             return '<div class="alert alert-danger"><strong> نصب نشد !</strong> پلاگین مورد نظر از قبل نصب شده است </div>';
         } elseif ($check == 9) {
             return '<div class="alert alert-danger"><strong>نصب نشد  !</strong> فایل <b>index.php</b> یافت نشد در مسیر پلاگین ها</div>';
         } elseif ($check == 10) {
             return '<div class="alert alert-danger"><strong>نصب نشد  !</strong>پوشه <b>' . $dir . '</b> یافت نشد در مسیر پلاگین ها</div>';
         } elseif ($check == 7) {
             return '<div class="alert alert-danger">فایل شما دارای خطا میباشد!</div>';
         }
     }

     function UNInstall_Plugin($short_name, $dir_name)
     {
         $dir = PLUGIN_DIR . $dir_name;
         if (is_dir($dir)) {
             if (is_file($dir . "/index.php")) {
                 $check = $this->Check_InstallPlugin($short_name);
                 if ($check !== 0) {
                     $this->db->query("DELETE FROM td_personaliz WHERE pr_key = :id and pr_group = :pr_group ", array("pr_group" => "plugin", "id" => $short_name));

                     $check = 1;
                 } else {
                     $check = 8;
                 }
             } else {
                 $check = 9;
             }
         } else {
             $check = 10;
         }
         return $check;
     }

     function UninstallPlugin($short_name, $dir)
     {
         $check = $this->UNInstall_Plugin($short_name, $dir);
         if ($check == 1) {
             Redirect('manage_plugin');
         } elseif ($check == 8) {
             return '<div class="alert alert-danger"><strong> لغو نصب نشد !</strong> پلاگین مورد نظر هنوز نصب نشده است </div>';
         } elseif ($check == 9) {
             return '<div class="alert alert-danger"><strong> لغو نصب نشد  !</strong> فایل <b>index.php</b> یافت نشد در مسیر پلاگین ها</div>';
         } elseif ($check == 10) {
             return '<div class="alert alert-danger"><strong> لغو نصب نشد  !</strong>پوشه <b>' . $dir . '</b> یافت نشد در مسیر پلاگین ها</div>';
         }
     }

     function Active_Plugin($short_name, $dir_name)
     {
         $dir = PLUGIN_DIR . $dir_name;
         if (is_dir($dir)) {
             if (is_file($dir . "/index.php")) {
                 $check = $this->Check_InstallPlugin($short_name);
                 if ($check == 2) {
                     $this->db->query("UPDATE td_personaliz SET pr_value = '1' WHERE pr_key = :id and pr_group = :pr_group ", array("pr_group" => "plugin", "id" => $short_name));
                     global $hooks;
                     require_once($dir . "/index.php");
                     $check = 1;
                 } else {
                     $check = 8;
                 }
             } else {
                 $check = 9;
             }
         } else {
             $check = 10;
         }
         return $check;
     }

     function ActivePlugin($short_name, $dir)
     {
         $check = $this->Active_Plugin($short_name, $dir);
         if ($check == 1) {
             Redirect('manage_plugin');
         } elseif ($check == 8) {
             return '<div class="alert alert-danger"><strong> فعال نشد !</strong> پلاگین مورد نظر از قبل فعال شده است </div>';
         } elseif ($check == 9) {
             return '<div class="alert alert-danger"><strong> فعال نشد  !</strong> فایل <b>index.php</b> یافت نشد در مسیر پلاگین ها</div>';
         } elseif ($check == 10) {
             return '<div class="alert alert-danger"><strong> فعال نشد  !</strong>پوشه <b>' . $dir . '</b> یافت نشد در مسیر پلاگین ها</div>';
         }
     }

     function Disable_Plugin($short_name, $dir_name)
     {
         $dir = PLUGIN_DIR . $dir_name;
         if (is_dir($dir)) {
             if (is_file($dir . "/index.php")) {
                 $check = $this->Check_InstallPlugin($short_name);
                 if ($check == 1) {
                     $this->db->query("UPDATE td_personaliz SET pr_value = '0' WHERE pr_key = :id and pr_group = :pr_group ", array("pr_group" => "plugin", "id" => $short_name));
                     global $hooks;
                     require_once($dir . "/index.php");
                     $check = 1;
                 } else {
                     $check = 8;
                 }
             } else {
                 $check = 9;
             }
         } else {
             $check = 10;
         }
         return $check;
     }


     function DisablePlugin($short_name, $dir)
     {
         $check = $this->Disable_Plugin($short_name, $dir);
         if ($check == 1) {
             Redirect('manage_plugin');
         } elseif ($check == 8) {
             return '<div class="alert alert-danger"><strong> غیر فعال نشد !</strong> پلاگین مورد نظر از قبل غیر فعال شده </div>';
         } elseif ($check == 9) {
             return '<div class="alert alert-danger"><strong> غیر فعال نشد  !</strong> فایل <b>index.php</b> یافت نشد در مسیر پلاگین ها</div>';
         } elseif ($check == 10) {
             return '<div class="alert alert-danger"><strong> غیر فعال نشد  !</strong>پوشه <b>' . $dir . '</b> یافت نشد در مسیر پلاگین ها</div>';
         }
     }

     function check_Admin_Plugin($short_name, $dir)
     {
         $dir_name = PLUGIN_DIR . $dir;
         if (is_dir($dir_name)) {
             if (is_file($dir_name . "/admin.php")) {
                 $checks = $this->Check_InstallPlugin($short_name);
                 if ($checks == 1) {
                     $check = 1;
                 } else {
                     $check = 8;
                 }
             } else {
                 $check = 9;
             }
         } else {
             $check = 10;
         }
         if ($check == 1) {
             return 1;
         } elseif ($check == 8) {
             Redirect('manage_plugin');
         } elseif ($check == 9) {
             Redirect('manage_plugin');
         } elseif ($check == 10) {
             Redirect('manage_plugin');
         }
     }


     public function upload_Plugin()
     {
         $er_array = array();
         $file = "";
         if (!empty($_FILES['file']['name'])) {
             $handle = new Upload($_FILES['file']);
             if ($handle->uploaded) {
                 $dir = $_SERVER['DOCUMENT_ROOT'] . "/Connect/Plugin/";
                 $handle->allowed = array('application/x-rar-compressed', 'application/octet-stream', 'application/zip', 'application/x-zip-compressed', 'multipart/x-zip');
                 $handle->Process($dir);
                 if ($handle->processed) {
                     $check = 1;
                     array_push($er_array, 'با موفقیت بارگذاری شد!');
                     $handle->Clean();
                     $file = $dir . $handle->file_dst_name;
                 } else {
                     $check = 0;
                     array_push($er_array, 'خطا در بارگذاری !');
                 }
             } else {
                 $check = 0;
                 array_push($er_array, 'خطا در بارگذاری !');
             }
         } else {
             $check = 0;
             array_push($er_array, 'لطفا فایل خود را انتخاب نمایید!');
         }
         return array('check' => $check, 'msg' => implode('', $er_array),'file'=> $file);
     }

 }
 
