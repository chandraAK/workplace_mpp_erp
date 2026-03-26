<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$username = $_SESSION['username'];
if($username == ""){
    $url = base_url()."index.php/logout";
    redirect($url);
}

$sql_user_det = "select * from login where username = '".$username."'";
$qry_user_det = $this->db->query($sql_user_det)->row();
$email = $qry_user_det->email;
$name = $qry_user_det->name;
$emp_id1 = $qry_user_det->emp_id;
$role = $qry_user_det->role;
?>

<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    $status = $_REQUEST['status'];
    $comp = $_REQUEST['comp'];

    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $where_str = "";
    if($status == 'All'){
        $where_str .= "";
    } else {
        $where_str .= " and leave_status = '".$status."'";
    }

    if($role == 'Admin'){
        $where_str .= "";
    } else {
        $where_str .= " and reports_to = '".$emp_id1."'";
    }

    if($comp == 'All'){
        $where_str .= "";
    } else {
        $where_str .= " and leave_emp_id in(select distinct emp_id from emp_rep_to_mst where branch = '".$comp."')";
    }
?>

<?php if($status == "Pending For HOD Approval"){ ?>
    <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_app_hod">
<?php }
    else if($status == "Pending For HR Approval"){ ?>
    <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_app_hr">
<?php } elseif($status == "Pending For Management Approval"){ ?>
    <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_app_mng">
<?php }  else if($status == "Approved"){ ?>
    <!--Do Nothing-->
    <form class="form-horizontal" id="myForm" method="post" action="">
<?php } else { ?>
    <form class="form-horizontal" id="myForm" method="post" action="">
<?php } ?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Select</b> <input type="checkbox" id="all_checkbox" name="all_checkbox" onchange="checkAll(this)"></th>
                    <th><b>Leave ID</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Department</b></th>
                    <th><b>Reports To</b></th>
                    <th><b>Leave Type</b></th>
                    <th><b>Leave From Date</b></th>
                    <th><b>Leave To Date</b></th>
                    <th><b>Leave Days</b></th>
                    <th><b>Half Day</b></th>
                    <th><b>Leave Status</b></th>
                    <th><b>Remarks</b></th>
                    <th><b>Created Date</b></th>
                    <th><b>Mgmt. Approved By</b></th>
                    <th><b>Mgmt. Approved Date</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_emp = "select * from leave_mst 
                    where date(created_date) between '".$start_dt."' and '".$end_dt."' $where_str";

                    $qry_emp = $this->db->query($sql_emp);

                    $sno = 0;
                    foreach($qry_emp->result() as $row){
                        $sno++;
                        $leave_id = $row->leave_id;
                        $leave_emp_id = $row->leave_emp_id;
                        // $sys_cal_advamt = $row->sys_cal_advamt;
                        // $sal_adv_req = $row->sal_adv_req;
                        $leave_from_date = $row->leave_from_date;
                        $leave_to_date = $row->leave_to_date;
                        $leave_days = $row->leave_days;
                        $half_day_type = $row->half_day_type;
                        $leave_type = $row->leave_type;

                        $status = $row->leave_status;
                        $leave_remarks = $row->leave_remarks;


                        $created_date = $row->created_date;
                        $mgmt_app_by = $row->mgmt_app_by;
                        $mgmt_app_date = $row->mgmt_app_date;

                        $sql_emp_det = "select * from `tabEmployee` where name = '".$leave_emp_id."'";
                        $qry_emp_det = $db2->query($sql_emp_det)->row();
                        $employee_name = $qry_emp_det->employee_name;
                        $department = $qry_emp_det->department;
                        $reports_to = $qry_emp_det->reports_to;
                        $salary_mode = $qry_emp_det->salary_mode;
                        $employee_type = $qry_emp_det->custom_employee_type;
                        $bank_ac_no = $qry_emp_det->bank_ac_no;
                        $ifsc_code = $qry_emp_det->ifsc_code;
                        $bank_name = $qry_emp_det->bank_name;
                        $is_labour = $qry_emp_det->custom__type_2;
                ?>

                <tr>
                    <td><?php if($status != "Approved"){?><input type="checkbox" id="leave_id" name="leave_id[]" value="<?=$leave_id;?>"><?php } ?></td>
                    <td><a href="<?php echo base_url();?>index.php/hrmsc/leave_add?id=<?=$leave_id;?>"><?=$leave_id;?></a></td>
                    <td><?=$leave_emp_id;?></td>
                    <td><?=$employee_name;?></td>
                    <td><?=$department;?></td>
                    <td><?=$reports_to;?></td>
                    <td><?=$leave_type;?></td>
                    <td><?=$leave_from_date;?></td>
                    <td><?=$leave_to_date;?></td>
                    <td><?=$leave_days;?></td>
                    <td><?=$half_day_type;?></td>
                    <td><?=$status;?></td>
                    <td><?=$leave_remarks;?></td>
                    <td><?=$created_date;?></td>
                    <td><?=$mgmt_app_by;?></td>
                    <td><?=$mgmt_app_date;?></td>
                </tr>

                <?php
                        // $sal_adv_req_Tot = $sal_adv_req_Tot+$sal_adv_req;
                    }
                ?>
            </tbody>
        </table>
    </div>
</div><br><br>

<?php
    if($status != "Paid"){
?>
    <div class="row">
        <div class="col-lg-2"><b>Approval Status</b></div>
        <div class="col-lg-2">
            <select id="app_status" name="app_status" class="form-control">
                <?php
                    if($status == "Pending For HOD Approval" || $status == "Pending For HR Approval" || $status == "Pending For Management Approval"){
                ?>
                    <option value="Approve">Approve</option>
                    <option value="Reject">Reject</option>
                <?php
                    }
                ?>
            </select>
        </div>

        <div class="col-lg-2">
            <?php                        
                if($status == "Pending For HOD Approval" && ($reports_to == $emp_id1 || $role == 'Admin')){
                    echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                }  else if($status == "Pending For HR Approval" && $role == 'Admin'){
                    echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                }  else if($status == "Pending For Management Approval" && $role == 'Admin'){
                        echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                }  else if($status == "Pending For Payment" && $role == 'Admin'){
                        echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                }  else if($status == "Approved"){
                    //Do Nothing
                } else if($status == "") {
                    echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                }
            ?>
        </div>
    </div>

<?php
    }
?>
</form>