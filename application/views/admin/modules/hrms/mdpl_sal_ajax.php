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
                    <th>Total Payable</th>
                    <th>Bonus & Welfare</th>
                    <th>Net Pay</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="font-weight:bold">MDPL ON</td>
                    <td><?=cs_pni("NetSalary", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("PF_Amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("esi_amt", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_spcl_advance_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("tot_loan_amount", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("prev_ded", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_pni("net_paybl_sal", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "net_paybl_sal > 0");?></td>
                    <td><?=cs_pni("welfare", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "PNI", $pay_status, "");?></td>
                    <td><?=cs_pni("NetPay", "payroll_mst_type1", $start_dt, $end_dt, "On Roll", "0", "MDPL", $pay_status, "NetPay > 0");?></td>
                </tr>

                <!--- Total --->
                <tr style="font-weight:bold; background-color:#b3d9ff">
                    <td>Total</td>
                    <td><?=cs_tot_pni("NetSalary", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("PF_Amt", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("esi_amt", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("tot_advance_amount", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("tot_spcl_advance_amount", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("tot_loan_amount", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("prev_ded", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("net_paybl_sal", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "net_paybl_sal < 0");?></td>
                    <td><?=cs_tot_pni("net_paybl_sal", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "net_paybl_sal > 0");?></td>
                    <td><?=cs_tot_pni("welfare", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "");?></td>
                    <td><?=cs_tot_pni("NetPay", $start_dt, $end_dt, "On Roll", "MDPL", $pay_status, "NetPay > 0");?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>