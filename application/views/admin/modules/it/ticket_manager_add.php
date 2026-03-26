<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Manager Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_manager_id = $_REQUEST['id'];
        if($ticket_manager_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_manager_name = $row->ticket_manager_name;
            }
        } else {
            $ticket_manager_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Ticket Manager Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_manager_entry">
            <div class="panel-body">
                <?php
                    if($ticket_manager_id != ''){
                        echo "<h2>Ticket Manager Id - ".$ticket_manager_id."</h2>";
                ?>
                    <input type="hidden" id="ticket_manager_id" name="ticket_manager_id" value="<?=$ticket_manager_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="ticket_manager_id" name="ticket_manager_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Manager Name</label>
                    <div class="col-sm-10">
                        <select id="ticket_manager_name" name="ticket_manager_name" class="form-control" required>
                            <option value="">--Select--</option>
                            <?php
                                $sql_manager_list = "select * from login where emp_active = 'yes'";
                                $qry_manager_list = $this->db->query($sql_manager_list);
                                foreach($qry_manager_list->result() as $row){
                                    $id = $row->id;
                                    $name = $row->name;
                            ?>
                            <option value="<?=$id;?>"><?=$name;?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Ticket Type Name</label>
                    <div class="col-sm-10">
                        <select id="ticket_manager_type_id" name="ticket_manager_type_id" class="form-control" required>
                            <option value="">--Select--</option>
                            <?php
                                $sql_tt_list = "select * from ticket_type_mst";
                                $qry_tt_list = $this->db->query($sql_tt_list);
                                foreach($qry_tt_list->result() as $row){
                                    $ticket_type_id = $row->ticket_type_id;
                                    $ticket_type_name = $row->ticket_type_name;
                            ?>
                            <option value="<?=$ticket_type_id;?>"><?=$ticket_type_name;?></option>
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