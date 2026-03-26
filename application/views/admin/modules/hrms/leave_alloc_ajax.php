<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $emp_id = $_REQUEST['emp_id'];
    $from_date = date("Y")."-01-01";
    $to_date = date("Y")."-12-31";
?>

<h3>Leave Allocation</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th colspan="2">Allocated</th>
            <th colspan="2">Availed</th>
            <th colspan="2">Pending</th>
        </tr>
        <tr>
            <th>Leave Type</th>
            <th>Leaves</th>
            <th>Leave Type</th>
            <th>Leaves</th>
            <th>Leave Type</th>
            <th>Leaves</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql_cnt = "select count(*) as cnt from `tabLeave Allocation` 
            where employee = '".$emp_id."'
            and from_date between '".$from_date."' and '".$to_date."'
            and to_date between '".$from_date."' and '".$to_date."'";

            $qry_cnt = $db2->query($sql_cnt)->row();

            $cnt = $qry_cnt->cnt;

            if($cnt > 0){

                $sql = "select distinct `tabLeave Allocation`.leave_type from `tabLeave Allocation` 
                where employee = '".$emp_id."'
                and from_date between '".$from_date."' and '".$to_date."'
                and to_date between '".$from_date."' and '".$to_date."'";

                //echo $sql; die;

                $qry = $db2->query($sql);
                foreach($qry->result() as $row){
                    $leave_type = $row->leave_type;
            ?>
            <tr>
                <td><?=$leave_type;?></td>
                <td><?=$leave_alloc = number_format(lv_allocated($emp_id, $leave_type, $from_date, $to_date),2,".","");?></td>
                <td><?=$leave_type;?></td>
                <td><?=$leave_avail = number_format(lv_availed($emp_id, str_replace(" ","_",$leave_type), $from_date, $to_date),2,".",""); ?></td>
                <td><?=$leave_type;?></td>
                <td>
                    <?php echo number_format($leave_alloc-$leave_avail,2,".",""); ?>
                    <input type="hidden" id="<?=$leave_type;?>" name="<?=$leave_type;?>" value="<?php echo number_format($leave_alloc-$leave_avail,2,".",""); ?>">
                </td>
            </tr>
        <?php
                }
            } else {
        ?> 
            <input type="hidden" id="Casual_Leave" name="Casual_Leave" value="0">
            <input type="hidden" id="Sick_Leave" name="Sick_Leave" value="0">
        <?php 
            } 
        ?>                
    </tbody>
</table>

<h3>Leave History</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Leave Type</th>
            <th>Leave From Date</th>
            <th>Leave To Date</th>
            <th>Is Halfday</th>
            <th>Halfday Type</th>
            <th>Halfday Day Date</th>
            <th>Leave Days</th>
            <th>Status</th>
            <th>Created Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql_lv_hist = "select * from leave_mst where leave_emp_id = '".$emp_id."'";
            $qry_lv_hist = $this->db->query($sql_lv_hist);
            
            foreach($qry_lv_hist->result() as $row){
                $leave_type = $row->leave_type;
                $leave_from_date = $row->leave_from_date;
                $leave_to_date = $row->leave_to_date;
                $is_halfday = $row->is_halfday;
                $half_day_type = $row->half_day_type;
                $half_day_date = $row->half_day_date;
                $leave_days = $row->leave_days;
                $leave_status = $row->leave_status;
                $created_date = $row->created_date;
        ?>
        <tr>
            <td><?=$leave_type;?></td>
            <td><?=$leave_from_date;?></td>
            <td><?=$leave_to_date;?></td>
            <td><?=$is_halfday;?></td>
            <td><?=$half_day_type;?></td>
            <td><?=$half_day_date;?></td>
            <td><?=$leave_days;?></td>
            <td><?=$leave_status;?></td>
            <td><?=substr($created_date,0,11);?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>