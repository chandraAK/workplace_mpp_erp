<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $from_dt = $_REQUEST['from_dt']; ?>

<h2 style="color:red; text-align:center">Early Exit Mail Sent Successfully</h2>
<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>Card No</th>
            <th>Employee ID</th>
            <th>Employee Name</th>           
            <th>Employee Email</th>           
            <th>Report To</th>           
            <th>Report To Email</th>
            <th>Shift End Time</th>            
            <th>Out Punch</th>           
        </tr>
    </thead>
    <tbody>
        <?php
            //Early Exit
            $sql_get_attip = "SELECT * FROM tran_attendence 
            WHERE CalDate = '".$from_dt."'
            AND shiftEndTime > TIME(OutDateTime)
            AND YEAR(OutDateTime) != 0 
            ORDER BY CardNo";

            $qry_get_attip = $this->db->query($sql_get_attip);

            foreach($qry_get_attip->result() as $row){
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $CalDate = $row->CalDate;
                $reports_to = $row->reports_to;
                $ShiftStartTime = $row->ShiftStartTime;
                $ShiftEndTime = $row->ShiftEndTime;
                $OutDateTime = $row->OutDateTime;
                $MailType = "EE";

                //Employee Email
                $emp_comp_email = get_emp_email($EmpId);

                if($reports_to != NULL){
                    $emp_rt_email = get_rep_email($reports_to);   
                } else {
                    $emp_rt_email = "";
                }

                $cnt_prev = get_prev_entry($from_dt, $MailType, $EmpId);

                if($cnt_prev > 0){

                } else {
                    $this->db->query("insert into tran_mail_det
                    (CardNo, EmpId, EmpName, 
                    CalDate, reports_to, ShiftStartTime, ShiftEndTime, MailType, 
                    EarlyExit) 
                    VALUES
                    ('".$CardNo."', '".$EmpId."', '".$EmpName."', 
                    '".$CalDate."', '".$reports_to."', '".$ShiftStartTime."', '".$ShiftEndTime."', '".$MailType."', 
                    '".$OutDateTime."')");
                }
        ?>
        <tr>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td> 
            <td><?=$emp_comp_email;?></td>
            <td><?=$reports_to;?></td>
            <td><?=$emp_rt_email;?></td>
            <td><?=$ShiftEndTime;?></td>
            <td><?=$OutDateTime;?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>