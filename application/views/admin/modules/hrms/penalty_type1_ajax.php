<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $from_dt = $_REQUEST['from_dt']; ?>
<?php $to_dt = $_REQUEST['to_dt']; ?>

<?php 
$this->db->query("delete from tran_penalties 
where CalDate between '".$from_dt."' and '".$to_dt."'  and EmpType = 1"); 
?>

<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>Card No</th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Date</th>           
            <th>Shift Start Time</th>
            <th>Shift End Time</th>
            <th>InPunch</th>
            <th>OutPunch</th>
            <th>Penalty Type</th>            
            <th>Hours</th>            
            <th>Deduction(Days)</th>          
            <th>Gate Pass No</th>          
        </tr>
    </thead>
    <tbody>
        <?php
            $get_type1_emp = get_type1_emp();

            $str = '';
            foreach($get_type1_emp as $var){
                if($str == ''){
                    $str = "'".$var."'";
                }else{
                    $str = $str.","."'".$var."'";
                }
            }

            //Late Entry > 5 Minutes
            $sql_get_attip = "SELECT *, TIMEDIFF(TIME(InDateTime), shiftStartTime) as hours FROM tran_attendence 
            WHERE CalDate between '".$from_dt."' AND '".$to_dt."'
            AND TIME(InDateTime) > ADDTIME(shiftStartTime, '00:05:00')
            AND emp_holiday = 0
            AND PaidDay = 1
            AND (emp_leave = '' OR emp_leave is NULL)
            AND (emp_dr = '' OR emp_dr is NULL)
            AND (emp_adjustment = '' OR emp_adjustment is NULL)
            AND (emp_mispunch = '' OR emp_mispunch is NULL)
            AND (emp_penalty = '' OR emp_penalty is NULL)
	        AND YEAR(InDateTime) != 0
            AND EmpId in(".$str.")
            ORDER BY CardNo";

            $qry_get_attip = $this->db->query($sql_get_attip);

            foreach($qry_get_attip->result() as $row){
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $CalDate = $row->CalDate;
                $ShiftStartTime = $row->ShiftStartTime;
                $ShiftEndTime = $row->ShiftEndTime;
                $InDateTime = $row->InDateTime;
                $OutDateTime = $row->OutDateTime;
                $ShiftWorkingHrs = $row->ShiftWorkingHrs;
                $hours = $row->hours;
                $hours = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$hours);
                $MailType = "LE";

                $half_day = $ShiftWorkingHrs/2;
                $three_four_day = ($ShiftWorkingHrs*3)/4;
                $one_four_day = ($ShiftWorkingHrs*3)/4;
                $full_day = $ShiftWorkingHrs/1;

                //Gate Pass Checking
                // $sql_gp_cnt = "select count(*) as cnt_gp  from `tabGate Pass` 
                // where workflow_state in('Approved By HR Manager','Approved By HOD')
                // and deducted = 0
                // and lop = 0
                // and employee = '".$EmpId."'
                // and date between '".$from_dt."' and '".$to_dt."' ";

                // $qry_gp_cnt = $db2->query($sql_gp_cnt)->row();
                // $cnt_gp = $qry_gp_cnt->cnt_gp;

                // $gp_id_arr = array();
                // if($cnt_gp > 0){
                //     $sql_gp_hrs = "select name, TIMEDIFF(to_time, from_time) as gp_hrs  from `tabGate Pass` 
                //     where workflow_state in('Approved By HR Manager','Approved By HOD')
                //     and deducted = 0
                //     and lop = 0
                //     and employee = '".$emp_id."'
                //     and date between '".$from_dt."' and '".$to_dt."' ";

                //     $qry_gp_hrs = $db2->query($sql_gp_hrs);
                //     $tot_gp_hrs = 0;
                //     foreach($qry_gp_hrs->result() as $row){
                //         $gp_id = $row->name;
                //         $gp_hrs = $row->gp_hrs;
                //         $gp_hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$gp_hrs);
                //         $tot_gp_hrs = $tot_gp_hrs+$gp_hrs;
                //         array_push($gp_id_arr, $gp_id);
                //     }
                // } else {
                //     $gp_id = "";
                //     $tot_gp_hrs = 0;
                // }
                
                $tot_gp_hrs = 0;
                if($tot_gp_hrs > 0){
                    $hours1 = 0;
                } else {
                    $hours1 = $hours;
                }
                

                if($hours1 > 0){

                    if($hours <= $one_four_day){
                        $deduction_days = 0.25;
                    } else if($hours > $one_four_day && $hours <= $half_day){
                        $deduction_days = 0.5;
                    } else if($hours > $half_day && $hours <= $three_four_day){
                        $deduction_days = 0.75;
                    } else if($hours > $three_four_day){
                        $deduction_days = 1;
                    } else {
                        $deduction_days = 0;
                    }

                    $this->db->query("insert into tran_penalties(CardNo, EmpId, EmpName, 
                    CalDate, ShiftStartTime, ShiftEndTime, 
                    InDateTime, OutDateTime, PenaltyType, 
                    PenaltyHours, Penalty, GatePass, EmpType)
                    values('".$CardNo."', '".$EmpId."', '".$EmpName."', 
                    '".$CalDate."', '".$ShiftStartTime."', '".$ShiftEndTime."',
                    '".$InDateTime."', '".$OutDateTime."', '".$MailType."', 
                    '".$hours."', '".$deduction_days."', '".$gp_id."', '1')");
        ?>
        <tr>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td> 
            <td><?=$CalDate;?></td> 
            <td><?=$ShiftStartTime;?></td>
            <td><?=$ShiftEndTime;?></td>
            <td><?=$InDateTime;?></td>
            <td><?=$OutDateTime;?></td>
            <td><?=$MailType;?></td>
            <td><?=$hours;?></td>
            <td><?=$deduction_days;?></td>
            <td><?=$gp_id;?></td>
        </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>