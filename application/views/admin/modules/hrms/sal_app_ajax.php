<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    $type = $_REQUEST['type'];
    $status = $_REQUEST['status'];

    $emp_type = $_REQUEST['emp_type'];
    $sal_type = $_REQUEST['sal_type'];
    $department = $_REQUEST['department'];
    $reporte_name = $_REQUEST['reporte_name'];
    $card_no = $_REQUEST['card_no'];
    $comp = $_REQUEST['comp'];
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $payroll_id = "PNI-SAL-".$att_year."-".$att_month;
    $created_by = $_SESSION['username'];

    if($type == '0'){
        $tbl_name = 'payroll_mst_type1';
    } else if($type == '1') {
        $tbl_name = 'payroll_mst_type2';
    } else if($type == 'pc') {
        $tbl_name = 'payroll_mst_pc';
    } else if($type == 'pb') {
        $tbl_name = 'payroll_mst_pb';
    } else if($type == 'mpppro') {
        $tbl_name = 'payroll_mst_mpppro';
    }

    $where_str = "";

    if($status == "All"){
        $where_str .= "";
    } else {
        $where_str .= " and status = '".$status."'";
    }

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

    if($department == "All"){
        $where_str .= "";
    } else {
        $where_str .= " and department = '".$department."'";
    }

    if($reporte_name == "All"){
        $where_str .= "";
    } else {
        $where_str .= " and reporte_name = '".$reporte_name."'";
    }

    if($card_no == 'ALL'){
        //Do Nothing
    } else {
        $where_str .=" and CardNo ='".$card_no."'";
    }

    if($comp == 'All'){
        $where_str .= "";
    } else {
        if($type == 'pb'){
            $where_str .= "";
        } else {
            $where_str .= " and EmpId in(select distinct emp_id from emp_rep_to_mst where branch = '".$comp."')";
        }
    }
?>

<?php
if($status == "Pending For Management Approval"){
?>
    <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/hrmsc/sal_app_mgmt" id="myForm" method="post">
<?php
} else if($status != "Pending For Management Approval"){
?>
    <form class="form-horizontal" action="<?php echo base_url(); ?>index.php/hrmsc/sal_app_pay" id="myForm" method="post">
<?php
}
?>

