<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Manpower Entry Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $mp_id = $_REQUEST['id'];
        if($mp_id != ''){
            foreach($get_mp_by_id->result() as $row){
                $mp_name = $row->mp_name;
                $mp_desc = $row->mp_desc;
                $mp_pan = $row->mp_pan;
                $mp_adhar = $row->mp_adhar;
            }
        } else {
                $mp_name = "";
                $mp_desc = "";
                $mp_pan = "";
                $mp_adhar = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Manpower Entry Form
            </header>
            <div class="panel-body">
            <?php
                if($mp_id != ''){
                    echo "<h2>Manpower Id - ".$mp_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/projectsc/proj_res_mp_entry">
                <?php
                    if($mp_id != ''){
                        echo "<input type='hidden' id='mp_id' name='mp_id' value='".$mp_id."'>";
                    } else {
                        echo "<input type='hidden' id='mp_id' name='mp_id' value=''>";
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Manpower Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pr_mp_name" name="pr_mp_name" 
                        value="<?php if($mp_id != ""){echo $mp_name; } else {echo ""; } ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Manpower Desc</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pr_mp_desc" name="pr_mp_desc" 
                        value="<?php if($mp_id != ""){echo $mp_desc; } else {echo ""; } ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Attach Pan Card</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="pr_mp_pan" name="pr_mp_pan" 
                        value="" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Attach Adhar Card</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control" id="pr_mp_adhar" name="pr_mp_adhar" 
                        value="" required>
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