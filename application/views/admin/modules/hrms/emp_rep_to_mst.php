<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php

//$this->db->query("truncate table emp_rep_to_mst");
$sql_sel = "select name, custom_card_no, employee_name, reports_to, status, branch from `tabEmployee` 
where (reports_to is not null OR reports_to != '') 
and custom_card_no != 0";

$qry_sel = $db2->query($sql_sel);

foreach($qry_sel->result() as $row){
    $emp_id = $row->name;
    $emp_card_no = $row->custom_card_no;
    $emp_name = $row->employee_name;
    $emp_reportsto_id = $row->reports_to;
    $status = $row->status;
    $branch = $row->branch;

    //Getting HOD Card No
    $sql_hod_cardNo = "select custom_card_no from `tabEmployee` where name = '".$emp_reportsto_id."'";
    $qry_hod_cardNo = $db2->query($sql_hod_cardNo)->row();
    $emp_reportsto_cardno = $qry_hod_cardNo->custom_card_no;

    $sql_cnt = "select count(*) as cnt from emp_rep_to_mst where emp_card_no = '".$emp_card_no."'";
    $qry_cnt = $this->db->query($sql_cnt)->row();
    $cnt = $qry_cnt->cnt;

    if($cnt > 0){

        $this->db->query("update emp_rep_to_mst set 
        emp_id = '".$emp_id."', emp_name = '".$emp_name."', 
        emp_reportsto_id = '".$emp_reportsto_id."', emp_reportsto_cardno = '".$emp_reportsto_cardno."', 
        status  = '".$status."', branch = '".$branch."' 
        where emp_card_no = '".$emp_card_no."'");

    } else {

        $this->db->query("insert into emp_rep_to_mst(emp_id, emp_card_no, emp_name, 
        emp_reportsto_id, emp_reportsto_cardno, status, branch)
        values('".$emp_id."', '".$emp_card_no."', '".$emp_name."', 
        '".$emp_reportsto_id."', '".$emp_reportsto_cardno."', '".$status."', '".$branch."')");

    }
}

//Contract Labour/ Employee type / Salary Mode
$sql = "select distinct EmpId from tran_attendence";
$qry = $this->db->query($sql);

foreach($qry->result() as $row){
    $EmpId = $row->EmpId;

    $sql_is_con = "select custom__is_on_contract, custom_date_of_contract_joining, salary_mode, custom_employee_type from `tabEmployee`
    where name = '".$EmpId."'";
    $qry_is_con = $db2->query($sql_is_con)->row();
    $is_on_contract = $qry_is_con->custom__is_on_contract;
    $date_of_contract_joining = $qry_is_con->custom_date_of_contract_joining;
    $salary_mode = $qry_is_con->salary_mode;
    $employee_type = $qry_is_con->custom_employee_type;

    $this->db->query("update tran_attendence 
    set is_on_contract = '".$is_on_contract."', 
    date_of_contract_joining = '".$date_of_contract_joining."',
    salary_mode = '".$salary_mode."',
    employee_type = '".$employee_type."'
    where EmpId = '".$EmpId."'");
}

//Shift Type Updation
$sql = "SELECT distinct ShiftOnAttDate FROM `tran_attendence` where ShiftOnAttDate is not NULL and ShiftOnAttDate != ''";
$qry = $this->db->query($sql);

foreach($qry->result() as $row){
    $ShiftOnAttDate = $row->ShiftOnAttDate;

    $sql_is_con = "select custom_shift_type from `tabShift Type` where name = '".$ShiftOnAttDate."'";
    $qry_is_con = $db2->query($sql_is_con)->row();
    $shift_type = $qry_is_con->custom_shift_type;

    $this->db->query("update tran_attendence 
    set ShiftOnAttDateType  = '".$shift_type."'
    where ShiftOnAttDate = '".$ShiftOnAttDate."' 
    and ShiftOnAttDateType = ''");
}

$this->db->query("update tran_attendence set is_on_contract = 0 
where CalDate < date_of_contract_joining
and YEAR(date_of_contract_joining) != 0
and date_of_contract_joining is not null");

//Branch Updation Query
$this->db->query("update `tran_attendence` set branch = 'PNI' where EmpId like 'EMP-PNI%' and branch = '' ");
$this->db->query("update `tran_attendence` set branch = 'MDPL' where EmpId like 'EMP-MDP%' and branch = '' ");
$this->db->query("update `tran_attendence` set branch = 'MPP' where EmpId like 'EMP-MPP%' and branch = '' ");

echo "Employee Reports to Master Updated Successfully";

?>