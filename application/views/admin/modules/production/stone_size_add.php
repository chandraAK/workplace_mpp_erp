<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Stone Size Add</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $size_id = $_REQUEST['id'];
        if($size_id != ''){
            foreach($get_by_id->result() as $row){
                $size_name = $row->size_name;
            }
        } else {
            $size_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Stone Size Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/stone_size_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($size_id != ''){
                        echo "<h2>Stone Size Id - ".$size_id."</h2>";
                ?>
                    <input type="hidden" id="size_id" name="size_id" value="<?=$size_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="size_id" name="size_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Size Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="size_name" name="size_name" 
                        value="<?php echo $size_name; ?>" required>
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