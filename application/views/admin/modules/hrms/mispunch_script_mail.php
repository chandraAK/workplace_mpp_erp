<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $from_dt = $_REQUEST['from_dt']; ?>

<h2 style="color:red; text-align:center">Mispunch Mail Sent Successfully</h2>
<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>Card No</th>
            <th>Employee ID</th>
            <th>Employee Name</th>           
            <th>Employee Email</th>           
            <th>Report To</th>           
            <th>Report To Email</th>           
            <th>Mispunch Date</th>           
            <th>Mispunch Type</th>           
        </tr>
    </thead>
    <tbody>
        <?php
            //InPunch
            $sql_get_attip = "SELECT * FROM tran_attendence 
            WHERE CalDate = '".$from_dt."'
            AND YEAR(InDateTime) = 0
            AND YEAR(OutDateTime) != 0
            ORDER BY CardNo";

            $qry_get_attip = $this->db->query($sql_get_attip);

            foreach($qry_get_attip->result() as $row){
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $CalDate = $row->CalDate;
                $ShiftStartTime = $row->ShiftStartTime;
                $ShiftEndTime = $row->ShiftEndTime;
                $reports_to = $row->reports_to;
                $mispunch = "In Punch Missing";
                $MailType = "MP";

                //Employee Email
                $emp_comp_email = get_emp_email($EmpId);

                if($reports_to != NULL){
                    $emp_rt_email = get_rep_email($reports_to);   
                } else {
                    $emp_rt_email = "";
                }

                $cnt_prev = get_prev_entry($from_dt, $MailType, $EmpId);

                if($cnt_prev > 0){

                    $this->db->query("
                    delete from tran_mail_det 
                    where CalDate = '".$from_dt."' 
                    and MailType='".$MailType."'
                    and EmpId = '".$EmpId."'
                    ");

                    $this->db->query("insert into tran_mail_det
                    (CardNo, EmpId, EmpName, 
                    CalDate, reports_to, ShiftStartTime, ShiftEndTime, MailType, 
                    MisPunchType) 
                    VALUES
                    ('".$CardNo."', '".$EmpId."', '".$EmpName."', 
                    '".$CalDate."', '".$reports_to."', '".$ShiftStartTime."', '".$ShiftEndTime."', '".$MailType."', 
                    '".$mispunch."')");

                } else {
                    $this->db->query("insert into tran_mail_det
                    (CardNo, EmpId, EmpName, 
                    CalDate, reports_to, ShiftStartTime, ShiftEndTime, MailType, 
                    MisPunchType) 
                    VALUES
                    ('".$CardNo."', '".$EmpId."', '".$EmpName."', 
                    '".$CalDate."', '".$reports_to."', '".$ShiftStartTime."', '".$ShiftEndTime."', '".$MailType."', 
                    '".$mispunch."')");
                }
        ?>
        <tr>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td> 
            <td><?=$emp_comp_email;?></td>
            <td><?=$reports_to;?></td>
            <td><?=$emp_rt_email;?></td>
            <td><?=$CalDate;?></td>
            <td><?=$mispunch;?></td>
        </tr>
        <?php
            }
        ?>

        <?php
            //Outpunch
            $sql_get_attip = "SELECT * FROM tran_attendence 
            WHERE CalDate = '".$from_dt."'
            AND YEAR(OutDateTime) = 0 
            AND YEAR(InDateTime) != 0 
            ORDER BY CardNo";

            $qry_get_attip = $this->db->query($sql_get_attip);

            foreach($qry_get_attip->result() as $row){
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $CalDate = $row->CalDate;
                $ShiftStartTime = $row->ShiftStartTime;
                $ShiftEndTime = $row->ShiftEndTime;
                $reports_to = $row->reports_to;
                $mispunch = "Out Punch Missing";
                $MailType = "MP";

                //Employee Email
                $emp_comp_email = get_emp_email($EmpId);

                if($reports_to != NULL){
                    $emp_rt_email = get_rep_email($reports_to);   
                } else {
                    $emp_rt_email = "";
                }

                if($cnt_prev > 0){

                } else {
                    $this->db->query("insert into tran_mail_det
                    (CardNo, EmpId, EmpName, 
                    CalDate, reports_to, ShiftStartTime, ShiftEndTime, MailType, 
                    MisPunchType) 
                    VALUES
                    ('".$CardNo."', '".$EmpId."', '".$EmpName."', 
                    '".$CalDate."', '".$reports_to."', '".$ShiftStartTime."', '".$ShiftEndTime."', '".$MailType."', 
                    '".$mispunch."')");
                }
        ?>
        <tr>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td> 
            <td><?=$emp_comp_email;?></td>
            <td><?=$reports_to;?></td>
            <td><?=$emp_rt_email;?></td>
            <td><?=$CalDate;?></td>
            <td><?=$mispunch;?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>