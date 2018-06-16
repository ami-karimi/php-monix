<?php
// ************************************* //
//            Monix Tiketing System     //
//              http://monix.ir        //
// *************************************//
require_once('lib/jdf.php');
$theme = se('website_template');
define('THEME_NAME',$theme);
$theme_default = CONNECT_DIR."theme/{$theme}";
define('THEME_DEFAULT',$theme_default);
$theme_path = "/Connect/theme/{$theme}";
define('THEME_PATH',$theme_path);
$theme_path2 = "/Connect/theme";
define('THEME_MAIN_PATH',$theme_path2);

function removeslashes($string)
{
    $string=implode("",explode("\\",$string));
    return stripslashes(trim($string));
}
function xss_cleaner($input_str) {
    $return_str = str_replace( array('<','>',"'",'"',')','('), array('&lt;','&gt;','&apos;','&#x22;','&#x29;','&#x28;'), $input_str );
    $return_str = str_ireplace( '%3Cscript', '', $return_str );
    return $return_str;
}

function passwordHash($str){
    $hash=md5(crypt(Md5($str),'7c348d0e3baaca53419cd7eb74b56b1e'));
    return $hash;
}
function filter($post){

    $post= preg_replace('/(?:<|&lt;)\/?([a-zA-Z]+) *[^<\/]*?(?:>|&gt;)/', '',htmlspecialchars(strip_tags($post)));
    return $post;
}
function Redirect($loc){

    echo '<script type="text/javascript">
           window.location = "'.$loc.'"
      </script>';

}
function ago($time)
{
    $periods = array("ثانیه", "دقیقه", "ساعت", "روز", "هفته", "ماه", "سال", "خیلی وقت پیش");
    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $difference     = $now - $time;
    $tense         = "";

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if($difference != 1) {
        $periods[$j].= "";
    }

    return "$difference $periods[$j] پیش ";
}
function convert($string) {
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);
    return str_replace($num,$persian, $string);
}

function getUserIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return htmlspecialchars(strip_tags($ipaddress));
}
function check_val($username,$by,$tabel){
    $db = new Db();
    $user = $db->row("SELECT * FROM {$tabel} WHERE  {$by} = :username", array("username"=>$username));
    if(count($user['id_us']) > 0){
        $check ="1";
    }else{
        $check ="0";
    }

    return $check;
}

function get_user_informat(){
    $db = new Db();
    $user = $db->row("SELECT * FROM mo_user WHERE  id_us = :id", array("id"=>$_SESSION['user_id']));

    return $user;
}

function se($id){
    $db = new Db();
    $query = $db->row("SELECT * FROM td_setting WHERE  se_Key = :id", array("id"=>$id));
    $data = $query['se_value'];
    return $data;
}

function get_last_code(){
    $db = new Db();
    $query = $db->row("SELECT * FROM td_tiket ORDER BY id_tiket DESC ");
    $export = intval($query['id_tiket']) + 1;
    return $export;
}

