<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $from_dt = $_REQUEST['from_dt']; ?>
<?php $to_dt = $_REQUEST['to_dt']; ?>

<?php 
$this->db->query("delete from tran_penalties 
where CalDate between '".$from_dt."' and '".$to_dt."' and EmpType = 2"); 
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
            <th>Deduction(Hours)</th>           
        </tr>
    </thead>
    <tbody>
        <?php
            $get_type2_emp = get_type2_emp();

            $str = '';
            foreach($get_type2_emp as $var){
                if($str == ''){
                    $str = "'".$var."'";
                }else{
                    $str = $str.","."'".$var."'";
                }
            }

            //Late Entry > 10 Minutes
            $sql_get_attip = "SELECT *, TIMEDIFF(TIME(InDateTime), shiftStartTime) as hours FROM tran_attendence 
            WHERE CalDate between '".$from_dt."' AND '".$to_dt."'
            AND TIME(InDateTime) > ADDTIME(shiftStartTime, '00:10:00')
            AND emp_holiday != 1
            AND Tot_Hrs >= ShiftWorkingHrs
            AND (emp_leave = '' OR emp_leave is NULL)
            AND (emp_dr = '' OR emp_dr is NULL)
            AND (emp_adjustment = '' OR emp_adjustment is NULL)
            AND (emp_mispunch = '' OR emp_mispunch is NULL)
            AND (emp_penalty = '' OR emp_penalty is NULL)
	        AND YEAR(InDateTime) != 0
            AND EmpId in(".$str.")
            ORDER BY CardNo";

            //echo $sql_get_attip; die;

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

                if($hours <= 1){
                    $deduction_days = 1;
                } else if($hours <= 2){
                    $deduction_days = 2;
                } else if($hours <= 3){
                    $deduction_days = 3;
                } else if($hours <= 4){
                    $deduction_days = 4;
                } else if($hours <= 5){
                    $deduction_days = 5;
                } else if($hours <= 6){
                    $deduction_days = 6;
                } else if($hours <= 7){
                    $deduction_days = 7;
                } else if($hours <= 8){
                    $deduction_days = 8;
                } else if($hours <= 9){
                    $deduction_days = 9;
                } else if($hours <= 10){
                    $deduction_days = 10;
                } else if($hours <= 11){
                    $deduction_days = 11;
                } else {
                    $deduction_days = 0;
                }

                $this->db->query("insert into tran_penalties(CardNo, EmpId, EmpName, 
                CalDate, ShiftStartTime, ShiftEndTime, 
                InDateTime, OutDateTime, PenaltyType, 
                PenaltyHours, Penalty, EmpType)
                values('".$CardNo."', '".$EmpId."', '".$EmpName."', 
                '".$CalDate."', '".$ShiftStartTime."', '".$ShiftEndTime."',
                '".$InDateTime."', '".$OutDateTime."', '".$MailType."', 
                '".$hours."', '".$deduction_days."', '2')");
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
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>