<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Item Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $item_id = $_REQUEST['id'];
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
            Item Form
            </header>
            <div class="panel-body">
            <?php
                if($item_id != ''){
                    echo "<h2>Item Id - ".$item_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/proj_item_entry">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Item Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pr_item_name" name="pr_item_name" value="" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Item Desc</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pr_item_desc" name="pr_item_desc" value="" required>
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
//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>