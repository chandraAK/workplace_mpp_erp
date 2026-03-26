<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    $emp_type = $_REQUEST['emp_type'];
    $sal_type = $_REQUEST['sal_type'];
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    //Next Month Dates
    $sql_nmd = "SELECT DATE_FORMAT(DATE_ADD('".$start_dt."', INTERVAL 1 MONTH), '%Y-%m-01') AS FirstDayOfNextMonth, 
    LAST_DAY(DATE_ADD('".$start_dt."', INTERVAL 1 MONTH)) AS LastDayOfNextMonth";

    $qry_nmd = $this->db->query($sql_nmd)->row();
    $FirstDayOfNextMonth = $qry_nmd->FirstDayOfNextMonth;
    $LastDayOfNextMonth = $qry_nmd->LastDayOfNextMonth;

    //Where Str
    $where_str = "";
    if($emp_type == 'ALL'){
        //Do Nothing
    } else {
        $where_str .=" and `tabEmployee`.employee_type ='".$emp_type."'";
    }

    if($sal_type == 'ALL'){
        //Do Nothing
    } else {
        $where_str .=" and `tabEmployee`.salary_mode ='".$sal_type."'";
    }

    $payroll_id = "PNI-SAL-".$att_year."-".$att_month;
    $created_by = $_SESSION['username'];
