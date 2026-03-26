<?php

$sql_sel = "select * from login where id > 103";
$qry_sel = $this->db->query($sql_sel);

foreach($qry_sel->result() as $row){
    $password = $row->password;
    $password = MD5($password);
    $id = $row->id;

    $this->db->query("update login set password = '".$password."' where id = '".$id."'");
}

?>