function state_tiket($state){
    $export = "";
    switch($state){
        case '1':
            $export = '<span style="line-height: 20px;" class="label label-default">باز </span>';
            break;
        case '2':
            $export = '<span style="line-height: 20px;" class="label label-primary"> در انتظار پاسخ </span>';
            break;
        case '3':
            $export = '<span style="line-height: 20px;" class="label label-success"> پاسخ داده شد </span>';
            break;
        case '4':
            $export = '<span style="line-height: 20px;" class="label label-danger"> بسته شده </span>';
            break;
    }

    return $export;
}
function last_massage($last){
    switch($last){
        case '0':
            $export = '<span style="color:#d46016;"> کاربر </span>';
            break;
        case '1':
            $export = '<span style="color:green">کارمند</span>';
            break;
    }

    return $export;
}
function last_massage_nocolor($last){
    switch($last){
        case '0':
            $export = 'کاربر ';
            break;
        case '1':
            $export = 'کارمند';
            break;
    }

    return $export;
}
function get_file($code){
    $db = new Db();
    $tiket = $db->row("SELECT * FROM  td_file WHERE fl_code = '{$code}' and fl_state ='1' LIMIT 1 ");
    if(count($tiket['id_fl']) > 0){
        return $tiket;
    }else{
        return '0';
    }
}
function get_file_guest($id){
    $db = new Db();
    $tiket = $db->row("SELECT * FROM  td_file WHERE  id_fl = '{$id}' and fl_user_id = '0' and fl_state ='1' LIMIT 1 ");
    if(count($tiket['id_fl']) > 0){
        return $tiket;
    }else{
        return '0';
    }
}

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}
function users(){
    if(isset($_SESSION['user_id'])){
        $db = new Db();
        $query = $db->row("SELECT * FROM td_user WHERE id_user ='".$_SESSION['user_id']."' ");
        return $query;
    }else{
        return 0;
    }
}
function counter($query){
    $db = new Db();
    $query = $db->query($query);
    $count = count($query);
    return $count;
}
function sendmail($type,$data){
    if($type == "code"){
        $msg = "با سلام ".$data['name']."گرامی  کد رهگیری شما :".$data['code'];
        $msg = wordwrap($msg,70);
        mail($data['email'],"کد رهگیری -".se('site_title'),$msg);
    }
}
function csrf_token(){
    $security = new \security\CSRF;
    $token = $security->set(3, 3600);
    echo '<input type="hidden" data-validation-skipped="1" name="CSRF_TOKEN" value="'.$token.'" />';
}
function get_admin_name($id){
    $db = new Db();
    $user = $db->row("SELECT * FROM  td_asmin WHERE id_am = '{$id}' and am_state = '1' LIMIT 1 ");
    if(!empty($user['am_fname'])){
        return $user['am_fname']." ".$user['am_lname'];
    }else{
        return "ناشناس!";
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class SendMail {
    var $to; // Email to
    var $type; // Types Email
    var $SubjectMail;
    var $data;
    var $body;
    var $title;
    function User_information(){
        $db = new Db();
        return $db->row("SELECT * FROM  td_user WHERE id_user = :id and s_state = 1 ",array('id'=>$_SESSION['user_id']));
    }
    function GetMailInformation(){
        return array('Host'=>se('SMTP_HOST'),'username'=>se('SMTP_username'),'password'=>se('SMTP_password'),'port'=>se('SMTP_port'));
    }

    function Mail_to(){
        $mail = new PHPMailer(true);
        try {
            if($this->type == "1"){
                $dt = $this->GetMailInformation();

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = $dt['Host'];  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = $dt['username'];                 // SMTP username
                $mail->Password = $dt['password'];                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $dt['port'];                                    // TCP port to connect to
                $form = "info@".$_SERVER['HTTP_HOST'];
                $mail->setFrom($form, se('site_title')."-".$this->title);
                $mail->addAddress($this->to, $this->to);             // Name is optional
                $mail->addReplyTo('no-reply@example.com', 'noreply');
                $mail->addCC($form, se('site_title')."-".$this->title);
                $mail->addBCC($this->to, $this->to);
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $this->SubjectMail;
                $mail->Body    = $this->pattern_Email();
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->send();

            }else{
                $form = "info@".$_SERVER['HTTP_HOST'];
                $mail->setFrom($form, se('site_title')."-".$this->title);
                $mail->addReplyTo('no-reply@example.com', 'noreply');
                $mail->CharSet = 'UTF-8';
                $mail->addAddress($this->to, $this->to);
                $mail->Subject = $this->SubjectMail;
                $mail->Body    = $this->pattern_Email();
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                $mail->send();

            }
        } catch (Exception $e) {

        }
    }

    function pattern_Email(){
        $species = $this->body;
        $user = $this->User_information();
        $data = $this->data;
        if($species == "change_password"){
            $out = '<div  style="direction: rtl;text-align:right;"><p>با سلام '.$user['s_full_name'].' عزیز </p><p>به استحضار شما میرسانیم که : </p><p>دقایقی پیش رمز عبور شما در سامانه ما  تغییر کرده است. </p><p> جهت ورود به سامانه <a href="http://'.$_SERVER['HTTP_HOST'].'">کلیک کنید</a></div>';
            return $out;
        }
        elseif($species == "New_Support_Tiket"){
            $out = '<div  style="direction: rtl;text-align:right;"><p>با سلام '.$user['s_full_name'].' عزیز </p><p>به استحضار شما میرسانیم که : </p><p> درخواست شما با موفقیت ایجاد شد ، بزودی  یکی از  کارشناسان پاسخ شما را خواهند داد لطفا کمی صبر نمایید. </p><p>اطلاعات درخواست :</p><p>عنوان درخواست : '.$data['tiket_title'].'</p><p>تاریخ ایجاد : '.$data['date_create'].'</p><p>وضعیت درخواست :'.$data['state_tiket'].'</p><p>کد درخواست : <a href="http://'.$_SERVER['HTTP_HOST'].'/?route=show_tiket&tiket_code='.$data['tiket_code'].'">#'.$data['tiket_code'].'</a></p><p>با تشکر از صبر و بردباری شما.</p><p> جهت ورود به سامانه <a href="http://'.$_SERVER['HTTP_HOST'].'">کلیک کنید</a></div>';
            return $out;
        }
        elseif($species == "New_Support_Tiket_forAdmin"){
            $out = '<div  style="direction: rtl;text-align:right;"><p>درخواست جدیدی کاربر  '.$user['s_full_name'].' ایجاد کرد </p><p>به استحضار شما میرسانیم که : </p><p> در سامانه پشتیبانی تیکت جدیدی ایجاد شد و در انتظار پاسخ میباشد </p><p>اطلاعات درخواست :</p><p>عنوان درخواست : '.$data['tiket_title'].'</p><p>تاریخ ایجاد : '.$data['date_create'].'</p><p>وضعیت درخواست :'.$data['state_tiket'].'</p><p>کد درخواست : <a href="http://'.$_SERVER['HTTP_HOST'].'/tk-panel/?route=show_tiket&id='.$data['tiket_code'].'">#'.$data['tiket_code'].'</a></p><p> جهت ورود به سامانه <a href="http://'.$_SERVER['HTTP_HOST'].'">کلیک کنید</a></div>';
            return $out;
        }elseif($species == "New_Response_Tiket_forAdmin"){
            $out = '<div  style="direction: rtl;text-align:right;"><p>پاسخ جدیدی کاربر  '.$user['s_full_name'].' ارسال کرد </p><p>به استحضار شما میرسانیم که : </p><p> پاسخ جدید برای درخواست ایجاد نموده ارسال شد </p><p>پاسخ کاربر : '.$data['Msg'].'</p><p>اطلاعات درخواست :</p><p>عنوان درخواست : '.$data['tiket_title'].'</p><p>تاریخ ایجاد : '.$data['date_create'].'</p><p>وضعیت درخواست :'.$data['state_tiket'].'</p><p>کد درخواست : <a href="http://'.$_SERVER['HTTP_HOST'].'/tk-panel/?route=show_tiket&id='.$data['tiket_code'].'">#'.$data['tiket_code'].'</a></p><p> جهت ورود به سامانه <a href="http://'.$_SERVER['HTTP_HOST'].'">کلیک کنید</a></div>';
            return $out;
        }


    }
}
class user {
    var $db; // DataBase
    function _clear($text){
        return htmlspecialchars(strip_tags($text));
    }
    function GetUser_Information(){
        return $this->db->row("SELECT * FROM  td_user WHERE id_user = :id and s_state = 1 ",array('id'=>$_SESSION['user_id']));
    }
    function update_last_log($id){
        $this->db->query("UPDATE td_user SET s_lastlog_time = :s_lastlog_time,s_ip = :ip WHERE id_user = :id",array('s_lastlog_time'=>time(),'ip'=> getUserIP(),'id'=>$id));
    }
    function EditPassword($my_pass,$password,$re_password){
        $my_pass = $this->_clear($my_pass);
        $password = $this->_clear($password);
        $re_password = $this->_clear($re_password);
        $er_return = array();
        $user = $this->GetUser_Information();
        $check = 1;
        if(!empty($password)){
            if($password !== $re_password){
                array_push($er_return,'رمز عبور ها با هم مطابقت ندارند');
                $check = 0;
            }else{
                if(passwordHash($my_pass) !== $user['s_password']){
                    array_push($er_return,'رمز عبور وارد شده  با رمز عبور فعلی تفاوت دارد');
                    $check = 0;
                }
            }
        }else{
            $check = 0;
            array_push($er_return,'رمز عبور نباید خالی باشد!');
        }

        if($check < 1){
            return $er_return;
        }else{
            $this->db->query("UPDATE td_user SET s_password = :password WHERE id_user = :id and s_state = 1 ",array('id'=>$_SESSION['user_id'],'password'=>passwordHash($password)));
            $this->SendMailChangePass();
            return 'true';
        }

    }
    function SendMailChangePass(){
        $user = $this->GetUser_Information();
        $mails = new SendMail();
        $mails->to = $user['s_email'];
        $mails->type = se('mail_stamp');
        $mails->title = 'تغییر رمز عبور';
        $mails->SubjectMail = 'تغییر رمز عبور - '.se('site_title')."- Taghir Ramz Obor";
        $mails->body = 'change_password';
        $mails->Mail_to();
    }

    function send_mail_new_tiket($id){
        $user = $this->GetUser_Information();
        $tiket = $this->GetTiketInformation($id);
        $mails = new SendMail();
        $mails->to = $user['s_email'];
        $mails->type = se('mail_stamp');
        $mails->title = 'درخواست جدید -'.$tiket['tk_title'];
        $mails->SubjectMail = 'تیکت جدید - '.se('site_title')."- Tiket Jadid";
        $mails->body = 'New_Support_Tiket';
        $mails->data = array('tiket_code'=>$tiket['tk_code'],'tiket_title'=>$tiket['tk_title'],'date_create'=>substr($tiket['tk_date_in'],0,10),'state_tiket'=>state_tiket($tiket['tk_state']));
        $mails->Mail_to();

        $mails_admin = new SendMail();
        $mails_admin->to = se('admin_email');
        $mails_admin->type = se('mail_stamp');
        $mails_admin->title = 'درخواست جدید -'.$tiket['tk_title'];
        $mails_admin->SubjectMail = 'تیکت جدید - '.se('site_title')."- Tiket Jadid";
        $mails_admin->body = 'New_Support_Tiket_forAdmin';
        $mails_admin->data = array('tiket_code'=>$tiket['tk_code'],'tiket_title'=>$tiket['tk_title'],'date_create'=>substr($tiket['tk_date_in'],0,10),'state_tiket'=>state_tiket($tiket['tk_state']));
        $mails_admin->Mail_to();

    }
    function send_mail_tiket_response($id){
        $tiket = $this->GetTiketInformation($id);
        $tiket_parent = $this->GetTiketParentInformation($tiket['tk_parent']);
        $mails_admin = new SendMail();
        $mails_admin->to = se('admin_email');
        $mails_admin->type = se('mail_stamp');
        $mails_admin->title = 'پاسخ به -'.$tiket['tk_title'];
        $mails_admin->SubjectMail = 'پاسخ به تیکت - '.se('site_title')."- Pasokh Jadid";
        $mails_admin->body = 'New_Response_Tiket_forAdmin';
        $mails_admin->data = array('Msg'=>$tiket['tk_massage'],'tiket_code'=>$tiket['tk_parent'],'tiket_title'=>$tiket_parent['tk_title'],'date_create'=>substr($tiket_parent['tk_date_in'],0,10),'state_tiket'=>state_tiket($tiket_parent['tk_state']));
        $mails_admin->Mail_to();
    }

    function GetTiketInformation($id){
        return $this->db->row("SELECT * FROM  td_tiket WHERE tk_user_id = :id and id_tiket = :id_tiket ",array('id'=>$_SESSION['user_id'],'id_tiket'=>$id));
    }
    function GetTiketParentInformation($code){
        return $this->db->row("SELECT * FROM  td_tiket WHERE tk_user_id = :id and tk_code = :code and tk_parent = 0 ",array('id'=>$_SESSION['user_id'],'code'=>$code));
    }
    function Check_lastUsername($username){
        $user =  $this->db->row("SELECT s_username FROM  td_user WHERE s_username = :username ",array('username'=>$username));
        if(!empty($user['s_username'])){
            return 0;
        }else{
            return 1;
        }
    }
    function Check_lastEmail($email){
        $user =  $this->db->row("SELECT s_email FROM  td_user WHERE s_email = :email ",array('email'=>$email));
        if(!empty($user['s_email'])){
            return 0;
        }else{
            return 1;
        }
    }
    function validate_edit_pro($username,$name,$dicirption,$email){
        $min_len_username = se('min_len_username');
        $max_len_username = se('max_len_username');
        $max_len_dicirption = se('max_len_dicirption_user');
        $max_len_name = se('max_len_name');
        $data = array(
            'نام_کاربری' => $username,
            'نام_کامل' => $name,
            'توضیحات_اضافی' => $dicirption,
            'ایمیل' => $email
        );
        $validated = GUMP::is_valid($data, array(
            'نام_کاربری' =>       "required|min_len,{$min_len_username}|max_len,{$max_len_username}",
            'نام_کامل' =>      "required|max_len,{$max_len_name}",
            'توضیحات_اضافی'  => "max_len,{$max_len_dicirption}",
            'ایمیل' =>      "required|valid_email"
        ));

        if($validated === true) {
            return 1;
        } else {
            return $validated;
        }
    }
    function Edit_profile($name,$username,$email,$diciprion){
        $name = $this->_clear($name);
        $username = $this->_clear($username);
        $email = $this->_clear($email);
        $diciprion = $this->_clear($diciprion);
        $user = $this->GetUser_Information();
        $check = 1;
        $validate_data = $this->validate_edit_pro($username,$name,$diciprion,$email);

        if($validate_data == 1){
            $er_return = array();
            // Check Last User
            if($username !== $user['s_username']){
                $check_username = $this->Check_lastUsername($username);
                if($check_username < 1){
                    array_push($er_return,'نام کاربری قبلا گرفته شده است');
                    $check = 0;
                }
            }
            if($email !== $user['s_email']){
                $check_email = $this->Check_lastEmail($email);
                if($check_email < 1){
                    array_push($er_return,'ایمیل وارد شده قبلا گرفته شده است');
                    $check = 0;
                }
            }
            if($check == 1){
                $this->db->query("UPDATE td_user SET s_username = :username , s_email = :email , s_full_name = :fullname , s_dicription = :dicription WHERE id_user = :id and s_state = 1 ",array('id'=>$_SESSION['user_id'],'email'=>$email,'username'=>$username,'fullname'=>$name,'dicription'=>$diciprion));
                return 'true';
            }else{
                return $er_return;
            }
        }else{
            return $validate_data;
        }

    }

}

class setting {
    var $db;

    function send_tiket_ghost(){
        if(se('send_tiket_goust') == "1"){
            return '<a href="?Guest" type="button" class="btn  btn-warning"> ارسال  تیکت به عنوان مهمان  </a>';
        }else{
            return false;
        }
    }
    function create_account(){
        if(se('register_new_user') == "1"){
            return '<label>  حساب  کاربري  نداريد؟ </label><a onclick="$(\'#register\').show();$(\'#login\').hide();" href="#"> ايجاد حساب</a> ';
        }else{
            return false;
        }
    }

}

function _register_user(){
    return se('register_new_user');
}
function _SendTiketGoust(){
    return se('send_tiket_goust');
}
function _clear($text){
    return htmlspecialchars(strip_tags($text));
}
class register_user {
    var $db;

    function Check_lastUsername($username){
        $user =  $this->db->row("SELECT s_username FROM  td_user WHERE s_username = :username ",array('username'=>$username));
        if(!empty($user['s_username'])){
            return 0;
        }else{
            return 1;
        }
    }
    function Check_lastEmail($email){
        $user =  $this->db->row("SELECT s_email FROM  td_user WHERE s_email = :email ",array('email'=>$email));
        if(!empty($user['s_email'])){
            return 0;
        }else{
            return 1;
        }
    }

    function validate_user($name,$username,$password,$email,$dicription){
        $min_len_username = se('min_len_username');
        $max_len_username = se('max_len_username');
        $max_len_dicirption = se('max_len_dicirption_user');
        $max_len_name = se('max_len_name');
        $min_len_password = se('min_len_pass');
        $max_len_password = se('max_len_pass');
        $data = array(
            'نام_کاربری' => $username,
            'نام_کامل' => $name,
            'توضیحات_اضافی' => $dicription,
            'ایمیل' => $email,
            'رمز_عبور' => $password
        );
        $validated = GUMP::is_valid($data, array(
            'نام_کاربری' =>       "required|min_len,{$min_len_username}|max_len,{$max_len_username}",
            'نام_کامل' =>      "required|max_len,{$max_len_name}",
            'توضیحات_اضافی'  => "max_len,{$max_len_dicirption}",
            'ایمیل' =>      "required|valid_email",
            'رمز_عبور' =>   "required|min_len,{$min_len_password}|max_len,{$max_len_password}",
        ));

        if($validated === true) {
            return 1;
        } else {
            return $validated;
        }
    }
    function _clear($text){
        return htmlspecialchars(strip_tags($text));
    }
    function create_user($name,$username,$password,$email,$dicription){
        if(se('register_new_user') == "1"){
            $name = $this->_clear($name);
            $username = $this->_clear($username);
            $password = $this->_clear($password);
            $email = $this->_clear($email);
            $dicription = $this->_clear($dicription);
            $check =  $this->validate_user($name,$username,$password,$email,$dicription);
            if($check == 1){
                $er_return =  array();

                $check_username = $this->Check_lastUsername($username);
                if($check_username == 0){
                    array_push($er_return,'نام کاربری قبلا گرفته شده');
                    $check = 0;
                }

                $check_email = $this->Check_lastEmail($email);
                if($check_email == 0){
                    array_push($er_return,'ایمیل قبلا گرفته شده است');
                    $check = 0;
                }
                if($check == 0){
                    return $er_return;
                }else{
                    $this->db->query("INSERT INTO  td_user(s_full_name,s_username,s_password,s_email,s_reg_in_date,s_reg_in_time,s_lastlog_time,s_state,s_ip,s_dicription) VALUES(:s_full_name,:s_username,:s_password,:s_email,:s_reg_in_date,:s_reg_in_time,:s_lastlog_time,:s_state,:s_ip,:s_dicription)",
                        array("s_full_name"=>$name,
                            "s_username"=>$username,
                            "s_password"=> passwordHash($password),
                            "s_email"=> $email,
                            "s_lastlog_time"=>time(),
                            "s_ip"=> getUserIP(),
                            "s_reg_in_time"=>time(),
                            "s_reg_in_date"=> jdate('Y-m-d H:i:s'),
                            "s_dicription" => $dicription,
                            "s_state"=> '1'
                        ));
                    $_SESSION['user_login'] = true;
                    $_SESSION['user_id'] = $this->db->lastInsertId();;
                    return 'true';
                }
            }else{
                return $check;
            }
        }else{
            return 'false';
        }
    }
}
function file_mime_type($file, $encoding=true) {
    $mime=false;

    if (function_exists('finfo_file')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);
    }
    else if (substr(PHP_OS, 0, 3) == 'WIN') {
        $mime = mime_content_type($file);
    }
    else {
        $file = escapeshellarg($file);
        $cmd = "file -iL $file";

        exec($cmd, $output, $r);

        if ($r == 0) {
            $mime = substr($output[0], strpos($output[0], ': ')+2);
        }
    }

    if (!$mime) {
        return false;
    }

    if ($encoding) {
        return $mime;
    }

    return substr($mime, 0, strpos($mime, '; '));
}

function lang_jsurl(){
    if(defined('LANG_FOLDER')){
        return '<script type="text/javascript" src="/lang?js&lang='.LANG_DEFINE.'"></script>';
    }
}

function save_spamer($con){

    $values = array(
        'ip_spam' => getUserIP(),
        'time_stam' => time(),
        'date_spam' => jdate('Y-m-d H:i:s'),
        'url_page' => url(),
        'user_id' => $_SESSION['admin_id']
    );
    Mysql::insert($values, 'td_spamer',$con);
}


function url(){
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
    );
}

