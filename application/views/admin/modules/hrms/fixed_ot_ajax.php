<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$att_month = $_REQUEST['att_month'];
$att_year = $_REQUEST['att_year'];
$status = $_REQUEST['status'];
$emp_type = $_REQUEST['emp_type'];
$sal_type = $_REQUEST['sal_type'];

//Month Start Date
$start_dt = $att_year."-".$att_month."-01";

//End Date
$sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
$qry_end_dt = $this->db->query($sql_end_dt)->row();
$end_dt = $qry_end_dt->end_dt;

$payroll_id = "PNI-SAL-".$att_year."-".$att_month;
$created_by = $_SESSION['username'];

//Month Days
$end_dt1 = strtotime($end_dt);
$start_dt1 = strtotime($start_dt);

$datediff = $end_dt1 - $start_dt1;
$datediff1 = round($datediff / (60 * 60 * 24));
$datediff1 = $datediff1+1;

$where_str = "";

if($emp_type == "All"){
    $where_str .= "";
} else {
    $where_str .= " and employee_type = '".$emp_type."'";
}

if($sal_type == "All"){
    $where_str .= "";
} else {
    $where_str .= " and salary_mode = '".$sal_type."'";
}

if($status == "All"){
    $where_str .= "";
} else {
    $where_str .= " and status = '".$status."'";
}
?>

