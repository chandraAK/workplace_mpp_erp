<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Inquiry Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $inq_no = $_REQUEST['id'];
        if($inq_no != ''){
            foreach($get_inq_by_id->result() as $row){
                $inq_rec_by = $row->inq_rec_by;
                $inq_rec_on = $row->inq_rec_on;
                $inq_source = $row->inq_source;
                $inq_comp = $row->inq_comp;
                $inq_type = $row->inq_type;
                $inq_cust_type = $row->inq_cust_type;
                $inq_add_line1 = $row->inq_add_line1;
                $inq_add_line2 = $row->inq_add_line2;
                $inq_add_dist = $row->inq_add_dist;
                $inq_add_pin = $row->inq_add_pin;
                $inq_add_state = $row->inq_add_state;
                $inq_cust_nm = $row->inq_cust_nm;
                $inq_cust_email1 = $row->inq_cust_email1;
                $inq_cust_email2 = $row->inq_cust_email2;
                $inq_cust_mob1 = $row->inq_cust_mob1;
                $inq_cust_mob2 = $row->inq_cust_mob2;
                $inq_landline = $row->inq_landline;
                $inq_turnkey_sol = $row->inq_turnkey_sol;
                $inq_turnkey_package = $row->inq_turnkey_package;
                $inq_prod_rmk = $row->inq_prod_rmk;
                $inq_lead_prior = $row->inq_lead_prior;
                $inq_lead_owner = $row->inq_lead_owner;
                $inq_lead_rmk = $row->inq_lead_rmk;
            }
        } else {
                $inq_rec_by = $row->inq_rec_by;
                $inq_rec_on = "";
                $inq_source = "";
                $inq_comp = "";
                $inq_type = "";
                $inq_cust_type = "";
                $inq_add_line1 = "";
                $inq_add_line2 = "";
                $inq_add_dist = "";
                $inq_add_pin = "";
                $inq_add_state = "";
                $inq_cust_nm = "";
                $inq_cust_email1 = "";
                $inq_cust_email2 = "";
                $inq_cust_mob1 = "";
                $inq_cust_mob2 = "";
                $inq_landline = "";
                $inq_turnkey_sol = "";
                $inq_turnkey_package = "";
                $inq_prod_rmk = "";
                $inq_lead_prior = "";
                $inq_lead_owner = "";
                $inq_lead_rmk = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Inquiry Form
            </header>
            <div class="panel-body">
            <?php
                if($inq_no != ''){
                    echo "<h2>".$inq_no."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/inquiry_entry">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Recorded by</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_rec_by" name="inq_rec_by" 
                        value="<?php if($inq_rec_by == ""){ echo $_SESSION['username']; } else { echo $inq_rec_by; } ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry received on</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_rec_on" name="inq_rec_on" value="<?php echo $inq_rec_on; ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Source</label>
                    <div class="col-sm-10">
                        <select id="inq_source" name="inq_source" class="form-control" required>
                            
                            <option value="<?php echo $inq_source; ?>"><?php echo $inq_source; ?></option>
                            <?php
                                $sql_enq_source = "select * from inq_source_mst";
                                $qry_enq_source = $this->db->query($sql_enq_source);

                                foreach($qry_enq_source->result() as $row){
                                    $source_name = $row->source_name;
                            ?>
                            <option value="<?php echo $source_name; ?>"><?php echo $source_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Company/Organisation</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_comp" name="inq_comp" value="<?php echo $inq_comp; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">New or Existing Customer</label>
                    <div class="col-sm-10">
                        <select id="inq_type" name="inq_type" class="form-control">
                            <option value="<?php echo $inq_type; ?>"><?php echo $inq_type; ?></option>
                            <option value="New">New</option>
                            <option value="Existing">Existing</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer Type</label>
                    <div class="col-sm-10">
                        <select id="inq_cust_type" name="inq_cust_type" class="form-control">
                            <option value="<?php echo $inq_cust_type; ?>"><?php echo $inq_cust_type; ?></option>
                            <option value="Direct Party">Direct Party</option>
                            <option value="Dealer/Distributor">Dealer/Distributor</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Address Line 1</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_add_line1" name="inq_add_line1" 
                        value="<?php echo $inq_add_line1; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Address Line 2</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_add_line2" name="inq_add_line2" value="<?php echo $inq_add_line2; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">City/District</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_add_dist" name="inq_add_dist" value="<?php echo $inq_add_dist; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">PIN Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_add_pin" name="inq_add_pin" 
                        value="<?php echo $inq_add_pin; ?>" onkeypress="return isNumberKey(event);" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">State & Union Territory</label>
                    <div class="col-sm-10">
                        <select id="inq_add_state" name="inq_add_state" class="form-control" required>
                            <option value="<?php echo $inq_add_state; ?>"><?php echo $inq_add_state; ?></option>
                            <?php
                                $sql_state = "select * from state_mst";
                                $qry_state = $this->db->query($sql_state);
                                
                                foreach($qry_state->result() as $row){
                                    $state_name = $row->state_name;
                            ?>
                            <option value="<?php echo $state_name; ?>"><?php echo $state_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_cust_nm" name="inq_cust_nm" 
                        value="<?php echo $inq_cust_nm; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email Address - 1</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_cust_email1" name="inq_cust_email1" value="<?php echo $inq_cust_nm; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email Address - 2</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_cust_email2" name="inq_cust_email2" value="<?php echo $inq_cust_nm; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number - 1</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_cust_mob1" name="inq_cust_mob1" 
                        value="<?php echo $inq_cust_mob1; ?>" onkeypress="return isNumberKey(event);" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number - 2</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_cust_mob2" name="inq_cust_mob2" 
                        value="<?php echo $inq_cust_mob2; ?>" onkeypress="return isNumberKey(event);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Landline Number</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_landline" name="inq_landline" 
                        value="<?php echo $inq_landline; ?>" onkeypress="return isNumberKey(event);">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Category</label>
                    <div class="col-sm-10" style="text-align:left">
                        <input type="radio" id="inq_category" name="inq_category" value="Spare Parts"> Spare Parts<br>
                        <input type="radio" id="inq_category" name="inq_category" value="Flour Mill"> Flour Mill<br>
                        <input type="radio" id="inq_category" name="inq_category" value="Individual Machine"> Individual Machine
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Turnkey Solutions</label>
                    <div class="col-sm-10">
                        <select id="inq_turnkey_sol" name="inq_turnkey_sol" class="form-control">
                            <option value="<?php echo $inq_turnkey_sol; ?>"><?php echo $inq_turnkey_sol; ?></option>
                            <option value="10 Tons Per Day">10 Tons Per Day</option>
                            <option value="20 Tons Per Day">20 Tons Per Day</option>
                            <option value="40 Tons Per Day">40 Tons Per Day</option>
                            <option value="60 Tons Per Day">60 Tons Per Day</option>
                            <option value="80 Tons Per Day">80 Tons Per Day</option>
                            <option value="100 Tons Per Day">100 Tons Per Day</option>
                            <option value="150 Tons Per Day">150 Tons Per Day</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Turnkey Solutions - Package Type</label>
                    <div class="col-sm-10">
                        <select id="inq_turnkey_package" name="inq_turnkey_package" class="form-control">
                            <option value="<?php echo $inq_turnkey_package; ?>"><?php echo $inq_turnkey_package; ?></option>
                            <option value="Only Milling Section">Only Milling Section</option>
                            <option value="Milling Section with Cleaning Section">Milling Section with Cleaning Section</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Remark for Product or Turnkey Solution</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_prod_rmk" name="inq_prod_rmk" value="<?php echo $inq_prod_rmk; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Priority</label>
                    <div class="col-sm-10">
                        <select id="inq_lead_prior" name="inq_lead_prior" class="form-control">
                            <option value="<?php echo $inq_lead_prior; ?>"><?php echo $inq_lead_prior; ?></option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Owner</label>
                    <div class="col-sm-10">
                        <select id="inq_lead_owner" name="inq_lead_owner" class="form-control">
                            <option value="<?php echo $inq_lead_owner; ?>"><?php echo $inq_lead_owner; ?></option>
                            <option value="Nidhi Maheshwari">Nidhi Maheshwari</option>
                            <option value="Ajay Singh">Ajay Singh</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Remark</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inq_lead_rmk" name="inq_lead_rmk" value="<?php echo $inq_lead_rmk; ?>" required>
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

<script>
//$('#inq_rec_on').datepicker();
//$("#inq_rec_on").datepicker();
$( function() {
    $( "#inq_rec_on" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>