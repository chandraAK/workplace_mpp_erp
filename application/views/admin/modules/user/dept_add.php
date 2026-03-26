<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Department Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $dept_id = $_REQUEST['id'];
        if($dept_id != ''){
            foreach($get_by_id->result() as $row){
                $dept_code = $row->dept_code;
                $dept_name = $row->dept_name;
            }
        } else {
            $dept_code = "";
            $dept_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Department Form
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/dbuserc/dept_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($dept_id != ''){
                        echo "<h2>Department Id - ".$dept_id."</h2>";
                ?>
                    <input type="hidden" id="dept_id" name="dept_id" value="<?=$dept_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="dept_id" name="dept_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Department Code</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dept_code" name="dept_code" 
                        value="<?php echo $dept_code; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Department Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dept_name" name="dept_name" 
                        value="<?php echo $dept_name; ?>" required>
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