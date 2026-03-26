<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Quotation Master</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $pqm_id = $_REQUEST['id'];
        if($pqm_id != ''){
            foreach($get_pqm_by_id->result() as $row){
                $pqm_name = $row->pqm_name;
                $pqm_attachment = $row->pqm_attachment;
            }
        } else {
                $pqm_name = "";
                $pqm_attachment = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Quotation Master Form
            </header>
            <div class="panel-body">
            <?php
                if($mp_id != ''){
                    echo "<h2>Manpower Id - ".$mp_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/projectsc/proj_res_pqm_entry">
                <?php
                    if($pqm_id != ''){
                        echo "<input type='hidden' id='pqm_id' name='pqm_id' value='".$mp_id."'>";
                    } else {
                        echo "<input type='hidden' id='pqm_id' name='pqm_id' value=''>";
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Quotation Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pqm_name" name="pqm_name" 
                        value="<?php if($pqm_id != ""){echo $pqm_name; } else {echo ""; } ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Attach Quotation</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="pqm_attachment" name="pqm_attachment" value="" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Attach File</label>
                    <div class="col-sm-10" style="text-align:left">
                        <a href="<?php echo base_url(); ?>uploads/<?php echo $pqm_attachment; ?>">
                            <?php echo $pqm_attachment; ?>
                        </a>
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