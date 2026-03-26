<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$att_month = $_REQUEST['att_month'];
$att_year = $_REQUEST['att_year'];
$comp = $_REQUEST['comp'];
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
$datediff1 = $datediff1+1;

$where_str = "";

if($comp == 'All'){
    $where_str .= "";
} else {
    $where_str .= " and EmpId in(select distinct emp_id from emp_rep_to_mst where branch = '".$comp."')";
}

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th>SNO.</th>
                    <th>UAN No.</th>
                    <th>Name</th>
                    <th>Gross Wages</th>
                    <th>EPF Wages</th>
                    <th>EPS Wages</th>
                    <th>EDLI Wages</th>
                    <th>EPF Contribution</th>
                    <th>EPS Contribution</th>
                    <th>EDLI Contribution</th>
                    <th>NCP Days</th>
                    <th>Refund</th>
                    <th>Pay Days</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Type1
                    $sql_pf = "select * from payroll_mst_type1 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and PF_Amt > 0 $where_str";
                    $qry_pf = $this->db->query($sql_pf);

                    $sno=0;
                    foreach ($qry_pf->result() as $row) { 
                        $sno++; 
                        $uan_no = $row->uan_no;
                        $EmpName = $row->EmpName;
                        $EmpId = $row->EmpId;
                        $GrossSal = $row->GrossSal;
                        $BasicSal = $row->BasicSal;
                        
                        //Special condition for 1800 PF calculation some employees
                        if($BasicSal >= 15000 && $EmpId == 'EMP-MG-00162'){
                            $BasicSal = 15000;
                        }
                        
                        $Management = array('EMP-MG-00010','EMP-MG-00012','EMP-MG-00013','EMP-MG-00014','EMP-MG-00015','EMP-MG-00016');
                        if(in_array($EmpId, $Management)){
                            $BasicSal = 15000;
                        }
                        $epf_cont = ($BasicSal*12)/100;
                        $eps_cont = ($BasicSal*8.33)/100;
                        $edli_cont = $epf_cont-$eps_cont;
                        $PaidDay = $row->PaidDay; 
                        $ncp_days = $datediff1-$PaidDay;
                        $ncp_days = number_format($ncp_days,2,".","");
                        $refund = 0;
                        $days = $PaidDay;

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$uan_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($epf_cont,2,".","");?></td>
                    <td><?=number_format($eps_cont,2,".","");?></td>
                    <td><?=number_format($edli_cont,2,".","");?></td>
                    <td><?=$ncp_days;?></td>
                    <td><?=$refund;?></td>
                    <td><?=$days;?></td>
                </tr>
                <?php
                    }
                ?>
                <?php
                    //Type2
                    $sql_pf = "select * from payroll_mst_type2 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and PF_Amt > 0  $where_str";
                    $qry_pf = $this->db->query($sql_pf);

                    //$sno=0;
                    foreach ($qry_pf->result() as $row) { 
                        $sno++; 
                        $uan_no = $row->uan_no;
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $BasicSal = $row->BasicSal;
                        $epf_cont = ($BasicSal*12)/100;
                        $eps_cont = ($BasicSal*8.33)/100;
                        $edli_cont = $epf_cont-$eps_cont;
                        $Tot_Hrs = $row->Tot_Hrs;
                        $duty_hours = $row->duty_hours;
                        $PaidDay = $Tot_Hrs/$duty_hours;
                        $PaidDay = number_format($PaidDay,2,".","");
                        $ncp_days = $datediff1-$PaidDay;
                        $ncp_days = number_format($ncp_days,2,".","");
                        $refund = 0;
                        $days = $PaidDay;

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$uan_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($epf_cont,2,".","");?></td>
                    <td><?=number_format($eps_cont,2,".","");?></td>
                    <td><?=number_format($edli_cont,2,".","");?></td>
                    <td><?=$ncp_days;?></td>
                    <td><?=$refund;?></td>
                    <td><?=$days;?></td>
                </tr>
                <?php
                    }
                ?>

                <?php
                    //Paper Cup Contract
                    $sql_pf = "select * from payroll_mst_pc 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and PF_Amt > 0  $where_str";
                    $qry_pf = $this->db->query($sql_pf);

                    //$sno=0;
                    foreach ($qry_pf->result() as $row) { 
                        $sno++; 
                        $uan_no = $row->uan_no;
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $BasicSal = $row->BasicSal;
                        $epf_cont = ($BasicSal*12)/100;
                        $eps_cont = ($BasicSal*8.33)/100;
                        $edli_cont = $epf_cont-$eps_cont;
                        $Tot_Hrs = $row->Tot_Hrs;
                        $duty_hours = $row->duty_hours;
                        $PaidDay = $Tot_Hrs/$duty_hours;
                        $PaidDay = number_format($PaidDay,2,".","");
                        $ncp_days = $datediff1-$PaidDay;
                        $ncp_days = number_format($ncp_days,2,".","");
                        $refund = 0;
                        $days = $PaidDay;

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$uan_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($epf_cont,2,".","");?></td>
                    <td><?=number_format($eps_cont,2,".","");?></td>
                    <td><?=number_format($edli_cont,2,".","");?></td>
                    <td><?=$ncp_days;?></td>
                    <td><?=$refund;?></td>
                    <td><?=$days;?></td>
                </tr>
                <?php
                    }
                ?>

                <?php
                    //Paper Blank Contract
                    $sql_pf = "select * from payroll_mst_pb 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and PF_Amt > 0  $where_str";
                    $qry_pf = $this->db->query($sql_pf);

                    //$sno=0;
                    foreach ($qry_pf->result() as $row) { 
                        $sno++; 
                        $uan_no = $row->uan_no;
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $BasicSal = $row->BasicSal;
                        $epf_cont = ($BasicSal*12)/100;
                        $eps_cont = ($BasicSal*8.33)/100;
                        $edli_cont = $epf_cont-$eps_cont;
                        $Tot_Hrs = $row->Tot_Hrs;
                        $duty_hours = $row->duty_hours;
                        $PaidDay = $Tot_Hrs/$duty_hours;
                        $PaidDay = number_format($PaidDay,2,".","");
                        $ncp_days = $datediff1-$PaidDay;
                        $ncp_days = number_format($ncp_days,2,".","");
                        $refund = 0;
                        $days = $PaidDay;

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$uan_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($BasicSal,2,".","");?></td>
                    <td><?=number_format($epf_cont,2,".","");?></td>
                    <td><?=number_format($eps_cont,2,".","");?></td>
                    <td><?=number_format($edli_cont,2,".","");?></td>
                    <td><?=$ncp_days;?></td>
                    <td><?=$refund;?></td>
                    <td><?=$days;?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>