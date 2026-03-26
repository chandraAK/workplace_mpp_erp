<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Module Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_module_id = $_REQUEST['id'];
        if($ticket_module_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_module_name = $row->ticket_module_name;
            }
        } else {
            $ticket_module_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Ticket Module Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_module_entry">
            <div class="panel-body">
                <?php
                    if($ticket_module_id != ''){
                        echo "<h2>Ticket Module Id - ".$ticket_module_id."</h2>";
                ?>
                    <input type="hidden" id="ticket_module_id" name="ticket_module_id" value="<?=$ticket_module_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="ticket_module_id" name="ticket_module_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Module Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ticket_module_name" name="ticket_module_name" 
                        value="<?php echo $ticket_module_name; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Type</label>
                    <div class="col-sm-10">
                        <select id="ticket_type-id" name="ticket_type_id" class="form-control" onChange="ticket_module_list(this.value);" required>
                            <option value="">--select--</option>
                            <?php
                                $sql_issue_type = "select * from ticket_type_mst order by ticket_type_name";
                                $qry_issue_type = $this->db->query($sql_issue_type);
                                foreach($qry_issue_type->result() as $row){
                            ?>
                            <option value="<?=$row->ticket_type_id;?>"><?=$row->ticket_type_name;?></option>
                            <?php 
                                } 
                            ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-5"></div>
                </div>
            </form>
            </div>
            <div class="col-lg-2"></div>
        </section>
        </div>
    </div>
  </section>
</section>