function hashimage($url,$type){

    $img= base64_encode(file_get_contents($url));
    $src = 'data:image/'.$type.';base64,'.$img;
    return $src;
}

function  insert_log($type,$code_er) {
    $db = new Db();
    $code = array(
        '1' => 'ورود به پنل  مدیریت  نا موفق',
        '2' => 'ورود به پنل  مدیریت موفق'
    );
    $subject = $code[$code_er];
    $insert = $db->query("INSERT INTO td_log(lo_subject,lo_type,lo_ip,lo_date,lo_time) VALUES(:sub,:ty,:ip,:da,:ti)", array("sub"=>$subject,"ty"=>$type,"ip"=>getUserIP(),"da"=>get_time_date('date_time'),"ti"=>time()));
}



function creat_folder_upload($dir){
    $y = jdate('Y');
    $m = jdate('m');
    $y_dir = $dir."/".$y."/";
    $m_dir = $y_dir.$m."/";
    if(!is_dir($y_dir)){
        mkdir($y_dir);
    }
    if(!is_dir($m_dir)){
        $m = mkdir($m_dir);
    }
    return $m_dir;
}
function insert_file_up($filename,$file_type,$file_size,$file_min_path,$file_full_path,$file_code,$file_site_id) {
    $db = new Db();
    $insert = $db->query("INSERT INTO td_file(fl_filename,fl_type,fl_size,fl_min_path,fl_full_path,fl_user_id,fl_code,fl_site_id
		,fl_state,fl_date_upload,fl_time_upload,fl_state_download,fl_state_delete) 
		VALUES(:fl_filename,:fl_type,:fl_size,:fl_min_path,:fl_full_path,:fl_user_id,:fl_code,:fl_site_id
		,:fl_state,:fl_date_upload,:fl_time_upload,:fl_state_download,:fl_state_delete)",
        array("fl_filename"=>$filename,"fl_type"=>$file_type,"fl_size"=>$file_size,"fl_min_path"=>$file_min_path,"fl_full_path"=>$file_full_path,"fl_user_id"=>$_SESSION['admin_id'],'fl_code'=>$file_code,'fl_site_id'=>$file_site_id
        ,'fl_state'=>'1',"fl_date_upload"=>get_time_date('date_time'),"fl_time_upload"=>time(),'fl_state_download'=>'1','fl_state_delete'=>'1'));

    if($insert > 0 ){
        $id = $db->lastInsertId();
    }

    return $id;
}



