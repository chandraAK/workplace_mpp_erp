<?php $this->load->helper("itemlist"); ?>

<style>
	button.accordion {
		background-color:#ddd;
		color: #444;
		cursor: pointer;
		padding: 5px;
		width: 100%;
		border: none;
		text-align: center;
		font-weight:bold;
		outline: none;
		font-size: 14px;
		transition: 0.4s;
		border-radius:8px;
	}
	
	button.accordion.active, button.accordion:hover {
		background-color: #999999;
	}
	
	button.accordion:after {
		content: '\02795';
		font-size: 13px;
		color: #777;
		float: right;
		margin-left: 5px;
	}
	
	button.accordion.active:after {
		content: "\2796";
	}
	
	div.panel {
		padding: 0 5px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: 0.6s ease-in-out;
		opacity: 0;
		margin-bottom:4px;
	}
	
	div.panel.show {
		opacity: 1;
		max-height: 750px;
	}
	
	table thead tr{
		display:block;
	}
	
	table th,table td{
		width:300px;
	}
	
	table  tbody{		
		display:block;
		/*height:200px;*/
		overflow:auto;
	}
</style>

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
        $msg = $_REQUEST['msg'];
        if($inq_no != ''){
            foreach($get_inq_by_id->result() as $row){
                $inq_rec_by = $row->inq_rec_by;
                $inq_rec_on = $row->inq_rec_on;
                $inq_source = $row->inq_source;
                $inq_cust_nm = $row->inq_cust_nm;
                $inq_cust_type = $row->inq_cust_type;
                $inq_add = $row->inq_add;
                $inq_add_dist = $row->inq_add_dist;
                $inq_add_state = $row->inq_add_state;
                $inq_add_pin = $row->inq_add_pin;
                $inq_folup_date = $row->inq_folup_date;
                $inq_status = $row->inq_status;

                $inq_contact_person = $row->inq_contact_person;
                $inq_email1 = $row->inq_email1;
                $inq_email2 = $row->inq_email2;
                $inq_mob1 = $row->inq_mob1;
                $inq_mob2 = $row->inq_mob2;
                $inq_landline = $row->inq_landline;
                $inq_turnky_sol = $row->inq_turnky_sol;
                $inq_turnky_sol_pkg = $row->inq_turnky_sol_pkg;
                $inq_turnky_sol_rmk = $row->inq_turnky_sol_rmk;
                $inq_spares = $row->inq_spares;
                $inq_lead_priority = $row->inq_lead_priority;
                $inq_lead_owner = $row->inq_lead_owner;
                $inq_lead_rmk = $row->inq_lead_rmk;
                $inq_last_conv = $row->inq_last_conv;
                $inq_conv_date = $row->inq_conv_date;
                $inq_file_att = $row->inq_file_att;
            }
        } else {
            $inq_rec_by = "";
            $inq_rec_on = "";
            $inq_source = "";
            $inq_cust_nm = "";
            $inq_cust_type = "";
            $inq_add = "";
            $inq_add_dist = "";
            $inq_add_state = "";
            $inq_add_pin = "";
            $inq_folup_date = "";
            $inq_status = "";

            $inq_contact_person = "";
            $inq_email1 = "";
            $inq_email2 = "";
            $inq_mob1 = "";
            $inq_mob2 = "";
            $inq_landline = "";
            $inq_turnky_sol = "";
            $inq_turnky_sol_pkg = "";
            $inq_turnky_sol_rmk = "";
            $inq_spares = "";
            $inq_lead_priority = "";
            $inq_lead_owner = "";
            $inq_lead_rmk = "";
            $inq_last_conv = "";
            $inq_conv_date = "";
            $inq_file_att = "";
        }
    ?>
    <!--- Alert Msg -->
    <?php if($msg != ""){ ?>
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success! Data Submitted Successfully.</strong>
            </div>
        </div>
        <div class="col-lg-2"></div> 
    </div>
    <?php } ?>

    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <section class="panel">
                <header class="panel-heading" style="text-align:center; font-weight:bold">Inquiry Form</header>
                
                <form class="form-horizontal" name="InqForm" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/crmc/inquiry_entry" onsubmit="return validateForm()">

                <div class="panel-body">
                    <!-- Inquiry Details -->
                    <?php
                        if($inq_no != ''){
                            echo "<h4 style='text-align:center'>Inquiry No - ".$inq_no."</h4>";
                    ?>
                        <input type="hidden" id="inq_no" name="inq_no" value="<?=$inq_no; ?>">
                    <?php
                        } else {
                    ?>
                        <input type="hidden" id="inq_no" name="inq_no" value="">
                    <?php
                        }
                    ?>

                    <!--- Change Status --->
                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-1"><b>Status</b></div>
                        <div class="col-lg-3">
                            <select id="change_status" name="change_status" class="form-control" required>
                                <?php if($inq_status != ""){ ?>
                                    <option value="<?=$inq_status;?>"><?=$inq_status;?></option>
                                <?php } else { ?>
                                    <option value="">--Select--</option>
                                <?php } ?>

                                <?php
                                    $sql_stages = "select * from crm_stage_mst order by stage_id";
                                    $qry_stages = $this->db->query($sql_stages); 
                                    foreach($qry_stages->result() as $row){
                                        $stage = $row->stage_name;
                                ?>
                                    <option value="<?=$stage; ?>"><?=$stage; ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div><br>
                    
                    <!-- Accordian Starts-->
                    <!-- CRM -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>CRM</b>
                    </button>
                    <div class="panel">
                        <br/><br/>
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
                                <input type="text" class="form-control" id="inq_rec_on" name="inq_rec_on" 
                                value="<?php if($inq_rec_on != ""){echo $inq_rec_on; } else { echo date("yy-m-d"); }?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Inquiry Source</label>
                            <div class="col-sm-10">
                                <select id="inq_source" name="inq_source" class="form-control">
                                    <?php if($inq_source != ""){?>
                                        <option value="<?=$inq_source;?>" selected><?=$inq_source;?></option>
                                    <?php } ?>
                                    
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
                            <label class="col-sm-2 control-label">Company Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_cust_nm" name="inq_cust_nm" 
                                value="<?php echo $inq_cust_nm; ?>">

                                <span style="color:red" id="error_inq_cust_nm" ></span>
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Customer Type</label>
                            <div class="col-sm-10">
                                <select id="inq_cust_type" name="inq_cust_type" class="form-control">
                                    <?php if($inq_cust_type != ""){?> 
                                        <option value="<?php echo $inq_cust_type; ?>"><?php echo $inq_cust_type; ?></option>
                                    <?php } ?>

                                    <option value="New">New</option>
                                    <option value="Existing">Existing</option>
                                </select>
                            </div>
                        </div>
                        <br/><br/>
                    </div>
                    
                    <!-- Point Of Contact -->
                    <button class="accordion" style="color:black; font-weight:bold;" type="button" onclick="accordian();">
                        <b>Point Of Contact</b>
                    </button>
                    <div class="panel">
                        <br/><br/>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_add" name="inq_add" value="<?php echo $inq_add; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">City/District</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_add_dist" name="inq_add_dist" value="<?php echo $inq_add_dist; ?>">

                                <span id="error_inq_add_dist" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">State & Union Territory</label>
                            <div class="col-sm-10">
                                <select id="inq_add_state" name="inq_add_state" class="form-control">
                                    <?php if($inq_cust_type != ""){?> 
                                    <option value="<?php echo $inq_add_state; ?>"><?php echo $inq_add_state; ?></option>
                                    <?php } ?>

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
                            <label class="col-sm-2 control-label">PIN Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_add_pin" name="inq_add_pin" 
                                value="<?php echo $inq_add_pin; ?>" onkeypress="return isNumberKey(event);">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Contact Person</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_contact_person" name="inq_contact_person" value="<?php echo $inq_contact_person; ?>">

                                <span id="error_inq_contact_person" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_email1" name="inq_email1" value="<?php echo $inq_email1; ?>">

                                <span id="error_inq_email1" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mobile No.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_mob1" name="inq_mob1" value="<?php echo $inq_mob1; ?>">

                                <span id="error_inq_mob1" style="color:red"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Landline No.</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_landline" name="inq_landline" value="<?php echo $inq_landline; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_turnky_sol_rmk" name="inq_turnky_sol_rmk" value="<?php echo $inq_turnky_sol_rmk; ?>">
                            </div>
                        </div>
                        <br/><br/>
                    </div>

                    <!-- Turnkey Inquiry -->
                    <button class="accordion" style="color:black; font-weight:bold;" type="button" onclick="accordian();">
                        <b>Turnkey Inquiry</b>
                    </button>
                    <div class="panel">
                        <br/><br/>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Plant Specification</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inq_plant_spec" name="inq_plant_spec" value="">
                            </div>

                            <label class="col-sm-2 control-label">Max Capacity</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="inq_max_cap" name="inq_max_cap" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Raw Material</label>
                            <div class="col-sm-4">
                                <input type="checkbox" id="wheat_atta" name="wheat_atta" value=" Wheat - Atta"> Wheat - Atta<br>
                                <input type="checkbox" id="wheat_daliya" name="wheat_daliya" value="Wheat - Daliya"> Wheat - Daliya<br>
                                <input type="checkbox" id="wheat_maida" name="wheat_maida" value="Wheat - Maida"> Wheat - Maida<br>
                                <input type="checkbox" id="spice_chilly" name="spice_chilly" value="Spice - Chilly"> Spice - Chilly<br>
                                <input type="checkbox" id="spice_turmeric" name="spice_turmeric" value="Spice - Turmeric"> Spice - Turmeric<br>
                                <input type="checkbox" id="spice_coriander" name="spice_coriander" value="Spice - Coriander"> Spice - Coriander<br>
                                <input type="checkbox" id="gram_besan" name="gram_besan" value="Gram - Besan"> Gram - Besan<br>
                            </div>

                            <label class="col-sm-2 control-label">Is Customisation Required</label>
                            <div class="col-sm-4">
                                <input type="radio" id="custom_req" name="custom_req" value="Yes">Yes
                                <input type="radio" id="custom_req" name="custom_req" value="No">No
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Remarks</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_tksol_rmks" name="inq_tksol_rmks" value="">
                            </div>
                        </div>
                        <br/><br/>
                    </div>
                    
                    <!--- Product Inquiry -->
                    <button class="accordion" style="color:black; font-weight:bold;" type="button" onclick="accordian();">
                        <b>Product Inquiry</b>
                    </button>
                    <div class="panel">
                        <br/><br/>
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8"><h3>Inquiry Item Details</b></h3></div>
                                </div>
                            </div>
                            <table class="table table-bordered" id="item_tbl">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Item Quantity</th>
                                        <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:left">
                                    <?php
                                    if($inq_no != ''){
                                        $sql_itm_list = "select * from crm_inq_itm_details where inq_no ='".$inq_no."'";
                                        $qry_itm_list = $this->db->query($sql_itm_list);

                                        $cnt = 0;
                                        foreach($qry_itm_list->result() as $row){
                                            $cnt++;
                                            $inq_itm_id = $row->inq_itm_id;
                                            $inq_itm_qty = $row->inq_itm_qty;

                                            $sql_itm_nm = "select * from item_mst where item_id = '".$inq_itm_id."'";
                                            $qry_itm_nm = $this->db->query($sql_itm_nm);

                                            $item_name;
                                            foreach($qry_itm_nm->result() as $row){
                                                $item_name = $row->item_name;
                                            }
                                    ?>
                                    <tr>
                                        <td>
                                            <?=$item_name;?>
                                            <input type="hidden" id="inq_itm_id" name="inq_itm_id[]" value="<?=$inq_itm_id;?>">
                                        </td>
                                        <td>
                                            <?=$inq_itm_qty;?>
                                            <input type="hidden" class="form-control" id="inq_itm_qty" name="inq_itm_qty[]" value="<?=$inq_itm_qty;?>" onkeypress="return isNumberKey(event);">
                                        </td>
                                        <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                                    </tr>
                                    <?php
                                        }    
                                    } else {
                                    ?>
                                    <tr>
                                        <td>
                                            <select id="inq_itm_id" name="inq_itm_id[]" class="form-control">
                                                <?php echo item_list(); ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="inq_itm_qty" name="inq_itm_qty[]" onkeypress="return isNumberKey(event);">
                                        </td>
                                        <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                                    </tr>
                                    <?php    
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Is Inquiry For Spares</label>
                            <div class="col-sm-2">
                                <select id="inq_spares" name="inq_spares" class="form-control">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-sm-8"></div>
                        </div>
                        <br/><br/>
                    </div>
                    
                    <!-- Lead Details -->
                    <button class="accordion" style="color:black; font-weight:bold;" type="button" onclick="accordian();">
                        <b>Lead Details</b>
                    </button>
                    <div class="panel">
                        <br/><br/> 
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lead Priority</label>
                            <div class="col-sm-2">
                                <select id="inq_lead_priority" name="inq_lead_priority" class="form-control">
                                    <option value="Hign">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-sm-8"></div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lead Remark</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="inq_lead_rmk" name="inq_lead_rmk" style="min-width: 100%; max-width: 100%">
                                    <?php echo $inq_lead_rmk; ?>
                                </textarea>
                            </div>
                        </div>
                        <br/><br/>
                    </div>
                    
                    <!-- Follow Up Details -->
                    <button class="accordion" style="color:black; font-weight:bold;" type="button" onclick="accordian();">
                        <b>Follow-Up Details</b>
                    </button>
                    <div class="panel">
                        <br/><br/>
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="col-sm-8"><h3>Conversation Details</b></h3></div>
                                </div>
                            </div>
                            <table class="table table-bordered" id="conv_tbl">
                                <thead>
                                    <tr>
                                        <th>Conversation Date</th>
                                        <th>Conversation</th>
                                        <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow_conv();"></span></th>
                                    </tr>
                                </thead>
                                <tbody style="text-align:left">
                                    <?php
                                    if($inq_no != ''){
                                        $sql_itm_list = "select * from crm_inq_conv where inq_no ='".$inq_no."'";
                                        $qry_itm_list = $this->db->query($sql_itm_list);

                                        $cnt = 0;
                                        foreach($qry_itm_list->result() as $row){
                                            $cnt++;
                                            $inq_conv_date = $row->inq_conv_date;
                                            $inq_conv = $row->inq_conv;
                                    ?>
                                    <tr>
                                        <td>
                                            <?=substr($inq_conv_date,0,11);?>
                                            <input type="hidden" id="inq_conv_date" name="inq_conv_date[]" value="<?=$inq_conv_date;?>">
                                        </td>
                                        <td>
                                            <?=$inq_conv;?>
                                            <input type="hidden" id="inq_last_conv" name="inq_last_conv[]" value="<?=$inq_conv;?>">
                                        </td>
                                        <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow_conv()"></span></td>
                                    </tr>
                                    <?php
                                        }    
                                    } else {
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="inq_conv_date" name="inq_conv_date[]" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="inq_last_conv" name="inq_last_conv[]" value="">
                                        </td>
                                        <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow_conv()"></span></td>
                                    </tr>
                                    <?php    
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">File Attachment</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="inq_file_att" name="inq_file_att" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Next Follow-Up Date</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inq_folup_date" name="inq_folup_date" value="<?php echo $inq_folup_date; ?>" readonly>

                                <span id="error_inq_folup_date" style="color:red"></span>
                            </div>
                        </div>
                        <br/><br/>
                    </div><br/><br/>
                    <!-- Accordian Ends -->
                    
                    <div class="form-group">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                        </div>
                        <div class="col-sm-2">
                            <input type="button" class="form-control" id="cancel" name="cancel" value="Cancel" onclick="myFunction()">
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                </form> 

                <div class="form-group">
                    <div class="col-sm-12">
                        <?php include("crm_conv_hist.php"); ?>
                    </div>
                </div> 
            </section>
        </div>
        <div class="col-lg-2"></div>
    </div>
  </section>
</section>

<script>
//validation function
function validateForm(){
	var inq_cust_nm = document.forms["InqForm"]["inq_cust_nm"].value;
	var inq_add_dist = document.forms["InqForm"]["inq_add_dist"].value;
	var inq_contact_person = document.forms["InqForm"]["inq_contact_person"].value;
	var inq_email1 = document.forms["InqForm"]["inq_email1"].value;
	var inq_mob1 = document.forms["InqForm"]["inq_mob1"].value;
	var inq_folup_date = document.forms["InqForm"]["inq_folup_date"].value;

	if (inq_cust_nm == "") {
        document.getElementById('error_inq_cust_nm').innerHTML = " Please Enter Company Name *";
        return false;
    }

    if (inq_add_dist == "") {
        document.getElementById('error_inq_add_dist').innerHTML = " Please Enter City Name *";
        return false;
    }

    if (inq_contact_person == "") {
        document.getElementById('error_inq_contact_person').innerHTML = " Please Enter Contact Person *";
        return false;
    }

    if (inq_email1 == "") {
        document.getElementById('error_inq_email1').innerHTML = " Please Enter Email *";
        return false;
    }

    if (inq_mob1 == "") {
        document.getElementById('error_inq_mob1').innerHTML = " Please Enter Mobile Number *";
        return false;
    }

    if (inq_folup_date == "") {
        document.getElementById('error_inq_folup_date').innerHTML = " Please Enter Follow Up Date *";
        return false;
    }

    return true;          
}
</script>

<script>
//$('#inq_rec_on').datepicker();
//$("#inq_rec_on").datepicker();
$( function() {
    $( "#inq_rec_on" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

$( function() {
    $( "#inq_conv_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

$( function() {
    $( "#inq_folup_date" ).datepicker({
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

<script>
//Item TAble
function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<select id="inq_itm_id" name="inq_itm_id[]" class="form-control"><?php echo item_list(); ?></select>';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" class="form-control" id="inq_itm_qty" name="inq_itm_qty[]" onkeypress="return isNumberKey(event);">';
	
	var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

//Converstion Table
function addrow_conv(){

   
    //$(".conv_date").datepicker("destroy"); 
   
	var table = document.getElementById('conv_tbl');
	
	var a =  document.getElementById('conv_tbl').rows.length;
    var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<input type="text" class="form-control conv_date" id="inq_conv_date'+rowCount+'" name="inq_conv_date[]">';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" class="form-control" id="inq_last_conv" name="inq_last_conv[]">';
	
	var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow_conv()"></span>';

    
    $("#inq_conv_date"+rowCount).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
}

function deleterow_conv(){	
	var table = document.getElementById('conv_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

</script>

<!-- According Javascript -->
<script type="text/javascript">
    function accordian(){
        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function(){
                this.classList.toggle("active");
                this.nextElementSibling.classList.toggle("show");
            }
        }
    }
	
</script>

<!--- Confirm Box -->
<script type="text/javascript">
    function myFunction() {
        var resp = confirm("Are you sure want to cancel yes or no");

        if(resp == true){
            location.href = "<?php echo base_url(); ?>index.php/crmc/inquiry_list";
        }
    }
</script>