<input type="hidden" id="payroll_id" name="payroll_id" value="<?=$payroll_id;?>">
<input type="hidden" id="emp_type" name="emp_type" value="<?=$emp_type;?>">
<input type="hidden" id="type" name="type" value="<?=$type;?>">

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Select</b> <input type="checkbox" id="all_checkbox" name="all_checkbox" onchange="checkAll(this)"></th>
                    <th><b>Branch</b></th>
                    <th><b>Contractor Name</b></th>
                    <th><b>Card No</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Department</b></th>
                    <th><b>Reports To</b></th>
                    <th><b>Duty Hours</b></th>
                    <th><b>Total Duty Hours</b></th>
                    <th><b>Total Paid Days</b></th>
                    <th><b>Emp Type</b></th>
                    <th><b>Salary Mode</b></th>
                    <th><b>Earned Salary</b></th>
                    <th><b>Gross Salary</b></th>
                    <th><b>Basic Salary</b></th>
                    <th><b>PF No.</b></th>
                    <th><b>PF Amount</b></th>
                    <th><b>ESIC No.</b></th>
                    <th><b>ESIC Amount</b></th>
                    <th><b>Salary Advance</b></th>
                    <th><b>Spcl Salary Advance</b></th>
                    <th><b>Loan</b></th>
                    <th><b>Prev. Deduction</b></th>
                    <th><b>Welfare</b></th>
                    <th><b>Arrear</b></th>
                    <th><b>Deduction</b></th>
                    <th><b>Payable Salary</b></th>
                    <th><b>Bank Account No</b></th>
                    <th><b>Bank IFSC</b></th>
                    <th><b>Bank Name</b></th>
                    <th><b>Status</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_pr_data = "select * from $tbl_name 
                    where payroll_id = '".$payroll_id."'
                    $where_str
                    and net_paybl_sal != 0";
                    $qry_pr_data = $this->db->query($sql_pr_data);

                    //Totals
                    $NetSalary_Tot = 0;
                    $GrossSal_Tot = 0;
                    $BasicSal_Tot = 0;
                    $PF_Amt_Tot = 0;
                    $esi_amt_Tot = 0;
                    $tot_advance_amount_Tot = 0;
                    $tot_spcl_advance_amount_Tot = 0;
                    $tot_loan_amount_Tot = 0;
                    $prev_ded_Tot = 0;
                    $welfare_Tot = 0;
                    $arrear_Tot = 0;
                    $deduction_Tot = 0;
                    $net_paybl_sal_Tot = 0;

                    foreach($qry_pr_data->result() as $row){
                        $payroll_id = $row->payroll_id;
                        $CardNo = $row->CardNo;
                        $EmpId = $row->EmpId;
                        $EmpName = $row->EmpName;
                        $department = $row->department;
                        $reporte_name = $row->reporte_name;
                        $is_labour = $row->is_labour;
                        $duty_hours = $row->duty_hours;
                        $employee_type = $row->employee_type;
                        $salary_mode = $row->salary_mode;

                        if($is_labour == 1){
                            $NetSalary = $row->EmpTotSal;
                        } else {
                            $NetSalary = $row->NetSalary;
                        }

                        if($type == '0'){
                            $NetSalary = $row->NetSalary;
                        } else if($type == '1') {
                            $NetSalary = $row->EmpTotSal;
                        } else if($type == 'pc') {
                            $NetSalary = $row->NetSalary;
                        } else if($type == 'pb') {
                            $NetSalary = $row->NetSalary;
                        } else if($type == 'mpppro') {
                            $NetSalary = $row->NetSalary;
                        }

                        $GrossSal = $row->GrossSal;
                        $BasicSal = $row->BasicSal;
                        $uan_no = $row->uan_no;
                        $PF_Amt = $row->PF_Amt;
                        $esi_no = $row->esi_no;
                        $esi_amt = $row->esi_amt;
                        $tot_advance_amount = $row->tot_advance_amount;
                        $tot_spcl_advance_amount = $row->tot_spcl_advance_amount;
                        $tot_loan_amount = $row->tot_loan_amount;
                        $prev_ded = $row->prev_ded;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $welfare = $row->welfare;
                        $arrear = $row->arrear;
                        $deduction = $row->deduction;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $bank_ac_no = $row->bank_ac_no;
                        $ifsc_code = $row->ifsc_code;
                        $bank_name = $row->bank_name;
                        $status = $row->status;
                        
                        $Tot_Hrs = $row->Tot_Hrs;
                        $PaidDay = $row->PaidDay;
                        
                        //Check Labour
                        $sql_lab = "select * 
                        from `tabEmployee` where name = '".$EmpId."'";
                        $qry_lab = $db2->query($sql_lab)->row();
                        $branch = $qry_lab->branch;
                        $custom_contractor_name = $qry_lab->custom_contractor_name;
                        
                ?>
                <tr>
                    <td><?php if($status != "Paid"){?><input type="checkbox" id="sal_app_emp" name="sal_app_emp[]" value="<?=$EmpId;?>"><?php } ?></td>
                    <td><?=$branch;?></td>
                    <td><?=$custom_contractor_name;?></td>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$department;?></td>
                    <td><?=$reporte_name;?></td>
                    <td><?=$duty_hours;?></td>
                    <td><?=$Tot_Hrs;?></td>
                    <td><?=$PaidDay;?></td>
                    <td><?=$employee_type;?></td>
                    <td><?=$salary_mode;?></td>
                    <td><?=$NetSalary;?></td>
                    <td><?=$GrossSal;?></td>
                    <td><?=$BasicSal;?></td>
                    <td><?=$uan_no;?></td>
                    <td><?=$PF_Amt;?></td>
                    <td><?=$esi_no;?></td>
                    <td><?=$esi_amt;?></td>
                    <td><?=$tot_advance_amount;?></td>
                    <td><?=$tot_spcl_advance_amount;?></td>
                    <td><?=$tot_loan_amount;?></td>
                    <td><?=$prev_ded;?></td>
                    <td><?=$welfare;?></td>
                    <td><?=$arrear;?></td>
                    <td><?=$deduction;?></td>
                    <td><?=$net_paybl_sal;?></td>
                    <td><?=$bank_ac_no;?></td>
                    <td><?=$ifsc_code;?></td>
                    <td><?=$bank_name;?></td>
                    <td><?=$status;?></td>
                </tr>
            <?php
            //Totals
            $NetSalary_Tot = $NetSalary_Tot+$NetSalary;
            $GrossSal_Tot = $GrossSal_Tot+$GrossSal;
            $BasicSal_Tot = $BasicSal_Tot+$BasicSal;
            $PF_Amt_Tot = $PF_Amt_Tot+$PF_Amt;
            $esi_amt_Tot = $esi_amt_Tot+$esi_amt;
            $tot_advance_amount_Tot = $tot_advance_amount_Tot+$tot_advance_amount;
            $tot_spcl_advance_amount_Tot = $tot_spcl_advance_amount_Tot+$tot_spcl_advance_amount;
            $tot_loan_amount_Tot = $tot_loan_amount_Tot+$tot_loan_amount;
            $prev_ded_Tot = $prev_ded_Tot+$prev_ded;
            $welfare_Tot = $welfare_Tot+$welfare;
            $arrear_Tot = $arrear_Tot+$arrear;
            $deduction_Tot = $deduction_Tot+$deduction;
            $net_paybl_sal_Tot = $net_paybl_sal_Tot+$net_paybl_sal;
            } 
            ?> 

            <!--- Totals ---->
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
                <td></td>
                <td></td>
                <td></td>
                <td><?=number_format(round($NetSalary_Tot),2,".","");?></td>
                <td><?=number_format(round($GrossSal_Tot),2,".","");?></td>
                <td><?=number_format(round($BasicSal_Tot),2,".","");?></td>
                <td></td>
                <td><?=number_format(round($PF_Amt_Tot),2,".","");?></td>
                <td></td>
                <td><?=number_format(round($esi_amt_Tot),2,".","");?></td>
                <td><?=number_format(round($tot_advance_amount_Tot),2,".","");?></td>
                <td><?=number_format(round($tot_spcl_advance_amount_Tot),2,".","");?></td>
                <td><?=number_format(round($tot_loan_amount_Tot),2,".","");?></td>
                <td><?=number_format(round($prev_ded_Tot),2,".","");?></td>
                <td><?=number_format(round($welfare_Tot),2,".",""); ?></td>
                <td><?=number_format(round($arrear_Tot),2,".",""); ?></td>
                <td><?=number_format(round($deduction_Tot),2,".",""); ?></td>
                <td><?=number_format(round($net_paybl_sal_Tot),2,".",""); ?></td>
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
    if($status != "Paid"){
?>
    <div class="row">
        <div class="col-lg-2"><b>Approval Status</b></div>
        <div class="col-lg-2">
            <select id="app_status" name="app_status" class="form-control">
                <?php
                    if($status == "Pending For Management Approval"){
                ?>
                    <option value="Approved">Approved</option>
                <?php
                    }
                ?>
                <option value="Hold">Hold</option>
                <?php
                    if($status != "Pending For Management Approval"){
                ?>
                    <option value="Paid">Paid</option>
                <?php
                    }
                ?>
            </select>
        </div>

        <?php if($status != "Pending For Management Approval"){ ?>
            <div class="col-lg-2"><b>Payment Mode</b></div>
            <div class="col-lg-2">
                <select id="PaidMode" name="PaidMode" class="form-control">
                    <option value="Cash">Cash</option>
                    <option value="Bank">Bank</option>
                </select>
            </div>
        <?php } ?>

        <div class="col-lg-4"><input type="submit" id="submit1" name="submit" value="Submit" class="form-control"></div>
    </div>

<?php
    }
?>
</form>