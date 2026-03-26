<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Type Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_type_id = $_REQUEST['id'];
        if($ticket_type_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_type_name = $row->ticket_type_name;
            }
        } else {
            $ticket_type_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Ticket Type Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_type_entry">
            <div class="panel-body">
                <?php
                    if($ticket_type_id != ''){
                        echo "<h2>Ticket Type Id - ".$ticket_type_id."</h2>";
                ?>
                    <input type="hidden" id="ticket_type_id" name="ticket_type_id" value="<?=$ticket_type_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="ticket_type_id" name="ticket_type_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Type Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="ticket_type_name" name="ticket_type_name" 
                        value="<?php echo $ticket_type_name; ?>" required>
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