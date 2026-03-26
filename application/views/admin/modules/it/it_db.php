<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>IT Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/itc/ticket_reg_list">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Ticket List
            </a>
        </div>

    	<div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/itc/ticket_stages">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Ticket Stages
            </a>
        </div>
        
        <?php /*
        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/itc/ticket_review_rpt">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Ticket Review Report
            </a>
        </div>
        */ ?>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/itc/masters_db">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Masters
            </a>
        </div>
    </div>
    
  </section>
</section>

<script type="text/javascript">
  $(function () {
    $('#datepicker').datetimepicker({
        format: 'LT'
    });
  });
 </script>