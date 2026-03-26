<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Issue Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_issue_id = $_REQUEST['id'];
        if($ticket_issue_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_issue_name = $row->ticket_issue_name;
            }
        } else {
            $ticket_issue_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Ticket Module Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_issue_entry">
            <div class="panel-body">
                <?php
                    if($ticket_issue_id != ''){
                        echo "<h2>Ticket Issue Id - ".$ticket_issue_id."</h2>";
                ?>
                    <input type="hidden" id="ticket_issue_id" name="ticket_issue_id" value="<?=$ticket_issue_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="ticket_issue_id" name="ticket_issue_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Issue Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ticket_issue_name" name="ticket_issue_name" 
                        value="<?php echo $ticket_issue_name; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Module Name</label>
                    <div class="col-sm-10">
                        <select id="ticket_module_id" name="ticket_module_id" class="form-control" required>
                            <option value="">--Select--</option>
                            <?php
                                $sql_module_list = "select * from ticket_module_mst";
                                $qry_module_list = $this->db->query($sql_module_list);
                                foreach($qry_module_list->result() as $row){
                                    $ticket_module_id = $row->ticket_module_id;
                                    $ticket_module_name = $row->ticket_module_name;
                            ?>
                            <option value="<?=$ticket_module_id;?>"><?=$ticket_module_name;?></option>
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