?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Card No</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Department</b></th>
                    <th><b>Reports To</b></th>
                    <th><b>Duty Hours</b></th>
                    <th><b>Emp Type</b></th>
                    <th><b>Salary Mode</b></th>
                    <th><b>Month Days</b></th>
                    <th><b>Gross Monthly Salary</b></th>
                    <th><b>Per Day Salary</b></th>
                    <th><b>Paid Days</b></th>
                    <th><b>Penalties</b></th>
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
                    <th><b>Net Pay</b></th>
                    <th><b>Payable Salary</b></th>
                    <th><b>Bank Account No</b></th>
                    <th><b>Bank IFSC</b></th>
                    <th><b>Bank Name</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $end_dt1 = strtotime($end_dt);
                    $start_dt1 = strtotime($start_dt);

                    $datediff = $end_dt1 - $start_dt1;
                    $datediff1 = round($datediff / (60 * 60 * 24));
                    $datediff1 = $datediff1+1;

                    $sql_emp = "select distinct `tabEmployee`.card_no, `tabEmployee`.name, `tabEmployee`.employee_name from `tabEmployee`
                    inner join `tabPC Wages` on `tabPC Wages`.employee  = `tabEmployee`.name
                    inner join `tabPC Extra Contract Payment` on `tabPC Wages`.parent = `tabPC Extra Contract Payment`.name
                    where `tabPC Extra Contract Payment`.effective_date between '".$start_dt."' and '".$end_dt."'   
                    and `tabEmployee`.is_on_contract = 1
                    and `tabPC Extra Contract Payment`.workflow_state = 'Approved'
                    and `tabPC Wages`.docstatus = 1 
                    $where_str 
                    order by `tabPC Wages`.employee
                    ";

                    //echo $sql_emp; die;

                    $qry_emp = $db2->query($sql_emp);

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
                    $net_paybl_sal_Tot = 0;
                    $emp_welfare_Tot = 0;
                    $NetPay_Tot = 0;

                    foreach($qry_emp->result() as $row){
                        $CardNo = $row->card_no;
                        $EmpId = $row->name;
                        $EmpName = $row->employee_name;

                        //Check Labour
                        $sql_lab = "select is_labour, duty_hour, department, salary_mode, 
                        is_on_contract, reporte_name, uan_no, esi_no, employee_type,
                        bank_ac_no, ifsc_code, bank_name 
                        from `tabEmployee` where name = '".$EmpId."'";
                        $qry_lab = $db2->query($sql_lab)->row();
                        $is_labour = $qry_lab->is_labour;
                        $duty_hours = $qry_lab->duty_hour;
                        $department = $qry_lab->department;
                        $salary_mode = $qry_lab->salary_mode;
                        $is_on_contract = $qry_lab->is_on_contract;
                        $reporte_name = $qry_lab->reporte_name;
                        $uan_no = $qry_lab->uan_no;
                        $esi_no = $qry_lab->esi_no;
                        $employee_type = $qry_lab->employee_type;
                        $bank_ac_no = $qry_lab->bank_ac_no;
                        $ifsc_code = $qry_lab->ifsc_code;
                        $bank_name = $qry_lab->bank_name;

                        if($is_on_contract == 1){
                            //Getting Monthly Salary
                            $sql_emp_sal = "select wages from `tabSalary Structure Assignment` 
                            where workflow_state = 'Approved' 
                            and from_date = (select max(from_date) from `tabSalary Structure Assignment` 
                            where workflow_state = 'Approved' and employee = '".$EmpId."')
                            and employee = '".$EmpId."'";

                            $qry_emp_sal = $db2->query($sql_emp_sal)->row();
                            $wages = $qry_emp_sal->wages;
                            $gross_sal = $wages * $datediff1;

                            $PerDaySal = $gross_sal / $datediff1;

                            //Getting Employee Paid Days
                            $sql_emp_pd = "select count(distinct `tabPC Extra Contract Payment`.effective_date) as PaidDay 
                            from `tabPC Extra Contract Payment`
                            inner join `tabPC Wages` on `tabPC Wages`.parent = `tabPC Extra Contract Payment`.name
                            where `tabPC Extra Contract Payment`.effective_date between '".$start_dt."' and '".$end_dt."'
                            and `tabPC Wages`.employee = '".$EmpId."'
                            and `tabPC Extra Contract Payment`.workflow_state = 'Approved'
                            and `tabPC Wages`.docstatus = 1
                            ";

                            $qry_emp_pd = $db2->query($sql_emp_pd)->row();

                            $PaidDay = $qry_emp_pd->PaidDay;

                            if($EmpId == "EMP-PNI-00940"){
                                $PaidDay = "0.5"; 
                            }

                            //Penalties
                            $Penalty_Sum = 0;

                            if($Penalty_Sum > 0){
                                $PaidDay = $PaidDay - $Penalty_Sum;
                            }

                            //Production Salary
                            $sql_prod_sal = "select sum(total_shift_stock * rate) as prod_sal from `tabPNI Packing` 
                            where `tabPNI Packing`.date between '".$start_dt."' and '".$end_dt."'
                            and `tabPNI Packing`.machine_helper_id = '".$EmpId."'
                            and `tabPNI Packing`.docstatus = 1";

                            $qry_prod_sal = $db2->query($sql_prod_sal)->row();

                            $prod_sal = $qry_prod_sal->prod_sal;

                            //Extra Payment
                            $sql_extra_pay = "select sum(payment) as extra_pay from `tabPC Extra Contract Payment` 
                            inner join `tabPC Wages` on `tabPC Wages`.parent = `tabPC Extra Contract Payment`.name
                            where `tabPC Extra Contract Payment`.effective_date between '".$start_dt."' and '".$end_dt."'
                            and `tabPC Wages`.employee = '".$EmpId."'
                            and `tabPC Extra Contract Payment`.workflow_state = 'Approved'
                            and `tabPC Wages`.docstatus = 1";

                            $qry_extra_pay = $db2->query($sql_extra_pay)->row();

                            $extra_pay = $qry_extra_pay->extra_pay;

                            $NetSalary = $prod_sal+$extra_pay;

                            $NetSalary1 = $PaidDay * 252;

                            $GrossSal = $NetSalary1;
                            $BasicSal = $GrossSal*0.40;
                            //PF Calculation
                            if($uan_no != ""){
                                $PF_Amt = $BasicSal*0.12;
                            } else {
                                $PF_Amt = 0;
                            }

                            //ESI Calculation
                            if($esi_no != ""){
                                $esi_amt = $GrossSal*0.75/100;
                            } else {
                                $esi_amt = 0;
                            }

                            //Advance Salary
                            $sql_adv_sal = "select sum(sal_adv_req) as tot_advance_amount from `salary_adv_pcpb` 
                            where emp_id = '".$EmpId."' and date(created_date) between '".$start_dt."' and '".$end_dt."' and status = 'Paid'";

                            $qry_adv_sal = $this->db->query($sql_adv_sal)->row();

                            $tot_advance_amount = $qry_adv_sal->tot_advance_amount;


                            //Salary Advance ERP
                            /*
                            $sql_adv_erp = "select sum(paid_amount) as tot_advance_amount from `tabContract Payment` where 
                            payment_required_by between '".$start_dt."' and '".$end_dt."'
                            and person_name = '".$EmpId."'
                            and is_advance_payment = 1";

                            $qry_adv_erp = $db2->query($sql_adv_erp)->row();

                            $tot_advance_amount = $qry_adv_erp->tot_advance_amount;
                            */

                            //Special Salary Advance 
                            $sql_spcl_adv_sal = "select sum(sal_adv_req) as tot_spcl_advance_amount from `spcl_salary_adv` 
                            where emp_id = '".$EmpId."' and date(created_date) between '".$start_dt."' and '".$end_dt."' and status = 'Paid'";

                            $qry_spcl_adv_sal = $this->db->query($sql_spcl_adv_sal)->row();

                            $tot_spcl_advance_amount = $qry_spcl_adv_sal->tot_spcl_advance_amount;

                            //Loan EMI
                            $sql_loan = "select sum(`tabRepayment Schedule`.total_payment) as total_payment from `tabLoan` 
                            inner join `tabRepayment Schedule` on `tabRepayment Schedule`.parent = `tabLoan`.name
                            where `tabLoan`.applicant = '".$EmpId."'
                            and `tabLoan`.docstatus = 1
                            and `tabLoan`.status = 'Sanctioned'
                            and `tabRepayment Schedule`.payment_date between '".$FirstDayOfNextMonth."' and '".$LastDayOfNextMonth."'";

                            $qry_loan = $db2->query($sql_loan)->row();

                            $tot_loan_amount = $qry_loan->total_payment;

                            //Previous Deduction
                            $sql_prev_ded = "select sum(net_paybl_sal) as prev_ded from neg_sal_emp 
                            where EmpId = '".$EmpId."' and deducted = 0 
                            and month_start_date < '".$start_dt."' 
                            and month_end_date < '".$end_dt."'";
                            $qry_prev_ded = $this->db->query($sql_prev_ded)->row();
                            $prev_ded = abs($qry_prev_ded->prev_ded);

                            if($prev_ded == ""){
                                $prev_ded = 0;
                            }

                            //Net Salary
                            $net_paybl_sal = 0;
                            $net_paybl_sal = $NetSalary;

                            //Welfare Calculation
                            $net_paybl_sal1 = $NetSalary1 - ($tot_advance_amount+$tot_spcl_advance_amount+$tot_loan_amount+$PF_Amt+$esi_amt+$prev_ded);

                            //Welfare Amount 
                            if($employee_type == "On Roll"){
                                $welfare = $NetSalary-$NetSalary1;
                            } else {
                                $welfare = $NetSalary-$NetSalary1;
                            }

                            $net_paybl_sal = $net_paybl_sal1+$welfare;

                            $NetPay = $net_paybl_sal-$welfare;
                ?>

                <tr>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$department;?></td>
                    <td><?=$reporte_name;?></td>
                    <td><?=$duty_hours;?></td>
                    <td><?=$employee_type;?></td>
                    <td><?=$salary_mode;?></td>
                    <td><?=$datediff1;?></td>
                    <td><?=$gross_sal = number_format($gross_sal,2,".","");?></td>
                    <td><?=$PerDaySal = number_format($PerDaySal,2,".","");?></td>
                    <td><?=$PaidDay = number_format($PaidDay,2,".","");?></td>
                    <td><?=$Penalty_Sum = number_format($Penalty_Sum,2,".","");?></td>
                    <td><?=$NetSalary = number_format(round($NetSalary),2,".","");?></td>
                    <td><?=$GrossSal = number_format(round($GrossSal),2,".","");?></td>
                    <td><?=$BasicSal = number_format(round($BasicSal),2,".","");?></td>
                    <td><?=$uan_no;?></td>
                    <td><?=$PF_Amt = number_format(round($PF_Amt),2,".","");?></td>
                    <td><?=$esi_no;?></td>
                    <td><?=$esi_amt = number_format(round($esi_amt),2,".","");?></td>
                    <td><?=$tot_advance_amount = number_format(round($tot_advance_amount),2,".","");?></td>
                    <td><?=$tot_spcl_advance_amount = number_format(round($tot_spcl_advance_amount),2,".","");?></td>
                    <td><?=$tot_loan_amount = number_format(round($tot_loan_amount),2,".","");?></td>
                    <td><?=$prev_ded = number_format(round($prev_ded),2,".","");?></td>
                    <td><?=$welfare = number_format(round($welfare),2,".",""); ?></td>
                    <td><?=$NetPay = number_format(round($NetPay),2,".",""); ?></td>
                    <td><?=$net_paybl_sal = number_format(round($net_paybl_sal),2,".",""); ?></td>
                    <td><?=$bank_ac_no; ?></td>
                    <td><?=$ifsc_code; ?></td>
                    <td><?=$bank_name; ?></td>
                </tr>

                <?php
                            $sql_check = "select count(*) as cnt from payroll_mst_pc where EmpId = '".$EmpId."' 
                            and payroll_id = '".$payroll_id."'";

                            $qry_check = $this->db->query($sql_check)->row();

                            $cnt = $qry_check->cnt;

                            if($cnt > 0){
                                //Updating Records
                                $this->db->query("update payroll_mst_pc set
                                payroll_id = '".$payroll_id."', month_start_date = '".$start_dt."', 
                                month_end_date = '".$end_dt."', CardNo = '".$CardNo."',
                                EmpId = '".$EmpId."', EmpName = '".$EmpName."', 
                                department = '".$department."', reporte_name = '".$reporte_name."', 
                                is_labour = '".$is_labour."', duty_hours = '".$duty_hours."', 
                                employee_type = '".$employee_type."', salary_mode = '".$salary_mode."', 
                                month_days = '".$datediff1."', earned_sal = '".$gross_sal."', 
                                PerDaySal = '".$PerDaySal."', PaidDay = '".$PaidDay."', 
                                Penalty_Sum = '".$Penalty_Sum."', NetSalary = '".$NetSalary."', 
                                GrossSal = '".$GrossSal."', BasicSal = '".$BasicSal."', 
                                uan_no = '".$uan_no."', PF_Amt = '".$PF_Amt."', 
                                esi_no = '".$esi_no."', esi_amt = '".$esi_amt."', 
                                tot_advance_amount = '".$tot_advance_amount."', tot_spcl_advance_amount = '".$tot_spcl_advance_amount."', 
                                tot_loan_amount = '".$tot_loan_amount."', prev_ded = '".$prev_ded."', net_paybl_sal = '".$net_paybl_sal."',
                                welfare = '".$welfare."', NetPay = '".$NetPay."', 
                                bank_ac_no = '".$bank_ac_no."', ifsc_code = '".$ifsc_code."', 
                                bank_name = '".$bank_name."' where EmpId = '".$EmpId."' 
                                and payroll_id = '".$payroll_id."'
                                and status = 'Pending For Management Approval'
                                ");

                            } else {

                                //Inserting Records
                                $this->db->query("insert into payroll_mst_pc
                                (payroll_id, month_start_date, month_end_date, CardNo,
                                EmpId, EmpName, department, reporte_name, is_labour, 
                                duty_hours, employee_type, salary_mode, month_days, 
                                earned_sal, PerDaySal, PaidDay, Penalty_Sum, 
                                NetSalary, GrossSal, BasicSal, uan_no, 
                                PF_Amt, esi_no, esi_amt, tot_advance_amount, 
                                tot_spcl_advance_amount, tot_loan_amount, prev_ded, net_paybl_sal, 
                                welfare, NetPay,
                                bank_ac_no, ifsc_code, bank_name, created_by, status)
                                values('".$payroll_id."', '".$start_dt."', '".$end_dt."', '".$CardNo."',
                                '".$EmpId."', '".$EmpName."', '".$department."', '".$reporte_name."', '".$is_labour."',
                                '".$duty_hours."', '".$employee_type."', '".$salary_mode."', '".$datediff1."', 
                                '".$gross_sal."', '".$PerDaySal."', '".$PaidDay."', '".$Penalty_Sum."', 
                                '".$NetSalary."', '".$GrossSal."', '".$BasicSal."', '".$uan_no."', 
                                '".$PF_Amt."', '".$esi_no."', '".$esi_amt."', '".$tot_advance_amount."', 
                                '".$tot_spcl_advance_amount."', '".$tot_loan_amount."', '".$prev_ded."', '".$net_paybl_sal."',
                                '".$welfare."', '".$NetPay."', 
                                '".$bank_ac_no."', '".$ifsc_code."','".$bank_name."','".$created_by."','Pending For Management Approval')");
                            
                            }

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
                        $net_paybl_sal_Tot = $net_paybl_sal_Tot+$net_paybl_sal;
                        $emp_welfare_Tot = $emp_welfare_Tot+$welfare;
                        $NetPay_Tot = $NetPay_Tot+$NetPay;

                        }

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
                    <td><?=number_format(round($emp_welfare_Tot),2,".",""); ?></td>
                    <td><?=number_format(round($NetPay_Tot),2,".",""); ?></td>
                    <td><?=number_format(round($net_paybl_sal_Tot),2,".",""); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>          
            </tbody>
        </table>
    </div>
</div>