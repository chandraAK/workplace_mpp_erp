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

//Day Shifts
$shift_arr = array();
$sql_shifts = "select distinct name from `tabShift Type` 
where shift_status = 'Enable' and shift_type = 'Day Shift'";

$qry_shifts = $db2->query($sql_shifts);

foreach($qry_shifts->result() as $row){
    $name = $row->name;
    array_push($shift_arr,$name);
}

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SNO.</th>
                    <th>Date</th>
                    <th>MPP Labour</th>
                    <th>PNI Labour</th>
                    <th>ERP</th>
                    <th>Gaurd</th>
                    <th>Sweeper</th>
                    <th>Kariger</th>
                    <th>Total</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $dates = getDatesFromRange($start_dt, $end_dt);
                    $sno=0;
                    foreach ($dates as $key => $value) { 
                        $sno++; 
                        $AttDate = $value; 
                        $rate = 3.5;

                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$AttDate;?></td>
                    <td></td>
                    <td></td>
                    <td><?=present_emp($AttDate, $shift_arr);?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?=$rate;?></td>
                    <td></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>