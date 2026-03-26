<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php
	$from_dt = $_REQUEST['from_dt']; 
	$to_dt = $_REQUEST['to_dt'];
?>

<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Card No</th>
            <th>Employee</th>
            <th>Employee Name</th>
            <th>Pay Days</th>
            <?php
            $dates = getDatesFromRange($from_dt, $to_dt);

            foreach ($dates as $key => $value) {
                $AttDate = $value;
                echo "<th>".$AttDate."</th>";      
            }
            ?>           
        </tr>
    </thead>
    <tbody>
    <?php
        $sql_att = "SELECT distinct CardNo, EmpId, EmpName FROM `mpp_tran_attendence` 
        where CalDate between '".$from_dt."' and '".$to_dt."'";

        $qry_att = $this->db->query($sql_att);
        
        $sno = 0;
        foreach($qry_att->result() as $row){
            $sno++;
            $CardNo = $row->CardNo;
            $EmpId = $row->EmpId;
            $EmpName = $row->EmpName;
    ?>
        <tr>
            <td><?=$sno;?></td>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td>
            <td><?=tot_paid_days_mpp($from_dt, $to_dt, $CardNo);?></td>
            <?php
            foreach ($dates as $key => $value) {
                $AttDate = $value;
            ?>
            <td><?=tot_hrs_cal_mpp($AttDate, $CardNo); ?></td>
            <?php
            }           
            ?> 
        </tr>
    <?php 
        } 
    ?>
    </tbody>
</table>