<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Company Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $company_id = $_REQUEST['id'];
        if($company_id != ''){
            foreach($get_by_id->result() as $row){
                $company_name = $row->company_name;
            }
        } else {
            $company_name = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Company Form
            </header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/productionc/company_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($company_id != ''){
                        echo "<h2>Company Id - ".$company_id."</h2>";
                ?>
                    <input type="hidden" id="company_id" name="company_id" value="<?=$company_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="company_id" name="company_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Company Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="company_name" name="company_name" 
                        value="<?php echo $company_name; ?>" required>
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