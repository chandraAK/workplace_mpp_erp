<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$from_dt = $_REQUEST['from_dt']; 
$to_dt = $_REQUEST['to_dt']; 
$card_no = $_REQUEST['card_no']; 
?>
<?php
//Get Employee ID
$sql_get_empid = "select name from `tabEmployee` where custom_card_no = '".$card_no."'";
$qry_get_empid = $db2->query($sql_get_empid)->row();
$emp_id = $qry_get_empid->name;

//Get User Name
$sql_get_usernm = "select username from login where emp_id = '".$emp_id."'";
$qry_get_usernm = $this->db->query($sql_get_usernm)->row();
$username = $qry_get_usernm->username;
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Payment Date</b></th>
                    <th><b>Particulars</b></th>
                    <th><b>Credit Amount</b></th>
                    <th><b>Debit Amount</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //All Credit Entries
                    $sql_get_cr = "select payment_date, pr_id, pr_amt from pr_mst 
                    where emp_id = '".$emp_id."' 
                    and pr_type = 'Request' 
                    and status = 'Paid'
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";

                    $qry_get_cr = $this->db->query($sql_get_cr);
                    
                    $sno = 0;
                    $sum_cr_amt = 0;
                    foreach($qry_get_cr->result() as $row){
                        $sno++;
                        $payment_date = $row->payment_date;
                        $pr_id = $row->pr_id;
                        $pr_amt = $row->pr_amt;
                        $sum_cr_amt = $sum_cr_amt+$pr_amt;
                ?>
                <tr>
                    <td><?=substr($payment_date,0,11);?></td>
                    <td>Payment Request - <?=$pr_id;?></td>
                    <td><?=$pr_amt;?></td>
                    <td></td>
                </tr>
                <?php
                    }
                ?>

                <?php
                    //All Debit Entries
                    $sql_get_dr = "select payment_date, pr_id, pr_amt from pr_mst 
                    where emp_id = '".$emp_id."' 
                    and pr_type = 'Return' 
                    and status = 'Paid'
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";

                    $qry_get_dr = $this->db->query($sql_get_dr);

                    $sum_dr_amt = 0;
                    foreach($qry_get_dr->result() as $row){
                        $sno++;
                        $payment_date = $row->payment_date;
                        $pr_id = $row->pr_id;
                        $pr_amt = $row->pr_amt;
                        $sum_dr_amt = $sum_dr_amt+$pr_amt;
                ?>
                <tr>
                    <td><?=substr($payment_date,0,11);?></td>
                    <td>Payment Return - <?=$pr_id;?></td>
                    <td></td>
                    <td><?=$pr_amt;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Type1 --->
                <?php
                    $sql_sal_type1 = "select EmpId, net_paybl_sal, paid_date 
                    from payroll_mst_type1 
                    where PaidMode = 'Cash' 
                    and status = 'Paid' 
                    and paid_by = '".$username."'
                    and net_paybl_sal >= 0
                    and date(paid_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sql_type1 = $this->db->query($sql_sal_type1);

                    foreach($qry_sql_type1->result() as $row){
                        $sno++;
                        $EmpId = $row->EmpId;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $paid_date = $row->paid_date;
                        $sum_dr_amt = $sum_dr_amt+$net_paybl_sal;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Paid Type 1 - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$net_paybl_sal;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Type2 --->
                <?php
                    $sql_sal_type2 = "select EmpId, net_paybl_sal, paid_date 
                    from payroll_mst_type2 
                    where PaidMode = 'Cash'
                    and status = 'Paid' 
                    and paid_by = '".$username."'
                    and net_paybl_sal >= 0
                    and date(paid_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sql_type2 = $this->db->query($sql_sal_type2);

                    foreach($qry_sql_type2->result() as $row){
                        $sno++;
                        $EmpId = $row->EmpId;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $paid_date = $row->paid_date;
                        $sum_dr_amt = $sum_dr_amt+$net_paybl_sal;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Paid Type 2 - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$net_paybl_sal;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Paper Cup --->
                <?php
                    $sql_sal_type2 = "select EmpId, net_paybl_sal, paid_date 
                    from payroll_mst_pc 
                    where PaidMode = 'Cash'
                    and status = 'Paid' 
                    and paid_by = '".$username."'
                    and net_paybl_sal >= 0
                    and date(paid_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sql_type2 = $this->db->query($sql_sal_type2);

                    foreach($qry_sql_type2->result() as $row){
                        $sno++;
                        $EmpId = $row->EmpId;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $paid_date = $row->paid_date;
                        $sum_dr_amt = $sum_dr_amt+$net_paybl_sal;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Paid Paper Cup - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$net_paybl_sal;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Paper Blank --->
                <?php
                    $sql_sal_type2 = "select EmpId, net_paybl_sal, paid_date 
                    from payroll_mst_pb 
                    where PaidMode = 'Cash'
                    and status = 'Paid' 
                    and paid_by = '".$username."'
                    and net_paybl_sal >= 0
                    and date(paid_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sql_type2 = $this->db->query($sql_sal_type2);

                    foreach($qry_sql_type2->result() as $row){
                        $sno++;
                        $EmpId = $row->EmpId;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $paid_date = $row->paid_date;
                        $sum_dr_amt = $sum_dr_amt+$net_paybl_sal;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Paid Paper Blank - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$net_paybl_sal;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary MPP Production & Others --->
                <?php
                    $sql_sal_type2 = "select EmpId, net_paybl_sal, paid_date 
                    from payroll_mst_mpppro 
                    where PaidMode = 'Cash'
                    and status = 'Paid' 
                    and paid_by = '".$username."'
                    and net_paybl_sal >= 0
                    and date(paid_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sql_type2 = $this->db->query($sql_sal_type2);

                    foreach($qry_sql_type2->result() as $row){
                        $sno++;
                        $EmpId = $row->EmpId;
                        $net_paybl_sal = $row->net_paybl_sal;
                        $paid_date = $row->paid_date;
                        $sum_dr_amt = $sum_dr_amt+$net_paybl_sal;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Paid Paper Blank - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$net_paybl_sal;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Advance --->
                <?php
                    $sql_sal_adv = "select emp_id, sal_adv_req, payment_date 
                    from salary_adv
                    where status = 'Paid' 
                    and PaidMode = 'Cash'  
                    and payment_by = '".$username."'
                    and sal_adv_req >= 0
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sal_adv = $this->db->query($sql_sal_adv);

                    foreach($qry_sal_adv->result() as $row){
                        $sno++;
                        $EmpId = $row->emp_id;
                        $sal_adv_req = $row->sal_adv_req;
                        $paid_date = $row->payment_date;
                        $sum_dr_amt = $sum_dr_amt+$sal_adv_req;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Advance Paid - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$sal_adv_req;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Advance Paper Cup --->
                <?php
                    $sql_sal_adv = "select emp_id, sal_adv_req, payment_date 
                    from salary_adv_pcpb
                    where status = 'Paid' 
                    and PaidMode = 'Cash'  
                    and payment_by = '".$username."'
                    and sal_adv_req >= 0
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sal_adv = $this->db->query($sql_sal_adv);

                    foreach($qry_sal_adv->result() as $row){
                        $sno++;
                        $EmpId = $row->emp_id;
                        $sal_adv_req = $row->sal_adv_req;
                        $paid_date = $row->payment_date;
                        $sum_dr_amt = $sum_dr_amt+$sal_adv_req;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Advance Paper Cup / Paper Blank Paid - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$sal_adv_req;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Advance Paper Cup --->
                <?php
                    $sql_sal_adv = "select emp_id, sal_adv_req, payment_date 
                    from salary_adv_pb
                    where status = 'Paid' 
                    and PaidMode = 'Cash'  
                    and payment_by = '".$username."'
                    and sal_adv_req >= 0
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sal_adv = $this->db->query($sql_sal_adv);

                    foreach($qry_sal_adv->result() as $row){
                        $sno++;
                        $EmpId = $row->emp_id;
                        $sal_adv_req = $row->sal_adv_req;
                        $paid_date = $row->payment_date;
                        $sum_dr_amt = $sum_dr_amt+$sal_adv_req;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Advance Paper Cup / Paper Blank Paid - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$sal_adv_req;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Salary Advance MPP Production & Others --->
                <?php
                    $sql_sal_adv = "select emp_id, sal_adv_req, payment_date 
                    from salary_adv_mpp_prod
                    where status = 'Paid' 
                    and PaidMode = 'Cash'  
                    and payment_by = '".$username."'
                    and sal_adv_req >= 0
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_sal_adv = $this->db->query($sql_sal_adv);

                    foreach($qry_sal_adv->result() as $row){
                        $sno++;
                        $EmpId = $row->emp_id;
                        $sal_adv_req = $row->sal_adv_req;
                        $paid_date = $row->payment_date;
                        $sum_dr_amt = $sum_dr_amt+$sal_adv_req;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Salary Advance MPP Production & Others Paid - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$sal_adv_req;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Special Salary Advance --->
                <?php
                    $sql_spcl_sal_adv = "select emp_id, sal_adv_req, payment_date 
                    from spcl_salary_adv
                    where status = 'Paid'   
                    and PaidMode = 'Cash'
                    and payment_by = '".$username."'
                    and sal_adv_req >= 0
                    and date(payment_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_spcl_sal_adv = $this->db->query($sql_spcl_sal_adv);

                    foreach($qry_spcl_sal_adv->result() as $row){
                        $sno++;
                        $EmpId = $row->emp_id;
                        $sal_adv_req = $row->sal_adv_req;
                        $paid_date = $row->payment_date;
                        $sum_dr_amt = $sum_dr_amt+$sal_adv_req;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Special Salary Advance Paid - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$sal_adv_req;?></td>
                </tr>
                <?php
                    }
                ?>

                <!---- Fixed Overtime Salary --->
                <?php
                    $sql_fixed_ot = "select EmpId, OTAmt_Tot, paid_date 
                    from fixed_overtime
                    where status = 'Paid'   
                    and PaidMode = 'Cash'
                    and paid_by = '".$username."'
                    and OTAmt_Tot >= 0
                    and date(paid_date) between '".$from_dt."' and '".$to_dt."'";
                    
                    $qry_fixed_ot = $this->db->query($sql_fixed_ot);

                    foreach($qry_fixed_ot->result() as $row){
                        $sno++;
                        $EmpId = $row->EmpId;
                        $OTAmt_Tot = $row->OTAmt_Tot;
                        $paid_date = $row->paid_date;
                        $sum_dr_amt = $sum_dr_amt+$OTAmt_Tot;
                ?>
                <tr>
                    <td><?=substr($paid_date,0,11);?></td>
                    <td>Fixed Overtime Paid - <?=$EmpId;?></td>
                    <td></td>
                    <td><?=$OTAmt_Tot;?></td>
                </tr>
                <?php
                    }
                ?>

                <!--- Total Amount --->
                <tr style="background-color:#b3d9ff">
                    <td>ZZZ</td>
                    <td></td>
                    <td><b><?=number_format($sum_cr_amt,2,".","");?></b></td>
                    <td><b><?=number_format($sum_dr_amt,2,".","");?></b></td>
                </tr>

                <!--- Balance Amount --->
                <tr style="background-color:#b3d9ff">
                    <td>ZZZ</td>
                    <td></td>
                    <td><b>Balance Amount</b></td>
                    <td><b><?=number_format($sum_cr_amt-$sum_dr_amt,2,".","");?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>