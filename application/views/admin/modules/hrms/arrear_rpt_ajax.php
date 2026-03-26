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
        $where_str .= " and status = '".$status."'";
    }

    if($role == 'Admin'){
        $where_str .= "";
    } else {
        $where_str .= " and reports_to = '".$emp_id1."'";
    }

    if($comp == 'All'){
        $where_str .= "";
    } else {
        $where_str .= " and emp_id in(select distinct emp_id from emp_rep_to_mst where branch = '".$comp."')";
    }
?>

<?php if($status == "Pending For Management Approval"){ ?>
    <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/arrear_app_mng">
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
                    <th><b>Arrear ID</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Department</b></th>
                    <th><b>Reports To</b></th>
                    <th><b>Employee Type</b></th>
                    <th><b>Salary Mode</b></th>
                    <th><b>Is Labour</b></th>
                    <th><b>Arrear Amount</b></th>
                    <th><b>Status</b></th>
                    <th><b>Remarks</b></th>
                    <th><b>Created Date</b></th>
                    <th><b>Mgmt. Approved By</b></th>
                    <th><b>Mgmt. Approved Date</b></th>
                    <th><b>Bank Account No</b></th>
                    <th><b>Bank IFSC</b></th>
                    <th><b>Bank Name</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_emp = "select * from arrear 
                    where date(created_date) between '".$start_dt."' and '".$end_dt."' $where_str";

                    $qry_emp = $this->db->query($sql_emp);

                    $sno = 0;
                    $arrear_Tot = 0;
                    foreach($qry_emp->result() as $row){
                        $sno++;
                        $arrear_id = $row->arrear_id;
                        $emp_id = $row->emp_id;
                        $arrear_amt = $row->arrear_amt;
                        $status = $row->status;
                        $arrear_rmks = $row->arrear_rmks;
                        $created_date = $row->created_date;
                        $mgmt_app_by = $row->mgmt_app_by;
                        $mgmt_app_date = $row->mgmt_app_date;

                        $sql_emp_det = "select * from `tabEmployee` where name = '".$emp_id."'";
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
                    <td><?php if($status != "Approved"){?><input type="checkbox" id="arrear_id" name="arrear_id[]" value="<?=$arrear_id;?>"><?php } ?></td>
                    <td><?=$arrear_id;?></td>
                    <td><?=$emp_id;?></td>
                    <td><?=$employee_name;?></td>
                    <td><?=$department;?></td>
                    <td><?=$reports_to;?></td>
                    <td><?=$employee_type;?></td>
                    <td><?=$salary_mode;?></td>
                    <td><?=$is_labour;?></td>
                    <td><?=number_format($arrear_amt,2,".","");?></td>
                    <td><?=$status;?></td>
                    <td><?=$arrear_rmks;?></td>
                    <td><?=$created_date;?></td>
                    <td><?=$mgmt_app_by;?></td>
                    <td><?=$mgmt_app_date;?></td>
                    <td><?=$bank_ac_no; ?></td>
                    <td><?=$ifsc_code; ?></td>
                    <td><?=$bank_name; ?></td>
                </tr>

                <?php
                        $arrear_Tot = $arrear_Tot+$arrear_amt;
                    }
                ?>
                <tr style="font-weight:bold">
                    <td>Totals</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?=number_format($arrear_Tot,2,".","");?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><br><br>

<?php
    if($status != "Approved"){
?>
    <div class="row">
        <div class="col-lg-2"><b>Approval Status</b></div>
        <div class="col-lg-2">
            <select id="app_status" name="app_status" class="form-control">
                <?php
                    if($status == "Pending For Management Approval"){
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
                if($status == "Pending For Management Approval" && $role == 'Admin'){
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