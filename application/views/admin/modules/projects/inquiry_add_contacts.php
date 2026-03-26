<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Inquiry Add Contacts</h3>
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
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Inquiry Form
            </header>
            <div class="panel-body">
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/inquiry_contact_entry">
                <?php
                    $username = $_SESSION['username'];
                    if($inq_no != ''){
                        echo "<h3>Enquiry No - ".$inq_no."</h3><br />";
                        echo "<input type='hidden' id='inq_no' name='inq_no' value='$inq_no'>";
                        echo "<input type='hidden' id='created_by' name='created_by' value='$username'>";
                    }
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Recorded by</label>
                    <div class="col-sm-10">
                        <?php echo $inq_rec_by; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry received on</label>
                    <div class="col-sm-10">
                        <?php echo $inq_rec_on; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Inquiry Source</label>
                    <div class="col-sm-10">
                        <?php echo $inq_source; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Company/Organisation</label>
                    <div class="col-sm-10">
                        <?php echo $inq_comp; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">New or Existing Customer</label>
                    <div class="col-sm-10">
                        <?php echo $inq_type; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer Type</label>
                    <div class="col-sm-10">
                        <?php echo $inq_cust_type; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Address Line 1</label>
                    <div class="col-sm-10">
                        <?php echo $inq_add_line1; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Address Line 2</label>
                    <div class="col-sm-10">
                        <?php echo $inq_add_line2; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">City/District</label>
                    <div class="col-sm-10">
                        <?php echo $inq_add_dist; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">PIN Code</label>
                    <div class="col-sm-10">
                        <?php echo $inq_add_pin; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">State & Union Territory</label>
                    <div class="col-sm-10">
                        <?php echo $inq_add_state; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Customer Name</label>
                    <div class="col-sm-10">
                        <?php echo $inq_cust_nm; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email Address - 1</label>
                    <div class="col-sm-10">
                        <?php echo $inq_cust_nm; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Email Address - 2</label>
                    <div class="col-sm-10">
                        <?php echo $inq_cust_nm; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number - 1</label>
                    <div class="col-sm-10">
                        <?php echo $inq_cust_mob1; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Mobile Number - 2</label>
                    <div class="col-sm-10">
                        <?php echo $inq_cust_mob2; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Landline Number</label>
                    <div class="col-sm-10">
                        <?php echo $inq_landline; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Turnkey Solutions</label>
                    <div class="col-sm-10">
                        <?php echo $inq_turnkey_sol; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Turnkey Solutions - Package Type</label>
                    <div class="col-sm-10">
                        <?php echo $inq_turnkey_package; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Remark for Product or Turnkey Solution</label>
                    <div class="col-sm-10">
                        <?php echo $inq_prod_rmk; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Priority</label>
                    <div class="col-sm-10">
                        <?php echo $inq_lead_prior; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Owner</label>
                    <div class="col-sm-10">
                        <?php echo $inq_lead_owner; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Lead Remark</label>
                    <div class="col-sm-10">
                        <?php echo $inq_lead_rmk; ?>
                    </div>
                </div>

                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h3>Add Contacts</b></h3></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Phone</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql_cnt_contacts = "select count(*) as cnt from inq_contacts where inquiry_id = '$inq_no'";
                                $qry_cnt_contacts = $this->db->query($sql_cnt_contacts)->row();
                                $cnt = $qry_cnt_contacts->cnt;

                                if($cnt <= 0){
                            ?>
                            <tr>
                                <td><input type="text" class="form-control" name="name[]" id="name" required></td>
                                <td><input type="text" class="form-control" name="dept[]" id="dept" required></td>
                                <td><input type="text" class="form-control" name="phone[]" id="phone" 
                                onkeypress="return isNumberKey(event);" required></td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                            </tr>
                            <?php
                                } else {
                            ?> 
                                <?php 
                                    foreach($get_inq_conby_id->result() as $row){
                                        $name = $row->name;
                                        $department = $row->department;
                                        $phone = $row->phone;
                                ?>
                                <tr>
                                    <td><input type="text" class="form-control" name="name[]" id="name" value="<?php echo $name; ?>" required></td>
                                    <td><input type="text" class="form-control" name="dept[]" id="dept" value="<?php echo $department; ?>" required></td>
                                    <td><input type="text" class="form-control" name="phone[]" id="phone" value="<?php echo $phone; ?>" 
                                    onkeypress="return isNumberKey(event);" required></td>
                                    <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                                </tr> 
                                <?php } ?>
                            <?php } ?>    
                        </tbody>
                    </table>
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
<script>

function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<input type="text" class="form-control" name="name[]" id="name" required>';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" class="form-control" name="dept[]" id="dept" required>';
	
	var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" class="form-control" name="phone[]" id="phone" value="" onkeypress="return isNumberKey(event);" required>';
	
	var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
</script>
