<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    $custom_card_no = $_REQUEST['custom_card_no'];
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $end_dt1 = strtotime($end_dt);
    $start_dt1 = strtotime($start_dt);

    $datediff = $end_dt1 - $start_dt1;
    $datediff1 = round($datediff / (60 * 60 * 24));
    $month_days = $datediff1+1;
?>

<?php
    $sql_emp = "select * from `tabEmployee` where custom_card_no = '".$custom_card_no."'";
    $qry_emp = $db2->query($sql_emp)->row();
    $custom__type_2 = $qry_emp->custom__type_2;
    $name = $qry_emp->name;
    $employee_name = $qry_emp->employee_name;
    $department = $qry_emp->department;
    $esi_no = $qry_emp->esi_no; 
    $bank_name = $qry_emp->bank_name;
    $bank_ac_no = $qry_emp->bank_ac_no;
    $designation = $qry_emp->designation;
    $uan_no = $qry_emp->uan_no;

    if($custom__type_2 == 0){
        $tbl_name = "payroll_mst_type1";
    } else {
        $tbl_name = "payroll_mst_type2";
    }

    $sql_sal = "select * from $tbl_name 
    where month_start_date = '".$start_dt."' 
    and month_end_date = '".$end_dt."' 
    and EmpId = '".$name."' limit 1";

    $qry_sal = $this->db->query($sql_sal)->row();

    //$month_days = $qry_sal->month_days;
    //$earned_sal = $qry_sal->earned_sal;

    if($custom__type_2 == 0){
        $PaidDay = $qry_sal->PaidDay;

        $earned_sal = $qry_sal->earned_sal;
        $NetSalary = $qry_sal->NetSalary; //Earning
    } else {
        $Tot_Hrs = $qry_sal->Tot_Hrs;
        $duty_hours = $qry_sal->duty_hours;
        $PaidDay = $Tot_Hrs/$duty_hours;
        $wages = $qry_sal->wages;

        $earned_sal = $wages*$month_days;
        $NetSalary = $qry_sal->EmpTotSal; //Earning
    }
    $PaidDay = number_format($PaidDay,2,".","");

    $HRA = ($NetSalary*16)/100; //Earning
    $BasicSalary = $qry_sal->BasicSal; //Earning
    $welfare = $qry_sal->welfare; //Earning
    $arrear = $qry_sal->arrear; //Earning
    $spcl_allowance = ($NetSalary+$welfare)-($BasicSalary+$HRA);
    $Tot_Earning = $BasicSalary+$HRA+$spcl_allowance+$arrear;

    $PF_Amt = $qry_sal->PF_Amt; //Deduction
    $esi_amt = $qry_sal->esi_amt; //Deduction
    $tot_advance_amount = $qry_sal->tot_advance_amount; //Deduction
    $tot_spcl_advance_amount = $qry_sal->tot_spcl_advance_amount; //Deduction
    $tot_adv = $tot_advance_amount+$tot_spcl_advance_amount; //Deduction
    $prev_ded = $qry_sal->prev_ded; //Deduction
    $deduction = $qry_sal->deduction; //Deduction
    $tot_loan_amount = $qry_sal->tot_loan_amount; //Deduction
    $oth_ded = $prev_ded+$deduction; //Deduction

    $Tot_Ded = $PF_Amt+$esi_amt+$tot_advance_amount+$tot_spcl_advance_amount+$tot_loan_amount+$prev_ded+$deduction;

    $net_paybl_sal = $qry_sal->net_paybl_sal;


?>

<div class="row" style="text-align:center">
    <div class="col-lg-12">
        <h3>Salary Slip - <?php echo month_disp($att_month)." ".$att_year;?> </h3>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1">
            <tr style="background-color:#CCCCCC">
                <td colspan="4" style="font-weight:bold">Name Of Employee: <?=$employee_name;?></td>
            </tr>
            <tr style="background-color:#CCCCCC">
                <td colspan="2" style="font-weight:bold">Employee Details</td>
                <td colspan="2" style="font-weight:bold">Payment & Leave Details</td>
            </tr>
            <tr>
                <td style="font-weight:bold">Emp. Code.</td>
                <td><?=$name;?></td>
                <td style="font-weight:bold">Bank Name</td>
                <td><?=$bank_name;?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Designation</td>
                <td><?=$designation;?></td>
                <td style="font-weight:bold">Acc. No.</td>
                <td><?=$bank_ac_no;?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Department</td>
                <td><?=$department;?></td>
                <td style="font-weight:bold">Place of Working</td>
                <td>AJMER</td>
            </tr>
            <tr>
                <td style="font-weight:bold">ESIC No</td>
                <td><?=$esi_no;?></td>
                <td style="font-weight:bold">Total Month Days</td>
                <td><?=number_format($month_days,2,".","");?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">UAN Number</td>
                <td><?=$uan_no;?></td>
                <td style="font-weight:bold">Total Working Days</td>
                <td><?=$PaidDay;?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Actual Gross CTC:</td>
                <td style="font-weight:bold"><?=number_format($earned_sal,2,".","");?></td>
                <td style="font-weight:bold">LOP Days</td>
                <td><?php $lop=$month_days-$PaidDay; echo number_format($lop,2,".","")?></td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr style="background-color:#CCCCCC">
                <td style="font-weight:bold">Earnings</td>
                <td style="font-weight:bold">Amount</td>
                <td style="font-weight:bold">Deductions</td>
                <td style="font-weight:bold">Amount</td>
            </tr>
            <tr>
                <td style="font-weight:bold">Basic Salary</td>
                <td><?=number_format(round($BasicSalary),2,".","");?></td>
                <td style="font-weight:bold">Provident Fund</td>
                <td><?=number_format(round($PF_Amt),2,".","");;?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">HRA</td>
                <td><?=number_format(round($HRA),2,".","");?></td>
                <td style="font-weight:bold">ESIC</td>
                <td><?=number_format(round($esi_amt),2,".","");?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Medical Allowance</td>
                <td>0.00</td>
                <td style="font-weight:bold">TDS</td>
                <td>0.00</td>
            </tr>
            <tr>
                <td style="font-weight:bold">Conveyance</td>
                <td>0.00</td>
                <td style="font-weight:bold">Other Deductions</td>
                <td><?=number_format(round($oth_ded),2,".","");?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Other / Special Allowances</td>
                <td><?=number_format(round($spcl_allowance),2,".","");?></td>
                <td style="font-weight:bold">Advance Salary</td>
                <td><?=number_format(round($tot_adv),2,".","");?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Arrear</td>
                <td><?=number_format(round($arrear),2,".","");?></td>
                <td style="font-weight:bold">Loan</td>
                <td><?=number_format(round($tot_loan_amount),2,".","");?></td>
            </tr>
            <tr>
                <td style="font-weight:bold">Total Earnings</td>
                <td style="font-weight:bold"><?=number_format(round($Tot_Earning),2,".","");?></td>
                <td style="font-weight:bold">Total Deductions</td>
                <td style="font-weight:bold"><?=number_format(round($Tot_Ded),2,".","");?></td>
            </tr>
            <tr style="background-color:#CCCCCC">
                <td style="font-weight:bold">Net Pay</td>
                <td style="font-weight:bold"><?=number_format(round($net_paybl_sal),2,".","");?></td>
                <td style="font-weight:bold"></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>