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
    
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $payroll_id = "PNI-SAL-".$att_year."-".$att_month;
?>


<form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/mpp_prod_sal_entry">

<input type="hidden" id="payroll_id" name="payroll_id" value="<?=$payroll_id;?>">
<input type="hidden" id="month_start_date" name="month_start_date" value="<?=$start_dt;?>">
<input type="hidden" id="month_end_date" name="month_end_date" value="<?=$end_dt;?>">

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Employee Type</b></th>
                    <th><b>Total Salary</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_emp_name = "select * from mpp_prod_oth_emp_mst";

                    $qry_emp_name = $this->db->query($sql_emp_name);

                    foreach($qry_emp_name->result() as $row){
                        $emp_id = $row->emp_id;
                        $employee_name = $row->emp_name;
                        $type = $row->type;

                        $sql_chk = "select tot_sal from mpp_prod_sal where payroll_id = '".$payroll_id."' and emp_id = '".$emp_id."'";
                        $qry_chk = $this->db->query($sql_chk)->row();

                        $tot_sal = $qry_chk->tot_sal;
                ?>

                <tr>
                    <td><?=$emp_id;?><input type="hidden" id="emp_id" name="emp_id[]" value="<?=$emp_id;?>"></td>
                    <td><?=$employee_name;?><input type="hidden" id="employee_name" name="employee_name[]"  value="<?=$employee_name;?>"></td>
                    <td><?=$type;?><input type="hidden" id="employee_type" name="employee_type[]"  value="<?=$type;?>"></td>
                    <td><input class="form-control" type="text" id="tot_sal" name="tot_sal[]" value="<?=$tot_sal;?>" required onkeypress="return isNumberKey(event);"></td>
                </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div><br><br>

<div class="row">
    <div class="col-lg-2">
        <input type="submit" id="submit1" name="submit" value="Submit" class="form-control">
    </div>
</div>
</form>