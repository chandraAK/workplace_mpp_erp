<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Production Process Add</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $process_id = $_REQUEST['id'];
        if($process_id != ''){
            foreach($get_by_id->result() as $row){
                $process_name = $row->process_name;
            }
        } else {
            $process_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Production Process Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/prod_proc_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($process_id != ''){
                        echo "<h2>Process Id - ".$process_id."</h2>";
                ?>
                    <input type="hidden" id="process_id" name="process_id" value="<?=$process_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="process_id" name="process_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Process Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="process_name" name="process_name" 
                        value="<?php echo $process_name; ?>" required>
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