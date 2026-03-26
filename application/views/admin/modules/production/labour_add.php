<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Labour Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $labour_id = $_REQUEST['id'];
        if($labour_id != ''){
            foreach($get_by_id->result() as $row){
                $labour_name = $row->labour_name;
            }
        } else {
            $labour_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Labour Add Form
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/labour_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($labour_id != ''){
                        echo "<h2>labour Id - ".$labour_id."</h2>";
                ?>
                    <input type="hidden" id="labour_id" name="labour_id" value="<?=$labour_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="labour_id" name="labour_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Labour Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="labour_name" name="labour_name" 
                        value="<?php echo $labour_name; ?>" required>
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