function state_user($state){
    switch($state){
        case '0':
            $export = '<span  class="btn btn-danger  btn-xs">غیر فعال</span>';
            break;
        case '1':
            $export = '<span  class="btn btn-success  btn-xs"> فعال </span>';
            break;
        case '2':
            $export = '<span class="btn btn-warning  btn-xs"> بلاک شده </span>';
            break;
    }

    return $export;
}
function check_last_username($username){
    $db = new Db();
    $person = $db->row("SELECT * FROM  td_user WHERE  	s_username = :username " ,array("username"=>$username));
    if(!empty($person['id_user'])){
        $check ="1";
    }else{
        $check ="0";
    }

    return $check;
}
function check_last_email($email){
    $db = new Db();
    $person = $db->row("SELECT * FROM  td_user WHERE  	s_email = :email " ,array("email"=>$email));
    if(!empty($person['id_user'])){
        $check ="1";
    }else{
        $check ="0";
    }

    return $check;
}
function check_last($data,$type,$tabel){
    $db = new Db();
    switch($type){
        case 'username':
            if($tabel =="asmin"){
                $by = "am_username";
            }elseif($tabel =="user"){
                $by = "s_username";
            }
            break;
        case 'email':
            if($tabel =="asmin"){
                $by = "am_email";
            }elseif($tabel =="user"){
                $by = "s_email";
            }

            break;

    }
    $person = $db->row("SELECT * FROM  td_{$tabel} WHERE  {$by} = :data " ,array("data"=>$data));
    if(!empty($person[$by])){
        $check ="1";
    }else{
        $check ="0";
    }
    return $check;
}

