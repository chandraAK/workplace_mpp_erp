<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Plate Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $plate_id = $_REQUEST['id'];
        if($plate_id != ''){
            foreach($get_by_id->result() as $row){
                $plate_name = $row->plate_name;
            }
        } else {
            $plate_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Plate Add Form
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/plate_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($plate_id != ''){
                        echo "<h2>Plate Id - ".$plate_id."</h2>";
                ?>
                    <input type="hidden" id="plate_id" name="plate_id" value="<?=$plate_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="plate_id" name="plate_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Plate Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="plate_name" name="plate_name" 
                        value="<?php echo $plate_name; ?>" required>
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