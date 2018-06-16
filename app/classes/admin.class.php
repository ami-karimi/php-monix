<?php

class admin {
    var $lastRes;
    var $db;

    function __construct() {
        global $db;
        $this->db = $db;
    }
    public function ResAdmin(){
       $data =  $this->db->query("SELECT state_admin,admin_lastRes,id_am FROM  td_asmin WHERE admin_lastRes >= now() - 300 ");
       if(count($data) > 0){
           foreach($data as $row) {
               $this->db->query("UPDATE  td_asmin SET state_admin = '0' WHERE id_am = :id",
                   array(
                       "id" => $row['id_am']
                   )
               );
           }
       }
    }
    public  function ChangeAdminState(){
        $this->db->query("UPDATE  td_asmin SET admin_lastRes = :time , state_admin = '1' WHERE id_am = :id",
            array(
                "id"=> $_SESSION['admin_id'],
                "time" => time()
            )
        );
    }
}