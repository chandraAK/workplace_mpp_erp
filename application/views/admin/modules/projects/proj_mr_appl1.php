<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Material Request Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
        $mr_id = $_REQUEST['id'];
        if($mr_id != ''){
            foreach($get_mr_by_id->result() as $row){
                $mr_proj_id = $row->mr_proj_id;
            }
        } else {
                $mr_proj_id = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Media Requirements Form
            </header>
            <div class="panel-body">
            <?php
                if($mr_id != ''){
                    echo "<h2>MR Id - ".$mr_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/proj_mr_appl1_entry">
                <?php
                    if($mr_id != ''){
                        echo "<input type='hidden' id='mr_id' name='mr_id' value='".$mr_id."'>";
                    } else {
                        echo "<input type='hidden' id='mr_id' name='mr_id' value=''>";
                    }
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Project ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="mr_proj_id" name="mr_proj_id" 
                        value="<?php if($mr_id != ''){ echo $mr_proj_id; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Approve Material Request L1">
                    </div>
                    <div class="col-sm-4"></div>
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