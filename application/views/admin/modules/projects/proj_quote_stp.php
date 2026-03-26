<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Quote Send To Party</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
        $quote_id = $_REQUEST['id'];
        if($quote_id != ''){
            foreach($get_quote_by_id->result() as $row){
                $quote_inquiry_no = $row->quote_inquiry_no;
                $quote_rmks = $row->quote_rmks;
                $quote_stp_name = $row->quote_stp_name;
            }
        } else {
                $quote_inquiry_no = "";
                $quote_rmks = "";
                $quote_stp_name = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Quote Send To Party
            </header>
            <div class="panel-body">
            <?php
                if($quote_id != ''){
                    echo "<h2>Quote Id - ".$quote_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/proj_quote_stp_entry">
                <?php
                    if($quote_id != ''){
                        echo "<input type='hidden' id='quote_id' name='quote_id' value='".$quote_id."'>";
                    } else {
                        echo "<input type='hidden' id='quote_id' name='quote_id' value=''>";
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Quote Inquiry No</label>
                    <div class="col-sm-10">
                        <select id="quote_inquiry_no" name="quote_inquiry_no" class="form-control" required>
                            <option value="">--select--</option>
                            <?php
                                if($quote_id != ''){
                            ?>
                            <option value="<?php echo $quote_inquiry_no; ?>" selected><?php echo $quote_inquiry_no; ?></option>
                            <?php
                                }
                            ?>
                            <?php 
                                $sql_enq = "select inq_no from inq_mst"; 
                                $qry_enq = $this->db->query($sql_enq);
                                foreach($qry_enq->result() as $row){
                            ?>
                            <option value="<?php echo $row->inq_no; ?>"><?php echo $row->inq_no; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Quote Remarks</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="quote_rmks" name="quote_rmks" 
                        value="<?php if($quote_id != ''){ echo $quote_rmks; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Party Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="quote_stp_name" name="quote_stp_name" 
                        value="<?php if($quote_id != ''){ echo $quote_stp_name; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Send To Party">
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