function type_admin($state){
    switch($state){
        case '0':
            $export = '<span  class="btn btn-danger  btn-xs"> مدیریت </span>';
            break;
        case '1':
            $export = '<span  class="btn btn-success  btn-xs"> فعال </span>';
            break;
        case '2':
            $export = '<span class="btn btn-warning  btn-xs"> بلاک شده </span>';
            break;
        default :
            $export = '<span class="btn btn-info  btn-xs"> اپراتور </span>';
            break;
    }

    return $export;
}

function user(){
    if(isAdmin() == 1){
        $db = new Db();
        $user = $db->row("SELECT * FROM  td_asmin WHERE id_am = '".$_SESSION['admin_id']."' and am_state ='1'");
        return $user;
    }else{
        return 0;
    }
}


function  upload_files($id){
    $db = new Db();
    $fileName = "tk_".get_last_code().rand(1,1000)."_".date('Y-m-d')."_".$_FILES['file']['name'];
    $fileTmpLoc = $_FILES['file']['tmp_name'];
    $dir = $_SERVER['DOCUMENT_ROOT']."/Connect/upload/zip/";
    $fileDirectory = $dir.basename(str_replace(' ','-',$_FILES['file']['name']));
    $allowed_ext = 'application/zip';
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $filetype = $_FILES['file']['type'];
    $min_path = "../Connect/upload/zip/{$fileName}";
    $full_path = "http://".$_SERVER["HTTP_HOST"]."/Connect/upload/zip/{$fileName}";
    if(!$fileTmpLoc){
        $msg=  "<script > show_massage('خطای غیر  منتظره !','danger') </script>";
        exit();
        $check = "0";
    }
    else
        if(!$fileSize > 1048576){
            $msg=  "<script > show_massage('حجم  فایل  نباید بیشتر از  1 مگابایت باشد','danger') </script>";
            unlink($fileTmpLoc);
            exit();
            $check = "0";
        }
        else
            if($filetype !== $allowed_ext){
                $msg= "<script > show_massage('تنها فایل های  zip قابل بارگذاری  میباشند','danger') </script>";
                unlink($fileTmpLoc);
                exit();
                $check = "0";
            }
            else
                if($fileError > 0){
                    $msg=  "<script > show_massage('خطایی  پیش  امد  لطفا  مجددا امتحان نمایید','danger') </script>";
                    unlink($fileTmpLoc);
                    exit();
                    $check = "0";
                }
                else{
                    if(file_exists($dir. $fileName))
                    {
                        $msg=  "<script > show_massage('فایلی با این  نام موجود میباشد لطفا مجددا امتحان نمایید','danger') </script>";
                        $check = "0";
                    }
                    else{
                        move_uploaded_file($fileTmpLoc, $dir .$fileName);
                        $insert   =  $db->query("INSERT INTO 
					 td_file(fl_filename,fl_code,fl_type,fl_min_path,fl_full_path,fl_user_id,fl_state,fl_timestamp,fl_size) VALUES
					 (:fl_filename,:fl_code,:fl_type,:fl_min_path,:fl_full_path,:fl_user_id,:fl_state,:fl_timestamp,:fl_size)",
                            array("fl_filename"=>$fileName,"fl_code"=>$_SESSION['code_request'],'fl_type'=>'application/zip','fl_min_path'=>$min_path,'fl_full_path'=>$full_path,'fl_user_id'=>intval($id),'fl_state'=>'1','fl_timestamp'=>time(),'fl_size'=>$fileSize));
                        $files =  $db->lastInsertId();
                    }


                }

    return $files;
}

