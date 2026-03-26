<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$from_dt = $_REQUEST['from_dt'];
$to_dt = $_REQUEST['to_dt'];
?>


<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
    <tr>
        <th>ID</th>
        <th>Employee</th>
        <th>Employee Name</th>
        <th>Working Hours</th>
        <th>Office Hours</th>
        <th>Overtime</th>
        <th>Status</th>
        <th>Leave Type</th>
        <th>Leave Application</th>
        <th>Attendance Date</th>
        <th>Department</th>
        <th>Shift</th>
        <th>Shift Start Time</th>
        <th>Shift End Time</th>
        <th>In Time</th>
        <th>Out Time</th>
        <th>Mispunch</th>
        <th>Mispunch Application</th>
        <th>Mispunch Application Status</th>
        <th>Gate Pass</th>
        <th>Gate Pass Application</th>
        <th>Gate Pass Application Status</th>
        <th>Created By</th>
        <th>Late Entry</th>
        <th>Late Entry Time</th>
        <th>Early Exit</th>
        <th>Early Exit Time</th>
        <th>Amended From</th>
        <th>Created On</th>
        <th>OT Eligiblity</th>
        <th>OT Eligiblity Time</th>
        <th>OT Applied</th>
        <th>OT Applied Hours</th>
        <th>OT Approve</th>
        <th>OT Approve Hours</th>
    </tr>
    </thead>
    <tbody>
        <?php
            $sql_att = "select * from `tabAttendance` 
            where attendance_date between '".$to_dt."' and '".$from_dt."'";

            $qry_att = $db2->query($sql_att);

            foreach($qry_att->result() as $row){
                $name = $row->name;
                $employee = $row->employee;
                $employee_name = $row->employee_name;
                $working_hours = $row->working_hours;
                $office_hours = $row->office_hours;
                $overtime = $row->overtime;
                $status = $row->status;
                $leave_type = $row->leave_type;
                $leave_application = $row->leave_application;
                $attendance_date = $row->attendance_date;
                $department = $row->department;
                $shift = $row->shift;
                $in_time = $row->in_time;
                $out_time = $row->out_time;
                $miss_punch = $row->miss_punch;
                $owner = $row->owner;
                $late_entry = $row->late_entry;
                $early_exit = $row->early_exit;
                $amended_from = $row->amended_from;
                $creation = $row->creation;

                $sql_shift_th = "select name, start_time, end_time from `tabShift Type`  
                where name = '".$shift."'";
                $qry_shift_th = $db2->query($sql_shift_th)->row();
                $shift_start_time = $qry_shift_th->start_time;
                $shift_end_time = $qry_shift_th->end_time;

                //Late Entry
                if($late_entry > 0){
                    $sql_le = "select TIMEDIFF('".$in_time."', '".$shift_start_time."') as le_time";
                    $qry_le = $this->db->query($sql_le)->row();
                    $le_time = $qry_le->le_time;
                } else {
                    $le_time = "";
                }

                //Early Exit
                if($early_exit > 0){
                    $sql_ee = "select TIMEDIFF('".$shift_end_time."', '".$out_time."') as ee_time";
                    $qry_ee = $this->db->query($sql_ee)->row();
                    $ee_time = $qry_ee->ee_time;
                } else {
                    $ee_time = "";
                }

                //Mispunch
                if($miss_punch > 0){
                    $sql_app_mp = "select name, workflow_state
                    from `tabMiss Punch Application` 
                    where employee = '".$employee."'
                    and miss_punch_date = '".$attendance_date."'";

                    $qry_app_mp = $db2->query($sql_app_mp)->row();

                    $miss_punch_id = $qry_app_mp->name;
                    $miss_punch_status = $qry_app_mp->workflow_state;

                } else {
                    $miss_punch_id = "";
                    $miss_punch_status = "";
                }

                //Gate Pass
                $sql_gp_cnt = "select count(*) as cnt_gp  from `tabGate Pass` 
                where employee = '".$employee."'
                and date = '".$attendance_date."'";

                $qry_gp_cnt = $db2->query($sql_gp_cnt)->row();
                $cnt_gp = $qry_gp_cnt->cnt_gp;

                if($cnt_gp > 0){
                    $sql_gp_hrs = "select name, workflow_state from `tabGate Pass` 
                    where employee = '".$employee."'
                    and date = '".$attendance_date."'";

                    $qry_gp_hrs = $db2->query($sql_gp_hrs);
                    $tot_gp_hrs = 0;
                    foreach($qry_gp_hrs->result() as $row){
                        $gp_id = $row->name;
                        $gp_workflow_state = $row->workflow_state;
                    }
                } else {
                    $gp_id = "";
                    $gp_workflow_state = "";
                }

                //Overtime

        ?>
        <tr>
            <td><?=$name;?></td>
            <td><?=$employee;?></td>
            <td><?=$employee_name;?></td>
            <td><?=number_format($working_hours,2,".","");?></td>
            <td><?=number_format($office_hours,2,".","");?></td>
            <td><?=number_format($overtime,2,".","");?></td>
            <td><?=$status;?></td>
            <td><?=$leave_type;?></td>
            <td><?=$leave_application;?></td>
            <td><?=$attendance_date;?></td>
            <td><?=$department;?></td>
            <td><?=$shift;?></td>
            <td><?=substr($shift_start_time,0,8);?></td>
            <td><?=substr($shift_end_time,0,8);?></td>
            <td><?=substr($in_time,0,8);?></td>
            <td><?=substr($out_time,0,8);?></td>
            <td><?=$miss_punch;?></td>
            <td><?=$miss_punch_id;?></td>
            <td><?=$miss_punch_status;?></td>
            <td><?=$cnt_gp;?></td>
            <td><?=$gp_id;?></td>
            <td><?=$gp_workflow_state;?></td>
            <td><?=$owner;?></td>
            <td><?=$late_entry;?></td>
            <td><?=substr($le_time,0,8);?></td>
            <td><?=$early_exit;?></td>
            <td><?=substr($ee_time,0,8);?></td>
            <td><?=$amended_from;?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php
            }
        ?>
        <?php /*
        <tr>
            <td colspan="2">
                <b>Total Present : <?php echo count_array_value($status_arr, 'Present'); ?></b>
            </td>
            <td colspan="2">
                <b>Total Absent : <?php echo count_array_value($status_arr, 'Absent'); ?></b>
            </td>
            <td colspan="2">
                <b>Total Half Day : <?php echo count_array_value($status_arr, 'Half Day'); ?></b>
            </td>
            <td colspan="2">
                <b>Total On Leave : <?php echo count_array_value($status_arr, 'On Leave'); ?></b>
            </td>
            <td colspan="27"></td>
        </tr>
        */?>
    </tbody>
</table>