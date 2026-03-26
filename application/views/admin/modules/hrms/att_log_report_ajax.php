<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$from_dt = $_REQUEST['from_dt']; 
$to_dt = $_REQUEST['to_dt']; 
$CardNo = $_REQUEST['CardNo']; 
?>


<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>Card No</th>
            <th>Punch Time</th>
            <th>Machine No</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql_att_log = "select * from tran_machinerawpunch 
            where CardNo = '".$CardNo."' 
            and date(PunchDatetime) between '".$from_dt."' and '".$to_dt."'
            order by PunchDatetime desc
            ";

            $qry_att_log = $this->db->query($sql_att_log);

            foreach($qry_att_log->result() as $row){
        ?>
        <tr>
            <td><?=$row->CardNo;?></td>
            <td><?=$row->PunchDatetime;?></td>
            <td><?=$row->MachineNo;?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>