<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Stone Type Add</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $task_id = $_REQUEST['id'];
        if($task_id != ''){
            foreach($get_by_id->result() as $row){
                $task_name = $row->task_name;
            }
        } else {
            $task_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Stone Type Add
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/stone_task_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($task_id != ''){
                        echo "<h2>Task Id - ".$task_id."</h2>";
                ?>
                    <input type="hidden" id="task_id" name="task_id" value="<?=$task_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="task_id" name="task_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Task Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="task_name" name="task_name" 
                        value="<?php echo $task_name; ?>" required>
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