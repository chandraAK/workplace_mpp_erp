<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;
?>

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
            <th><b>Status</b></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT payroll_id, CardNo, EmpId, EmpName, department, 
            reporte_name, is_labour, duty_hours, employee_type, 
            salary_mode, NetSalary, GrossSal, BasicSal, uan_no, 
            PF_Amt, esi_no, esi_amt, tot_advance_amount, 
            tot_spcl_advance_amount, tot_loan_amount, net_paybl_sal, bank_ac_no, 
            ifsc_code, bank_name, status 
            FROM `payroll_mst_type1` 
            where month_start_date = '".$start_dt."' 
            and month_end_date = '".$end_dt."'
            and net_paybl_sal < 0
            UNION
            SELECT payroll_id, CardNo, EmpId, EmpName, department, 
            reporte_name, is_labour, duty_hours, employee_type, 
            salary_mode, EmpTotSal as NetSalary, GrossSal, BasicSal, uan_no, 
            PF_Amt, esi_no, esi_amt, tot_advance_amount, 
            tot_spcl_advance_amount, tot_loan_amount, net_paybl_sal, bank_ac_no, 
            ifsc_code, bank_name, status  
            FROM `payroll_mst_type2` 
            where month_start_date = '".$start_dt."' 
            and month_end_date = '".$end_dt."'
            and net_paybl_sal < 0
            ";

            $qry = $this->db->query($sql);

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

            foreach($qry->result() as $row){
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
                $NetSalary = $row->NetSalary;
                $GrossSal = $row->GrossSal;
                $BasicSal = $row->BasicSal;
                $uan_no = $row->uan_no;
                $PF_Amt = $row->PF_Amt;
                $esi_no = $row->esi_no;
                $esi_amt = $row->esi_amt;
                $tot_advance_amount = $row->tot_advance_amount;
                $tot_spcl_advance_amount = $row->tot_spcl_advance_amount;
                $tot_loan_amount = $row->tot_loan_amount;
                $net_paybl_sal = $row->net_paybl_sal;
                $bank_ac_no = $row->bank_ac_no;
                $ifsc_code = $row->ifsc_code;
                $bank_name = $row->bank_name;
                $status = $row->status;
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
            <td><?=$net_paybl_sal;?></td>
            <td><?=$bank_ac_no;?></td>
            <td><?=$ifsc_code;?></td>
            <td><?=$bank_name;?></td>
            <td><?=$status;?></td>
        </tr>
        <?php
                $sql_cnt = "select count(*) as cnt from neg_sal_emp 
                where month_start_date = '".$start_dt."' 
                and month_end_date = '".$end_dt."'
                and EmpId = '".$EmpId."'";

                $qry_cnt = $this->db->query($sql_cnt)->row();

                $cnt = $qry_cnt->cnt;

                if($cnt > 0){
                    $this->db->query("update neg_sal_emp set 
                    month_start_date = '".$start_dt."', month_end_date = '".$end_dt."', 
                    CardNo = '".$CardNo."', EmpId = '".$EmpId."', 
                    net_paybl_sal = '".$net_paybl_sal."' 
                    where month_start_date = '".$start_dt."' 
                    and month_end_date = '".$end_dt."'
                    and EmpId = '".$EmpId."'"); 
                    
                } else {
                    $this->db->query("insert into neg_sal_emp(month_start_date, month_end_date, CardNo, EmpId, net_paybl_sal) 
                    values('".$start_dt."','".$end_dt."','".$CardNo."','".$EmpId."','".$net_paybl_sal."')");
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
                <td></td>
            </tr>
    </tbody>
</table>