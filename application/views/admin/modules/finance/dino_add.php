<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Dinomination</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $curr_id = $_REQUEST['id'];
        if($curr_id != ''){
            foreach($get_by_id->result() as $row){
                $curr_name = $row->curr_name;
            }
        } else {
            $dino_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Dinomination
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/financec/dino_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($curr_id != ''){
                        echo "<h2>Dinomination Id - ".$curr_id."</h2>";
                ?>
                    <input type="hidden" id="curr_id" name="curr_id" value="<?=$curr_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="curr_id" name="curr_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="curr_name" name="curr_name" 
                        value="<?php echo $curr_name; ?>" required>
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