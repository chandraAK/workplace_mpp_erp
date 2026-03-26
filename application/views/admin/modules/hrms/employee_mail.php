<?php

$sql_sel = "select * from employee_mail where id is not null";
$qry_sel = $this->db->query($sql_sel);

foreach($qry_sel->result() as $row){
    $emp_id = $row->emp_id;
    $email = $row->email;
    $password = $rowpassword;
    $id = $row->id;
}
    
?>