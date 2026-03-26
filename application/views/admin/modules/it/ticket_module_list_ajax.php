<?php
    $ticket_type = $_REQUEST["ticket_type"];
?>
<div class="form-group">
    <label class="col-sm-2 control-label">Ticket Module</label>
    <div class="col-sm-10">
        <select id="ticket_module" name="ticket_module" class="form-control" onChange="ticket_issue_list(this.value);" required>
            <option value="">--select--</option>
            <?php
                $sql_module = "select * from ticket_module_mst where ticket_type_id = '".$ticket_type."' order by ticket_module_name";
                $qry_module = $this->db->query($sql_module);
                foreach($qry_module->result() as $row){
            ?>
            <option value="<?=$row->ticket_module_id;?>"><?=$row->ticket_module_name;?></option>
            <?php 
                } 
            ?>
        </select>
    </div>
</div><br/>

<div id="detail_issue"></div>