function show_tikets(){
    if(isAdmin() == 1){
        $db = new Db();
        $user = $db->row("SELECT * FROM  td_asmin WHERE  id_am = ".$_SESSION['admin_id']);
        if($user !== 0){
            return $user['am_type'];
        }else{
            return "0";
        }
    }else{
        die();
    }
}

class Send_email{
    var $type;
    var $db;
    function sends($id,$tiket_id){
        if($this->type == "response_tiket"){

            $user = $this->GetUser_Information($id);
            $tiket = $this->GetTiketInformation($user['id_user'],$tiket_id);
            $parent = $this->GetTiketParentInformation($id,$tiket['tk_parent']);
            if(!empty($user['s_phone'])){
                $sms = new sms();
                $sms->username = se('sms_username');
                $sms->password = se('sms_password');
                $sms->from = se('sms_form');
                $sms->massage = $parent['tk_code']." - به تیکت شما پاسخ داده شد ";
                $sms->to = $user['s_phone'];
                $sms->sms_send();
            }

            $mails = new SendMail();
            $mails->to = $user['s_email'];
            $mails->type = se('mail_stamp');
            $mails->title = 'پاسخ داده شد -'.$tiket['tk_title'];
            $mails->SubjectMail = 'پاسخ داده شد - '.se('site_title')."- Pasokh Dade Shod";
            $mails->body = 'Response_Tiket';
            $mails->data = array('Msg'=>$tiket['tk_massage'],'tiket_code'=>$parent['tk_code'],'tiket_title'=>$parent['tk_title'],'date_create'=>substr($parent['tk_date_in'],0,10),'state_tiket'=>state_tiket($parent['tk_state']));
            $mails->Mail_to($id);
        }

    }
    function GetUser_Information($id){
        return $this->db->row("SELECT * FROM  td_user WHERE id_user = :id and s_state = 1 ",array('id'=>$id));
    }
    function GetTiketInformation($for,$id){
        return $this->db->row("SELECT * FROM  td_tiket WHERE tk_user_id = :id and id_tiket = :id_tiket ",array('id'=>$for,'id_tiket'=>$id));
    }
    function GetTiketParentInformation($id,$code){
        return $this->db->row("SELECT * FROM  td_tiket WHERE tk_user_id = :id and tk_code = :code and tk_parent = 0 ",array('id'=>$id,'code'=>$code));
    }
}
if(isAdmin() == 1){
    class se_save {
        var $db;
        function create_key($id,$group){
            $insert = $this->db->query("INSERT INTO td_setting(se_Key,se_group) VALUES (:se_Key,:se_group)",array("se_Key"=>$id,"se_group"=>$group));
            if($insert > 0){
                return 1;
            }else{
                return 0;
            }
        }
        function check_id($id,$group){
            $check = $this->db->row("SELECT se_Key FROM td_setting WHERE se_Key = :id and se_group = :group ",array('id'=>$id,'group'=>$group));
            if(empty($check['se_Key'])){
                $checks =  $this->create_key($id,$group);
                return $checks;
            }else{
                return 1;
            }
        }
        function save_se($id,$data,$group){
            $id = $this->filter($id);
            $data = $this->filter($data);
            $group = $this->filter($group);
            $check = $this->check_id($id,$group);
            if($check > 0){
                $this->db->query("UPDATE td_setting SET se_value = :se_value WHERE se_Key = :se_Key and se_group = :se_group ",array('se_Key'=>$id,'se_group'=>$group,'se_value'=>$data));
            }
        }
        function filter($data){
            $export = htmlentities(strip_tags(Trim($data)));
            return $export;
        }
    }
}
function pathUrl($dir = __DIR__){

    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));

    //HTTPS or HTTP
    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

    //HOST
    $root .= '://' . $_SERVER['HTTP_HOST'];

    //ALIAS
    if(!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER[ 'CONTEXT_DOCUMENT_ROOT' ]));
    } else {
        $root .= substr($dir, strlen($_SERVER[ 'DOCUMENT_ROOT' ]));
    }

    $root .= '/';

    return $root;
}

