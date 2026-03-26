<?php
$ticket_module_id = $_REQUEST["ticket_module_id"];
?>
<div class="form-group">
    <label class="col-sm-2 control-label">Issue</label>
    <div class="col-sm-10">
        <select id="ticket_issue_type" name="ticket_issue_type" class="form-control" required>
            <option value="">--select--</option>
            <?php
                $sql_issue_type = "select * from ticket_issue_mst 
                where ticket_module_id = '".$ticket_module_id."' order by ticket_issue_name";
                
                $qry_issue_type = $this->db->query($sql_issue_type);
                foreach($qry_issue_type->result() as $row){
            ?>
            <option value="<?=$row->ticket_issue_id;?>"><?=$row->ticket_issue_name;?></option>
            <?php 
                } 
            ?>
        </select>
    </div>
</div><br/>