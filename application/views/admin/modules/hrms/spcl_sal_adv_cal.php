<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php 
    $username = $_SESSION['username'];
    $sql_user_det = "select role from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $role = $qry_user_det->role;
?>

<?php
    $emp_id = $_REQUEST['emp_id'];
    $from_dt = date("Y-m")."-01";
    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$from_dt."') as to_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $to_dt = $qry_end_dt->to_dt;
    
    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$from_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $end_dt1 = strtotime($end_dt);
    $start_dt1 = strtotime($from_dt);

    $datediff = $end_dt1 - $start_dt1;
    $datediff1 = round($datediff / (60 * 60 * 24));
    $datediff1 = $datediff1+1;

    $sql_emp_det = "select custom_card_no, custom__type_2 from `tabEmployee` where name = '".$emp_id."'  and status = 'Active'";
    $qry_emp_det = $db2->query($sql_emp_det)->row();
    $CardNo = $qry_emp_det->custom_card_no;
    $is_labour = $qry_emp_det->custom__type_2;
?>

<table class="table table-bordered" width="100%">
    <thead>
        <tr style="font-weight:bold">
            <td>Attendance(Days)-Type1</td>
            <td>Attendance(Hours)-Type2</td>
            <td>Monthly Salary-Type1</td>
            <td>Perday Salary(Monthly)-Type1</td>
            <td>Perday Salary(Daily)-Type2</td>
            <td>Per Hour Salary(Daily)-Type2</td>
            <td>Total Salary Till Date</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
            <?php 
                $tot_paid_days = tot_paid_days($from_dt, $to_dt, $CardNo);
                if($is_labour == 0){
                    echo $tot_paid_days;
                }
            ?>
            </td>
            <td>
            <?php 
                $tot_hrs_cal_dw = tot_hrs_cal_dw($from_dt, $to_dt, $CardNo);
                if($is_labour != 0){
                    echo $tot_hrs_cal_dw;
                }
            ?>
            </td>
            <td>
            <?php
                if($is_labour == 0){
                    //Getting Monthly Salary
                    $sql_emp_sal = "select base from `tabSalary Structure Assignment` 
                    where workflow_state = 'Approved' 
                    and from_date = (select max(from_date) from `tabSalary Structure Assignment` 
                    where workflow_state = 'Approved' and employee = '".$emp_id."')
                    and employee = '".$emp_id."'";

                    $qry_emp_sal = $db2->query($sql_emp_sal)->row();
                    $gross_sal = $qry_emp_sal->base;

                    $gross_sal = number_format($gross_sal,2,".","");

                    if($role == "Admin"){
                        echo $gross_sal; 
                    }
                }
            ?>
            </td>
            <td>
            <?php
                if($is_labour == 0){
                    $PerDaySal = $gross_sal / $datediff1;
                    $PerDaySal = number_format($PerDaySal,2,".","");

                    if($role == "Admin"){
                        echo $PerDaySal; 
                    }
                }
            ?>
            </td>
            <td>
            <?php
                if($is_labour != 0){
                    //Getting Duty Hours & Wages Employee
                    $sql_emp_dh = "select `tabSalary Structure Assignment`.custom_wages, `tabEmployee`.custom_duty_hours 
                    from `tabSalary Structure Assignment`
                    inner join `tabEmployee` on `tabEmployee`.name = `tabSalary Structure Assignment`.employee
                    where `tabSalary Structure Assignment`.workflow_state = 'Approved' 
                    and `tabSalary Structure Assignment`.from_date = (select max(from_date) from `tabSalary Structure Assignment` 
                    where workflow_state = 'Approved' and employee = '".$emp_id."')
                    and `tabSalary Structure Assignment`.employee = '".$emp_id."'";

                    $qry_emp_dh = $db2->query($sql_emp_dh)->row();
                    $duty_hours = $qry_emp_dh->custom_duty_hours;
                    $wages = $qry_emp_dh->custom_wages;

                    if($role == "Admin"){
                        echo $wages; 
                    }
                }
            ?>
            </td>
            <td>
            <?php
                if($is_labour != 0){
                    if($wages == NULL || $wages == ""){
                        $per_hr_sal = 0;

                        if($role == "Admin"){
                            echo $per_hr_sal; 
                        }
                    } else {
                        $per_hr_sal = number_format($wages / $duty_hours,2,".","");

                        if($role == "Admin"){
                            echo $per_hr_sal; 
                        }
                    }
                }
            ?> 
            </td>
            <td>
            <?php
            //Advance Amount Calculate
            if($is_labour != 0){
                $tot_adv_amt = ($per_hr_sal * $tot_hrs_cal_dw);
                echo $tot_adv_amt = number_format($tot_adv_amt,2,".",""); 
            } else {
                $tot_adv_amt = ($PerDaySal * $tot_paid_days);
                echo $tot_adv_amt = number_format($tot_adv_amt,2,".","");
            }

            ?>
            <input type="hidden" id="sys_cal_advamt" name="sys_cal_advamt" value="<?=$tot_adv_amt;?>" readonly>
            </td>
        </tr>
    </tbody>
</table>