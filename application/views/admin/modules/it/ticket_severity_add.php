<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Severity Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_sev_id = $_REQUEST['id'];
        if($ticket_sev_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_sev_name = $row->ticket_sev_name;
            }
        } else {
            $ticket_sev_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Ticket Severity Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_severity_type_entry">
            <div class="panel-body">
                <?php
                    if($ticket_sev_id != ''){
                        echo "<h2>Ticket Severity Id - ".$ticket_sev_id."</h2>";
                ?>
                    <input type="hidden" id="ticket_sev_id" name="ticket_sev_id" value="<?=$ticket_sev_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="ticket_sev_id" name="ticket_sev_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Severity Type Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ticket_sev_name" name="ticket_sev_name" 
                        value="<?php echo $ticket_sev_name; ?>" required>
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