function update_last_log(){
    $db = new Db();
    $db->query("UPDATE  td_asmin SET am_lastlogin = :s_lastlog_time  WHERE id_am = :id",array('s_lastlog_time'=>time(),'id'=>$_SESSION['user_id']));
}

function view($file){
    $db = new Db();
    $tmp =new SmartyBC();
    $tmp->setTemplateDir('./Connect/theme/'.se('website_template'))
        ->setCompileDir('./Connect/theme_c')
        ->setCacheDir('./cache');

    $tmp->debugging = false;
    $tmp->caching = true;
    $tmp->cache_lifetime = 120;
    require ClASS_DIR.'template.php';
    $setting = new setting();
    $setting->db = new Db();
    return $tmp->display($file.".tpl");
}
function MonixUser_Menu(){
    global $hooks;
    $hooks->do_action('User_Menu');
}

function isAdmin(){
    if(isset($_SESSION['admin_id'])){
        return 1;
    }else{
        return 0;
    }
}
function asset($file){
    echo pathUrl('../').'Connect/asset/'.$file;
}
function AdminTarget(){
    return se('admin_file_name');
}
function Mo_url($ur){
    return pathUrl('../').$ur;
}
function TotalOpenTiket(){
    if(isAdmin() == 1){
        global $db;
        global $where_opera;
        $total_open_tiket =  $db->query("SELECT tk_title FROM td_tiket  WHERE tk_parent = '0'  and tk_state < 4 {$where_opera} ");
        $total_open_tiket = count($total_open_tiket);
    }
}
function Monix_url_slug($str, $options = array()) {
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false,
    );

    // Merge options
    $options = array_merge($defaults, $options);

    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );

    // Make custom replacements
    $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }

    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

    // Remove duplicate delimiters
    $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

    // Truncate slug to max. characters
    $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}
function user_login(){
    if(isset($_SESSION['user_id'])){
        return 1;
    }else{
        return 0;
    }
}
function get_header( $pHeaderKey )
{
    // Expaget_filended for clarity.
    $headerKey = str_replace('-', '_', $pHeaderKey);
    $headerKey = strtoupper($headerKey);
    $headerValue = NULL;
    // Uncomment the if when you do not want to throw an undefined index error.
    // I leave it out because I like my app to tell me when it can't find something I expect.
    //if ( array_key_exists($headerKey, $_SERVER) ) {
    $headerValue = $_SERVER[ $headerKey ];
    //}
    return $headerValue;
}
function MonixUserMenu(){
    global $hooks;
    $hooks = new Hooks();
    $hooks->do_action('User_Menu');
}