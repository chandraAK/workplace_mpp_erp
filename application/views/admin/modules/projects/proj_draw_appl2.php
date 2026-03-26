<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Drawing Creation Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
        $proj_id = $_REQUEST['id'];
        if($proj_id != ''){
            foreach($get_proj_by_id->result() as $row){
                $proj_name = $row->proj_name;
                $proj_draw_name = $row->proj_draw_name;
            }
        } else {
                $proj_name = "";
                $proj_draw_name = "";
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
                if($proj_id != ''){
                    echo "<h2>Proj Id - ".$proj_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/proj_draw_appl2_entry">
                <?php
                    if($proj_id != ''){
                        echo "<input type='hidden' id='proj_id' name='proj_id' value='".$proj_id."'>";
                    } else {
                        echo "<input type='hidden' id='proj_id' name='proj_id' value=''>";
                    }
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Project Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="proj_name" name="proj_name" 
                        value="<?php if($proj_id != ''){ echo $proj_name; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Drawing Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="proj_draw_name" name="proj_draw_name" 
                        value="<?php if($proj_id != ''){ echo $proj_draw_name; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Approval L2">
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