<!--- Type 1 Employees ---->
<?php
    $sql_att = "SELECT distinct CardNo, EmpId, EmpName, department, reports_to,
    is_on_contract, is_employee, is_overtime_calculate
    FROM `tran_attendence` 
    WHERE CalDate between '".$start_dt."' AND '".$end_dt."' 
    AND is_on_contract = 0
    AND is_employee = 1
    AND is_overtime_calculate = 1";

    $qry_att = $this->db->query($sql_att);
    $sno = 0;
    foreach($qry_att->result() as $row){
        $sno++;
        $CardNo = $row->CardNo;
        $EmpId = $row->EmpId;
        $EmpName = $row->EmpName;
        $is_overtime_calculate = $row->is_overtime_calculate;

        //Check Labour
        $sql_lab = "select custom__type_2, custom_duty_hours, department, salary_mode, 
        custom__is_on_contract, custom_reporte_name, custom_uan_no, custom_esi_no, custom_employee_type,
        bank_ac_no, ifsc_code, bank_name 
        from `tabEmployee` where name = '".$EmpId."'";
        $qry_lab = $db2->query($sql_lab)->row();
        $is_labour = $qry_lab->custom__type_2;
        $duty_hours = $qry_lab->custom_duty_hours;
        $department = $qry_lab->department;
        $salary_mode = $qry_lab->salary_mode;
        $is_on_contract = $qry_lab->custom__is_on_contract;
        $reporte_name = $qry_lab->custom_reporte_name;
        $uan_no = $qry_lab->custom_uan_no;
        $esi_no = $qry_lab->custom_esi_no;
        $employee_type = $qry_lab->custom_employee_type;
        $bank_ac_no = $qry_lab->bank_ac_no;
        $ifsc_code = $qry_lab->ifsc_code;
        $bank_name = $qry_lab->bank_name;

        if($is_employee > 0){
            $emp_type = "TYPE-1";
        } else {
            $emp_type = "TYPE-2";
        }

        if($is_overtime_calculate > 0){
            $ot_cal = "Yes";
        } else {
            $ot_cal = "No";
        }

        $sql_ot_hrs = "select custom_overtime_ as ot_hrs, custom_max_overtime, custom_duty_hours, custom_employee_type, salary_mode from `tabEmployee` 
        where name = '".$EmpId."' 
        and is_overtime_calculate = 1 
        and is_employee = 1";

        $qry_ot_hrs = $db2->query($sql_ot_hrs)->row();
        $ot_hrs = $qry_ot_hrs->ot_hrs;
        $duty_hour = $qry_ot_hrs->custom_duty_hours;
        $employee_type = $qry_ot_hrs->custom_employee_type;
        $salary_mode = $qry_ot_hrs->salary_mode;
        $max_overtime = $qry_ot_hrs->custom_max_overtime;
        $OT_Tot = 0;
        $OT_Tot1 = 0;
        $Tot_OT = 0;
        $gross_sal = 0;
        $PerDaySal = 0;
        $PerHrSal = 0;
        $OTAmt_Tot = 0;

        //Overtime Hours Calculation
        $sql_ot = "select OverTime, PreOverTime FROM `tran_attendence` 
        WHERE CalDate between '".$start_dt."' AND '".$end_dt."'
        AND EmpId = '".$EmpId."' 
        AND is_on_contract = 0
        AND is_employee = 1
        AND is_overtime_calculate = 1";

        $qry_ot = $this->db->query($sql_ot);

        foreach($qry_ot->result() as $row){
            $OverTime = $row->OverTime;
            $PreOverTime = $row->PreOverTime;

            //Post OT
            if($OverTime >=  $ot_hrs && $OverTime < $max_overtime){
                $OT_Tot = $OT_Tot+$ot_hrs;
            } else if($OverTime >= $max_overtime) {
                $OT_Tot = $OT_Tot+$max_overtime;
            } else if($OverTime >=  $ot_hrs){
                $OT_Tot = $OT_Tot+$ot_hrs;
            }

            //Pre OT
            if($PreOverTime >=  $ot_hrs && $PreOverTime < $max_overtime){
                $OT_Tot1 = $OT_Tot1+$ot_hrs;
            } else if($PreOverTime >= $max_overtime) {
                $OT_Tot1 = $OT_Tot1+$max_overtime;
            } else if($PreOverTime >=  $ot_hrs){
                $OT_Tot1 = $OT_Tot1+$ot_hrs;
            }
            

            //Total OT
            $Tot_OT = $OT_Tot+$OT_Tot1;
            
        }

        //Getting Monthly Salary
        $sql_emp_sal = "select base from `tabSalary Structure Assignment` 
        where workflow_state = 'Approved' 
        and from_date = (select max(from_date) from `tabSalary Structure Assignment` 
        where workflow_state = 'Approved' and employee = '".$EmpId."')
        and employee = '".$EmpId."'";

        $qry_emp_sal = $db2->query($sql_emp_sal)->row();
        $gross_sal = $qry_emp_sal->base;
        $PerDaySal = $gross_sal/$datediff1;

        //Per Hour Salary
        $PerHrSal = $PerDaySal/$duty_hour;

        //OT Amount Calculation
        $OTAmt_Tot = $PerHrSal*$Tot_OT;

        //Data Insertion
        $sql_check = "select count(*) as cnt from fixed_overtime where EmpId = '".$EmpId."' 
        and payroll_id = '".$payroll_id."'";

        $qry_check = $this->db->query($sql_check)->row();

        $cnt = $qry_check->cnt;

        if($cnt > 0){
            //Updating Records
            $this->db->query("update fixed_overtime set
            payroll_id = '".$payroll_id."', month_start_date = '".$start_dt."', 
            month_end_date = '".$end_dt."', CardNo = '".$CardNo."',
            EmpId = '".$EmpId."', EmpName = '".$EmpName."', 
            department = '".$department."', reporte_name = '".$reporte_name."', 
            is_labour = '".$is_labour."', duty_hours = '".$duty_hour."', 
            employee_type = '".$employee_type."', salary_mode = '".$salary_mode."', 
            ot_cal = '".$ot_cal."', mdt_ot_hrs = '".$ot_hrs."', 
            gross_sal = '".$gross_sal."', OT_Tot = '".$Tot_OT."', 
            PerHrSal = '".$PerHrSal."', OTAmt_Tot = '".$OTAmt_Tot."', 
            month_days = '".$datediff1."', modified_by = '".$created_by."'
            where EmpId = '".$EmpId."' 
            and payroll_id = '".$payroll_id."'
            and status = 'Pending For Management Approval'");

        } else {

            //Inserting Records
            $this->db->query("insert into fixed_overtime
            (payroll_id, month_start_date, month_end_date, CardNo,
            EmpId, EmpName, department, reporte_name, is_labour, 
            duty_hours, employee_type, salary_mode, month_days,
            ot_cal, mdt_ot_hrs, gross_sal, OT_Tot, PerHrSal, OTAmt_Tot, 
            status, created_by, modified_by)
            values('".$payroll_id."', '".$start_dt."', '".$end_dt."', '".$CardNo."',
            '".$EmpId."', '".$EmpName."', '".$department."', '".$reporte_name."', '".$is_labour."',
            '".$duty_hour."', '".$employee_type."', '".$salary_mode."', '".$datediff1."', 
            '".$ot_cal."', '".$ot_hrs."', '".$gross_sal."', '".$Tot_OT."', '".$PerHrSal."', '".$OTAmt_Tot."', 
            'Pending For Management Approval','".$created_by."','".$created_by."')");
        
        }
    }
?>
<!--- Type 2 Employees ---->
<?php
    $sql_att = "SELECT distinct CardNo, EmpId, EmpName, department, reports_to,
    is_on_contract, is_employee, is_overtime_calculate
    FROM `tran_attendence` 
    WHERE CalDate between '".$start_dt."' AND '".$end_dt."' 
    AND is_on_contract = 0
    AND is_employee = 0
    AND is_overtime_calculate = 1";

    $qry_att = $this->db->query($sql_att);
    $sno = 0;
    foreach($qry_att->result() as $row){
        $sno++;
        $CardNo = $row->CardNo;
        $EmpId = $row->EmpId;
        $EmpName = $row->EmpName;
        $is_overtime_calculate = $row->is_overtime_calculate;

        //Check Labour
        $sql_lab = "select custom__type_2, custom_duty_hours, department, salary_mode, 
        custom__is_on_contract, custom_reporte_name, custom_uan_no, custom_esi_no, custom_employee_type,
        bank_ac_no, ifsc_code, bank_name 
        from `tabEmployee` where name = '".$EmpId."'";
        $qry_lab = $db2->query($sql_lab)->row();
        $is_labour = $qry_lab->custom__type_2;
        $duty_hours = $qry_lab->custom_duty_hours;
        $department = $qry_lab->department;
        $salary_mode = $qry_lab->salary_mode;
        $max_overtime = $qry_ot_hrs->custom_max_overtime;
        $is_on_contract = $qry_lab->custom__is_on_contract;
        $reporte_name = $qry_lab->custom_reporte_name;
        $uan_no = $qry_lab->custom_uan_no;
        $esi_no = $qry_lab->custom_esi_no;
        $employee_type = $qry_lab->custom_employee_type;
        $bank_ac_no = $qry_lab->bank_ac_no;
        $ifsc_code = $qry_lab->ifsc_code;
        $bank_name = $qry_lab->bank_name;

        if($is_employee > 0){
            $emp_type = "TYPE-1";
        } else {
            $emp_type = "TYPE-2";
        }

        if($is_overtime_calculate > 0){
            $ot_cal = "Yes";
        } else {
            $ot_cal = "No";
        }

        $sql_ot_hrs = "select custom_overtime_ as ot_hrs, custom_max_overtime from `tabEmployee` 
        where name = '".$EmpId."' 
        and is_overtime_calculate = 1 
        and is_employee = 0";

        $qry_ot_hrs = $db2->query($sql_ot_hrs)->row();
        $ot_hrs = $qry_ot_hrs->ot_hrs;
        $max_overtime = $qry_ot_hrs->custom_max_overtime;
        $OT_Tot = 0;
        $OT_Tot1 = 0;
        $Tot_OT = 0;
        $gross_sal = 0;
        $PerDaySal = 0;
        $PerHrSal = 0;
        $OTAmt_Tot = 0;

        //Overtime Hours Calculation
        $sql_ot = "select OverTime, PreOverTime FROM `tran_attendence` 
        WHERE CalDate between '".$start_dt."' AND '".$end_dt."'
        AND EmpId = '".$EmpId."' 
        AND is_on_contract = 0
        AND is_employee = 0
        AND is_overtime_calculate = 1";

        $qry_ot = $this->db->query($sql_ot);

        foreach($qry_ot->result() as $row){
            $OverTime = $row->OverTime;
            $PreOverTime = $row->PreOverTime;

            //Post OT
            if($OverTime >=  $ot_hrs && $OverTime < $max_overtime){
                $OT_Tot = $OT_Tot+$ot_hrs;
            } else if($OverTime >= $max_overtime) {
                $OT_Tot = $OT_Tot+$max_overtime;
            } else if($OverTime >=  $ot_hrs){
                $OT_Tot = $OT_Tot+$ot_hrs;
            }

            //Pre OT
            if($PreOverTime >=  $ot_hrs && $PreOverTime < $max_overtime){
                $OT_Tot1 = $OT_Tot1+$ot_hrs;
            } else if($PreOverTime >= $max_overtime) {
                $OT_Tot1 = $OT_Tot1+$max_overtime;
            } else if($PreOverTime >=  $ot_hrs){
                $OT_Tot1 = $OT_Tot1+$ot_hrs;
            }
            

            //Total OT
            $Tot_OT = $OT_Tot+$OT_Tot1;
            
        }

        $sql_emp_dh = "select custom_wages from `tabSalary Structure Assignment`
        where workflow_state = 'Approved' 
        and from_date = (select max(from_date) from `tabSalary Structure Assignment` 
        where workflow_state = 'Approved' and employee = '".$EmpId."')
        and `tabSalary Structure Assignment`.employee = '".$EmpId."'";

        $qry_emp_dh = $db2->query($sql_emp_dh)->row();
        $wages = $qry_emp_dh->custom_wages;

        //Per Hour Salary
        $PerHrSal = $wages/$duty_hours;

        //OT Amount Calculation
        $OTAmt_Tot = $PerHrSal*$Tot_OT;

        //Data Insertion
        $sql_check = "select count(*) as cnt from fixed_overtime where EmpId = '".$EmpId."' 
        and payroll_id = '".$payroll_id."'";

        $qry_check = $this->db->query($sql_check)->row();

        $cnt = $qry_check->cnt;

        if($cnt > 0){
            //Updating Records
            $this->db->query("update fixed_overtime set
            payroll_id = '".$payroll_id."', month_start_date = '".$start_dt."', 
            month_end_date = '".$end_dt."', CardNo = '".$CardNo."',
            EmpId = '".$EmpId."', EmpName = '".$EmpName."', 
            department = '".$department."', reporte_name = '".$reporte_name."', 
            is_labour = '".$is_labour."', duty_hours = '".$duty_hours."', 
            employee_type = '".$employee_type."', salary_mode = '".$salary_mode."', 
            ot_cal = '".$ot_cal."', mdt_ot_hrs = '".$ot_hrs."', 
            gross_sal = '".$gross_sal."', OT_Tot = '".$Tot_OT."', 
            PerHrSal = '".$PerHrSal."', OTAmt_Tot = '".$OTAmt_Tot."', 
            month_days = '".$datediff1."', modified_by = '".$created_by."'
            where EmpId = '".$EmpId."' 
            and payroll_id = '".$payroll_id."'
            and status = 'Pending For Management Approval'");

        } else {

            //Inserting Records
            $this->db->query("insert into fixed_overtime
            (payroll_id, month_start_date, month_end_date, CardNo,
            EmpId, EmpName, department, reporte_name, is_labour, 
            duty_hours, employee_type, salary_mode, month_days,
            ot_cal, mdt_ot_hrs, gross_sal, OT_Tot, PerHrSal, OTAmt_Tot, 
            status, created_by, modified_by)
            values('".$payroll_id."', '".$start_dt."', '".$end_dt."', '".$CardNo."',
            '".$EmpId."', '".$EmpName."', '".$department."', '".$reporte_name."', '".$is_labour."',
            '".$duty_hours."', '".$employee_type."', '".$salary_mode."', '".$datediff1."', 
            '".$ot_cal."', '".$ot_hrs."', '".$gross_sal."', '".$Tot_OT."', '".$PerHrSal."', '".$OTAmt_Tot."', 
            'Pending For Management Approval','".$created_by."','".$created_by."')");
        
        }
    }
?>

<?php
if($status == "Pending For Management Approval"){
?>
    <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/hrmsc/ot_app_mgmt" id="myForm" method="post">
<?php
}
?>

<input type="hidden" id="payroll_id" name="payroll_id" value="<?=$payroll_id;?>">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php //echo fixed_ot_tot($start_dt, $end_dt, $datediff1);?>

        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Select</b> <input type="checkbox" id="all_checkbox" name="all_checkbox" onchange="checkAll(this)"></th>
                    <th>Card No</th>
                    <th>Employee</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Reports To</th>
                    <th>Employee Type</th>
                    <th>Salary Mode</th>
                    <th>OT Calculate</th>
                    <th>Mandatory OT Hours</th>
                    <th>Duty Hours</th>
                    <th>Monthly Salary</th>
                    <th>Total OT Hours</th>
                    <th>Per Hour Salary</th>
                    <th>Total OT Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql_gsdata = "select * from fixed_overtime where payroll_id = '".$payroll_id."' $where_str ";
            $qry_gsdata = $this->db->query($sql_gsdata);
            $OTAmt_Tot_GT = 0;
            foreach($qry_gsdata->result() as $row){
                $CardNo=$row->CardNo;
                $EmpId=$row->EmpId;
                $EmpName=$row->EmpName;
                $department=$row->department;
                $reporte_name=$row->reporte_name;
                $employee_type=$row->employee_type;
                $salary_mode=$row->salary_mode;
                $ot_cal=$row->ot_cal;
                $mdt_ot_hrs=$row->mdt_ot_hrs;
                $duty_hours=$row->duty_hours;
                $gross_sal=$row->gross_sal;
                $OT_Tot=$row->OT_Tot;
                $PerHrSal=$row->PerHrSal;
                $OTAmt_Tot=$row->OTAmt_Tot;
                $status=$row->status;
            ?>
                <tr>
                    <td><?php if($status != "Approved"){?><input type="checkbox" id="sal_app_emp" name="sal_app_emp[]" value="<?=$EmpId;?>"><?php } ?></td>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$department;?></td>
                    <td><?=$reporte_name;?></td>
                    <td><?=$employee_type;?></td>
                    <td><?=$salary_mode;?></td>
                    <td><?=$ot_cal;?></td>
                    <td><?=$mdt_ot_hrs;?></td>
                    <td><?=number_format($duty_hours,2,".","");?></td>
                    <td><?=number_format($gross_sal,2,".","");?></td>
                    <td><?=number_format($OT_Tot,2,".","");?></td>
                    <td><?=number_format($PerHrSal,2,".","");?></td>
                    <td><?=number_format(round($OTAmt_Tot),2,".","");?></td>
                    <td><?=$status;?></td>
                </tr>
            <?php
                //Totals
                $OTAmt_Tot_GT = $OTAmt_Tot_GT+$OTAmt_Tot;
            }
            ?>

                <tr style="font-weight:bold">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?=number_format(round($OTAmt_Tot_GT),2,".","");?></td>
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
                    <option value="Approved">Approved</option>
                    <option value="Hold">Hold</option>
                <?php
                    }
                ?>
                <option value="Hold">Hold</option>
            </select>
        </div>

        <div class="col-lg-4">
            <?php if($status == "Pending For Management Approval"){ ?>
                <input type="submit" id="submit1" name="submit" value="Submit" class="form-control">
            <?php } ?>
        </div>
    </div>

<?php
    }
?>
</form>