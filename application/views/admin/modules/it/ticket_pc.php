<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Ticket Pending For Clarification</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $ticket_id = $_REQUEST['id'];
        if($ticket_id != ''){
            foreach($get_by_id->result() as $row){
                $ticket_type = $row->ticket_type;
                $ticket_severity = $row->ticket_severity;
                $ticket_module = $row->ticket_module;
                $ticket_issue_type = $row->ticket_issue_type;
                $ticket_issue_desc = $row->ticket_issue_desc;
                $ticket_remedy = $row->ticket_remedy;
                $ticket_comments = $row->ticket_comments;
                $ticket_assigned_to = $row->ticket_assigned_to;
                $ticket_status = $row->ticket_status;
                $created_by = $row->created_by;
                $created_date = $row->created_date;
                //Other Details
                $ticket_rmks_assign = $row->ticket_rmks_assign;
                $ticket_assigned_by = $row->ticket_assigned_by;
                $ticket_assigned_date = $row->ticket_assigned_date;
                $ticket_open_rg = $row->ticket_open_rg;
                $ticket_open_rmks = $row->ticket_open_rmks;
                $ticket_open_act = $row->ticket_open_act;
                $ticket_open_act_by = $row->ticket_open_act_by;
                $ticket_open_act_date = $row->ticket_open_act_date;
                $ticket_pc_rmks = $row->ticket_pc_rmks;
                $ticket_pc_act = $row->ticket_pc_act;
                $ticket_pc_act_by = $row->ticket_pc_act_by;
                $ticket_pc_act_date = $row->ticket_pc_act_date;

                //Ticket Type Name
                $sql_ticket_tn = "select * from ticket_type_mst where ticket_type_id = '".$ticket_type."'";
                $qry_ticket_tn = $this->db->query($sql_ticket_tn)->row();
                $ticket_type_name = $qry_ticket_tn->ticket_type_name;

                //Ticket Severity
                $sql_ticket_sev = "select * from ticket_sev_mst where ticket_sev_id = '".$ticket_severity."'";
                $qry_ticket_sev = $this->db->query($sql_ticket_sev)->row();
                $ticket_sev_name = $qry_ticket_sev->ticket_sev_name;

                //Ticket Module Name
                $sql_ticket_mod = "select * from ticket_module_mst where ticket_module_id = '".$ticket_module."'";
                $qry_ticket_mod = $this->db->query($sql_ticket_mod)->row();
                $ticket_module_name = $qry_ticket_mod->ticket_module_name;

                //Ticket Issue Type Name
                $sql_ticket_it = "select * from ticket_issue_mst where ticket_issue_id = '".$ticket_issue_type."'";
                $qry_ticket_it = $this->db->query($sql_ticket_it)->row();
                $ticket_issue_name = $qry_ticket_it->ticket_issue_name;
            }
        } else {
            $ticket_type = "";
            $ticket_severity = "";
            $ticket_module = "";
            $ticket_issue_type = "";
            $ticket_issue_desc = "";
            $ticket_remedy = "";
            $ticket_comments = "";
            $ticket_assigned_to = "";
            $ticket_status = "";
            $created_by = "";
            $created_date = "";
            
            //Other Details
            $ticket_rmks_assign = "";
            $ticket_assigned_by = "";
            $ticket_assigned_date = "";
            $ticket_open_rg = "";
            $ticket_open_rmks = "";
            $ticket_open_act = "";
            $ticket_open_act_by = "";
            $ticket_open_act_date = "";
            $ticket_pc_rmks = "";
            $ticket_pc_act = "";
            $ticket_pc_act_by = "";
            $ticket_pc_act_date = "";
            $ticket_type_name = "";
            $ticket_sev_name = "";
            $ticket_module_name = "";
            $ticket_issue_name = "";
        }
    ?>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                <h4>Ticket Pending For Clarification</h4>
            </header>

            <div class="panel-body">
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/itc/ticket_pc_entry">
                <?php include("ticket_details_div.php"); ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label"  style="text-align:left">Remarks</label>
                    <div class="col-sm-10">
                        <textarea id="ticket_pc_rmks" name="ticket_pc_rmks" class="form-control"></textarea>
                    </div>
                </div>

                <?php
                    $username = $_SESSION['username'];
                    if($created_by == $username){ 
                ?>
                <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Re-Open">
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Close">
                    </div>
                    <div class="col-sm-3"></div>
                </div>
                <?php } else { echo "<b style='color:red; font-size:18px;'>You are not authorized to take action ...</b>"; } ?>
            </form>
            </div>

            <div class="col-lg-2"></div>
        </section>
        </div>
    </div>
  </section>
</section>