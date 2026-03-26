<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
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

                    $sql_emp = "select distinct emp_id, employee_name, employee_type, tot_sal from `mpp_prod_sal` 
                    where month_start_date = '".$start_dt."'
                    and month_end_date = '".$end_dt."'
                    and payroll_id = '".$payroll_id."'
                    order by emp_id";

                    $qry_emp = $this->db->query($sql_emp);

                    //Totals
                    $NetSalary_Tot = 0;
                    $GrossSal_Tot = 0;
                    $BasicSal_Tot = 0;
                    $PF_Amt_Tot = 0;
                    $esi_amt_Tot = 0;
                    $tot_advance_amount_Tot = 0;
                    $tot_spcl_advance_amount_Tot = 0;
                    $tot_loan_amount_Tot = 0;
                    $net_paybl_sal_Tot = 0;

                    foreach($qry_emp->result() as $row){
                        $CardNo = "";
                        $EmpId = $row->emp_id;
                        $EmpName = $row->employee_name;
                        $tot_sal = $row->tot_sal;
                        $employee_type = $row->employee_type;

                        $is_labour = "";
                        $duty_hours = "";
                        $department = "";
                        $salary_mode = "";
                        $is_on_contract = "";
                        $reporte_name = "";
                        $uan_no = "";
                        $esi_no = "";
                        //$employee_type = "";
                        $bank_ac_no = "";
                        $ifsc_code = "";
                        $bank_name = "";

                        $gross_sal = 0;

                        $PerDaySal = 0;

                        $PaidDay = 0;

                        //Penalties
                        $Penalty_Sum = 0;

                        if($Penalty_Sum > 0){
                            $PaidDay = $PaidDay - $Penalty_Sum;
                        }

                        $NetSalary = $tot_sal;
                        $GrossSal = $tot_sal;
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
                        $sql_adv_sal = "select sum(sal_adv_req) as tot_advance_amount from `salary_adv_mpp_prod` 
                        where emp_id = '".$EmpId."' and date(created_date) between '".$start_dt."' and '".$end_dt."' and status = 'Paid'";

                        $qry_adv_sal = $this->db->query($sql_adv_sal)->row();

                        $tot_advance_amount = $qry_adv_sal->tot_advance_amount;

                        //Loan EMI
                        $sql_loan = "select sum(`tabRepayment Schedule`.total_payment) as total_payment from `tabLoan` 
                        inner join `tabRepayment Schedule` on `tabRepayment Schedule`.parent = `tabLoan`.name
                        where `tabLoan`.applicant = '".$EmpId."'
                        and `tabLoan`.status = 'Sanctioned'
                        and `tabRepayment Schedule`.payment_date between '".$FirstDayOfNextMonth."' and '".$LastDayOfNextMonth."'";

                        $qry_loan = $db2->query($sql_loan)->row();

                        $tot_loan_amount = $qry_loan->total_payment;

                        $net_paybl_sal = 0;
                        $net_paybl_sal = $NetSalary - ($tot_advance_amount+$tot_spcl_advance_amount+$tot_loan_amount+$PF_Amt+$esi_amt);

                        $NetPay = $net_paybl_sal;

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
                    <td><?=$Penalty_Sum = number_format(round($Penalty_Sum),2,".","");?></td>
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
                    <td><?=$net_paybl_sal = number_format(round($net_paybl_sal),2,".",""); ?></td>
                    <td><?=$bank_ac_no; ?></td>
                    <td><?=$ifsc_code; ?></td>
                    <td><?=$bank_name; ?></td>
                </tr>

                <?php
                            $sql_check = "select count(*) as cnt from payroll_mst_mpppro where EmpId = '".$EmpId."' 
                            and payroll_id = '".$payroll_id."'";

                            $qry_check = $this->db->query($sql_check)->row();

                            $cnt = $qry_check->cnt;

                            if($cnt > 0){
                                //Updating Records
                                $this->db->query("update payroll_mst_mpppro set
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
                                tot_loan_amount = '".$tot_loan_amount."', net_paybl_sal = '".$net_paybl_sal."',  NetPay = '".$NetPay."',
                                bank_ac_no = '".$bank_ac_no."', ifsc_code = '".$ifsc_code."', 
                                bank_name = '".$bank_name."' where EmpId = '".$EmpId."' 
                                and payroll_id = '".$payroll_id."'
                                and status = 'Pending For Management Approval'");

                            } else {

                                //Inserting Records
                                $this->db->query("insert into payroll_mst_mpppro
                                (payroll_id, month_start_date, month_end_date, CardNo,
                                EmpId, EmpName, department, reporte_name, is_labour, 
                                duty_hours, employee_type, salary_mode, month_days, 
                                earned_sal, PerDaySal, PaidDay, Penalty_Sum, 
                                NetSalary, GrossSal, BasicSal, uan_no, 
                                PF_Amt, esi_no, esi_amt, tot_advance_amount, 
                                tot_spcl_advance_amount, tot_loan_amount, net_paybl_sal, NetPay, bank_ac_no, 
                                ifsc_code, bank_name, created_by, status)
                                values('".$payroll_id."', '".$start_dt."', '".$end_dt."', '".$CardNo."',
                                '".$EmpId."', '".$EmpName."', '".$department."', '".$reporte_name."', '".$is_labour."',
                                '".$duty_hours."', '".$employee_type."', '".$salary_mode."', '".$datediff1."', 
                                '".$gross_sal."', '".$PerDaySal."', '".$PaidDay."', '".$Penalty_Sum."', 
                                '".$NetSalary."', '".$GrossSal."', '".$BasicSal."', '".$uan_no."', 
                                '".$PF_Amt."', '".$esi_no."', '".$esi_amt."', '".$tot_advance_amount."', 
                                '".$tot_spcl_advance_amount."', '".$tot_loan_amount."', '".$net_paybl_sal."', '".$NetPay."', '".$bank_ac_no."', 
                                '".$ifsc_code."','".$bank_name."','".$created_by."','Pending For Management Approval')");
                            
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
                    <td><?=number_format(round($net_paybl_sal_Tot),2,".",""); ?></td>
                    <td></td>
                    <td></td>
                    <td></td>         
            </tbody>
        </table>
    </div>
</div>