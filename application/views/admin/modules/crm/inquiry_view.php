<?php $this->load->helper("itemlist"); ?>

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
                $inq_cust_nm = $row->inq_cust_nm;
                $inq_cust_type = $row->inq_cust_type;
                $inq_add = $row->inq_add;
                $inq_add_dist = $row->inq_add_dist;
                $inq_add_state = $row->inq_add_state;
                $inq_add_pin = $row->inq_add_pin;
                $inq_folup_date = $row->inq_folup_date;

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
            $inq_file_att = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Inquiry View
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/crmc/inquiry_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($inq_no != ''){
                        echo "<h2>".$inq_no."</h2>";
                ?>
                    <input type="hidden" id="inq_no" name="inq_no" value="<?=$inq_no; ?>">
                <?php
                    } else {
                ?>
                    <input type="hidden" id="inq_no" name="inq_no" value="">
                <?php
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Recorded by</label>
                    <div class="col-sm-10"><?php echo $inq_rec_by; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry received on</label>
                    <div class="col-sm-10"><?php echo $inq_rec_on; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Source</label>
                    <div class="col-sm-10"><?php echo $source_name; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer Name</label>
                    <div class="col-sm-10"><?php echo $inq_cust_nm; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer Type</label>
                    <div class="col-sm-10"><?php echo $inq_cust_type; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-10"><?php echo $inq_add; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">City/District</label>
                    <div class="col-sm-10"><?php echo $inq_add_dist; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">State & Union Territory</label>
                    <div class="col-sm-10"><?php echo $inq_add_state; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">PIN Code</label>
                    <div class="col-sm-10"><?php echo $inq_add_pin; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Next Follow-Up Date</label>
                    <div class="col-sm-10"><?php echo $inq_folup_date; ?></div>
                </div>

                <!-- Point Of Contact -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Contact Person</label>
                    <div class="col-sm-10"><?php echo $inq_contact_person; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email 1</label>
                    <div class="col-sm-10"><?php echo $inq_email1; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email 2</label>
                    <div class="col-sm-10"><?php echo $inq_email2; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile No. 1</label>
                    <div class="col-sm-10"><?php echo $inq_mob1; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile No. 2</label>
                    <div class="col-sm-10"><?php echo $inq_mob2; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Landline No.</label>
                    <div class="col-sm-10"><?php echo $inq_landline; ?></div>
                </div>
                
                <!-- Inquiry Cont. -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Turnkey Solutions</label>
                    <div class="col-sm-10"><?php echo $inq_turnky_sol; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Turnkey Solutions - Package Type</label>
                    <div class="col-sm-10"><?php echo $inq_turnky_sol_pkg; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Remark For Product Or Turnkey Solution</label>
                    <div class="col-sm-10"><?php echo $inq_turnky_sol_rmk; ?></div>
                </div>
                
                <!--- Product Inquiry -->
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
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            
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
                                <td><?=$item_name;?></td>
                                <td><?=$inq_itm_qty;?></td>
                            </tr>
                            <?php  }  ?>
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

                <!-- Lead Details -->
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
                    <label class="col-sm-2 control-label">Lead Owner</label>
                    <div class="col-sm-10"><?php echo $inq_lead_owner; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Remark</label>
                    <div class="col-sm-10"><?php echo $inq_lead_rmk; ?></div>
                </div>
                
                <!-- Follow Up Details -->
                <div class="form-group">
                    <label class="col-sm-2 control-label">Last Conversation Record</label>
                    <div class="col-sm-10"><?php echo $inq_last_conv; ?></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">File Attachment</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="inq_file_att" name="inq_file_att" value="">
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-5"></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <h3>Conversations</h3>
                        <table class="table table-bordered" style="text-align:left">
                            <thead>
                                <tr>
                                    <th>SNO.</th>
                                    <th>Inquiry No.</th>
                                    <th>Converstion</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql_conv = "select * from crm_inq_conv where inq_no = '".$inq_no."'";
                                    $qry_conv = $this->db->query($sql_conv);

                                    $sno=0;
                                    foreach($qry_conv->result() as $row){
                                        $sno++;
                                        $inq_no = $row->inq_no;
                                        $inq_conv = $row->inq_conv;
                                        $inq_date = $row->inq_date;
                                ?>
                                <tr>
                                    <td><?=$sno;?></td>
                                    <td><?=$inq_no;?></td>
                                    <td><?=$inq_conv;?></td>
                                    <td><?=$inq_date;?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-1"></div>
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
function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<select id="inq_itm_id" name="inq_itm_id[]" class="form-control" required><?php echo item_list(); ?></select>';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" class="form-control" id="inq_itm_qty" name="inq_itm_qty[]" onkeypress="return isNumberKey(event);" required>';
	
	var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
</script>