<table class="table table-bordered" id="example1" style="margin-top:60px">
    <thead>
        <tr>
            <th>ID</th>
            <th>Employee</th>
            <th>Employee Name</th>
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
        $sql_att = "SELECT distinct CardNo, EmpId, EmpName FROM `tran_attendence` 
        where CalDate between '".$from_dt."' and '".$to_dt."'";

        $qry_att = $this->db->query($sql_att);

        foreach($qry_att->result() as $row){
            $CardNo = $row->CardNo;
            $EmpId = $row->EmpId;
            $EmpName = $row->EmpName;
    ?>
        <tr>
            <td><?=$CardNo;?></td>
            <td><?=$EmpId;?></td>
            <td><?=$EmpName;?></td>
            <?php
            foreach ($dates as $key => $value) {
                $AttDate = $value;
            ?>
            <td><?=tot_hrs_cal($AttDate, $CardNo); ?></td>
            <?php
            }           
            ?> 
        </tr>
    <?php 
        } 
    ?>
    </tbody>
</table>