<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Visit Assign Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
        $visit_id = $_REQUEST['id'];
        if($visit_id != ''){
            foreach($get_svr_by_id->result() as $row){
                $visit_inquiry_no = $row->visit_inquiry_no;
                $visit_place = $row->visit_place;
            }
        } else {
                $visit_inquiry_no = "";
                $visit_place = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Visit Assign Form
            </header>
            <div class="panel-body">
            <?php
                if($visit_id != ''){
                    echo "<h2>Visit Id - ".$visit_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/proj_svr_asg_entry">
                <?php
                    if($visit_id != ''){
                        echo "<input type='hidden' id='visit_id' name='visit_id' value='".$visit_id."'>";
                    } else {
                        echo "<input type='hidden' id='visit_id' name='visit_id' value=''>";
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Visit Inquiry No</label>
                    <div class="col-sm-10">
                        <select id="visit_inquiry_no" name="visit_inquiry_no" class="form-control" required>
                            <option value="">--select--</option>
                            <?php
                                if($visit_id != ''){
                            ?>
                            <option value="<?php echo $visit_inquiry_no; ?>" selected><?php echo $visit_inquiry_no; ?></option>
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
                    <label class="col-sm-2 control-label">Visit Place</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="visit_place" name="visit_place" 
                        value="<?php if($visit_id != ''){ echo $visit_place; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Visit Assign To</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="visit_asg_to" name="visit_asg_to" value="" required>
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