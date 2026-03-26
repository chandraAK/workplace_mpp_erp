<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $from_dt = $_REQUEST['from_dt']; ?>

<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>Card No</th>
            <th>Employee ID</th>
            <th>Employee Name</th>
            <th>Employee Email</th>           
            <th>Reports To</th>           
            <th>Reports To Email</th>
            <th>Att Date</th>
            <th>Shift Start Time</th>
            <th>Shift End Time</th>
            <th>Mail Type</th>            
            <th>Mispunch Type</th>           
            <th>Late Entry</th> 
            <th>Early Exit</th>          
        </tr>
    </thead>
    <tbody>
        <?php
            //InPunch
            $sql_get_attip = "SELECT * FROM tran_mail_det 
            WHERE CalDate = '".$from_dt."'
            ORDER BY sno";

            $qry_get_attip = $this->db->query($sql_get_attip);

            foreach($qry_get_attip->result() as $row){
                $CardNo = $row->CardNo;
                $EmpId = $row->EmpId;
                $EmpName = $row->EmpName;
                $CalDate = $row->CalDate;
                $reports_to = $row->reports_to;
                $ShiftStartTime = $row->ShiftStartTime;
                $ShiftEndTime = $row->ShiftEndTime;
                $MailType = $row->MailType;
                $MisPunchType = $row->MisPunchType;
                $LateEntry = $row->LateEntry;
                $EarlyExit = $row->EarlyExit;

                //Employee Email
                $emp_comp_email = get_emp_email($EmpId);

                if($reports_to != NULL){
                    $emp_rt_email = get_rep_email($reports_to);   
                } else {
                    $emp_rt_email = "";
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
            <td><?=$ShiftStartTime;?></td>
            <td><?=$ShiftEndTime;?></td>
            <td><?=$MailType;?></td>
            <td><?=$MisPunchType;?></td>
            <td><?=$LateEntry;?></td>
            <td><?=$EarlyExit;?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>