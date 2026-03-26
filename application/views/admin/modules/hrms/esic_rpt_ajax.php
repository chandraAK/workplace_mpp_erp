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
                    <th>ESIC No</th>
                    <th>Name</th>
                    <th>Gross Salary</th>
                    <th>ESI Amount</th>
                    <th>Pay Days</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    //Type1
                    $sql_esic = "select * from payroll_mst_type1 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and esi_amt > 0  $where_str";
                    $qry_esic = $this->db->query($sql_esic);

                    $sno=0;
                    foreach ($qry_esic->result() as $row) {
                        $sno++;
                        $esi_no = $row->esi_no; 
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $esi_amt = $row->esi_amt;
                        $PaidDay = $row->PaidDay;

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$esi_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$GrossSal;?></td>
                    <td><?=$esi_amt;?></td>
                    <td><?=$PaidDay;?></td>
                </tr>
                <?php
                    }
                ?>

                <?php
                    //Type2
                    $sql_esic = "select * from payroll_mst_type2 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and esi_amt > 0  $where_str";
                    $qry_esic = $this->db->query($sql_esic);

                    //$sno=0;
                    foreach ($qry_esic->result() as $row) {
                        $sno++;
                        $esi_no = $row->esi_no; 
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $esi_amt = $row->esi_amt;
                        $Tot_Hrs = $row->Tot_Hrs;
                        $duty_hours = $row->duty_hours;
                        $PaidDay = $Tot_Hrs/$duty_hours;
                        $PaidDay = number_format($PaidDay,2,".","");

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$esi_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$GrossSal;?></td>
                    <td><?=$esi_amt;?></td>
                    <td><?=$PaidDay;?></td>
                </tr>
                <?php
                    }
                ?>

                <?php
                    //Paper Cup Contract
                    $sql_esic = "select * from payroll_mst_pc 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and esi_amt > 0  $where_str";
                    $qry_esic = $this->db->query($sql_esic);

                    //$sno=0;
                    foreach ($qry_esic->result() as $row) {
                        $sno++;
                        $esi_no = $row->esi_no; 
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $esi_amt = $row->esi_amt;
                        $Tot_Hrs = $row->Tot_Hrs;
                        $duty_hours = $row->duty_hours;
                        $PaidDay = $Tot_Hrs/$duty_hours;
                        $PaidDay = number_format($PaidDay,2,".","");

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$esi_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$GrossSal;?></td>
                    <td><?=$esi_amt;?></td>
                    <td><?=$PaidDay;?></td>
                </tr>
                <?php
                    }
                ?>

                <?php
                    //Paper Blank Contract
                    $sql_esic = "select * from payroll_mst_pb 
                    where month_start_date = '".$start_dt."' and month_end_date = '".$end_dt."'
                    and esi_amt > 0  $where_str";
                    $qry_esic = $this->db->query($sql_esic);

                    //$sno=0;
                    foreach ($qry_esic->result() as $row) {
                        $sno++;
                        $esi_no = $row->esi_no; 
                        $EmpName = $row->EmpName;
                        $GrossSal = $row->GrossSal;
                        $esi_amt = $row->esi_amt;
                        $Tot_Hrs = $row->Tot_Hrs;
                        $duty_hours = $row->duty_hours;
                        $PaidDay = $Tot_Hrs/$duty_hours;
                        $PaidDay = number_format($PaidDay,2,".","");

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$esi_no;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$GrossSal;?></td>
                    <td><?=$esi_amt;?></td>
                    <td><?=$PaidDay;?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>