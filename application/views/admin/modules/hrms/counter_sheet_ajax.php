<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$att_month = $_REQUEST['att_month'];
$att_year = $_REQUEST['att_year'];
$pay_status = $_REQUEST['pay_status'];

//Month Start Date
$start_dt = $att_year."-".$att_month."-01";

//End Date
$sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
$qry_end_dt = $this->db->query($sql_end_dt)->row();
$end_dt = $qry_end_dt->end_dt;

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Organisation Name</th>
                    <th>Earned Salary</th>
                    <th>PF Amount</th>
                    <th>ESIC Amount</th>
                    <th>Advance Deduction</th>
                    <th>Special Advance Deduction</th>
                    <th>Loan Deduction</th>
                    <th>Prev. Deduction</th>
                    <th>Negative Salary</th>
                    <th>Bonus & Welfare</th>
                    <th>Arrear</th>
                    <th>Deductions</th>
                    <th>Total Payable</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight:bold">PPPL TYPE-1 ON</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">PPPL TYPE-1 OFF</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">PPPL TYPE-2 ON</td>
                    <td><?=cs_pni("EmpTotSal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">PPPL TYPE-2 OFF</td>
                    <td><?=cs_pni("EmpTotSal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MDPL TYPE-1 ON</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MDPL TYPE-1 OFF</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MDPL", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MDPL TYPE-2 ON</td>
                    <td><?=cs_pni("EmpTotSal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MDPL", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MDPL TYPE-2 OFF</td>
                    <td><?=cs_pni("EmpTotSal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MDPL", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">PPPL PAPER CUP ON</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_pc", $start_dt, $end_dt, "On Roll", "", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">PPPL PAPER CUP OFF</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_pc", $start_dt, $end_dt, "Off Roll", "", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">PPPL PAPER BLANK OFF</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_pb", $start_dt, $end_dt, "", "", "PNI", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>

                <tr>
                    <td style="font-weight:bold">MPP TYPE-1 ON</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MPP", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MPP TYPE-1 OFF</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "Off Roll", "0", "MPP", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MPP TYPE-2 ON</td>
                    <td><?=cs_pni("EmpTotSal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "On Roll", "1", "MPP", $pay_status, "net_paybl_sal > 0");?></td>                    
                </tr>
                <tr>
                    <td style="font-weight:bold">MPP TYPE-2 OFF</td>
                    <td><?=cs_pni("EmpTotSal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type2", $start_dt, $end_dt, "Off Roll", "1", "MPP", $pay_status, "net_paybl_sal > 0");?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold">MPP Production</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production' and net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production'");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Production' and net_paybl_sal > 0");?></td>
                </tr>

                <tr>
                    <td style="font-weight:bold">MPP Others</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others' and net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("arrear", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("deduction", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others'");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_mpppro", $start_dt, $end_dt, "", "", "", $pay_status, "employee_type = 'Others' and net_paybl_sal > 0");?></td>
                </tr>

                <!--- Total --->
                <tr style="font-weight:bold; background-color:#b3d9ff">
                    <td>Total</td>
                    <td><?=cs_tot("NetSalary", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("PF_Amt", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("esi_amt", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("tot_advance_amount", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("tot_spcl_advance_amount", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("tot_loan_amount", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("prev_ded", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("net_paybl_sal", $start_dt, $end_dt, $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_tot("welfare", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("arrear", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("deduction", $start_dt, $end_dt, $pay_status, "");?></td>
                    <td><?=cs_tot("net_paybl_sal", $start_dt, $end_dt, $pay_status, "net_paybl_sal > 0");?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>