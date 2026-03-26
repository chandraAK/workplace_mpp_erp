<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>CRM Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/crmc/inquiry_form?id=">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Add Inquiry
            </a>
        </div>

    	<div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/crmc/inquiry_list">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Inquiry List
            </a>
        </div>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/crmc/crm_flow">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                CRM Stages
            </a>
        </div>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/crmc/crm_flow_app">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                CRM Approval
            </a>
        </div>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/crmc">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Analytics
            </a>
        </div>
    </div>
    
  </section>
</section>