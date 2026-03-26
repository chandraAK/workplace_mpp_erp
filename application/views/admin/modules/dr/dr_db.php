<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>DR Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-3">
        <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                <div class="title">
                <a href="<?php echo base_url(); ?>index.php/drc/dr_list" style="color:white;">
                    <div class="title">CRM</div>
                    </a>
                 </div>
            </div>
        </div>
    	<div class="col-lg-3">
        <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                <div class="title">
                <a href="<?php echo base_url(); ?>index.php/drc/dr_list_it" style="color:white;">
                    <div class="title">IT</div>
                    </a>
                 </div>
            </div>
        </div>

        <div class="col-lg-3">
        <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                <div class="title">
                <a href="<?php echo base_url(); ?>index.php/drc/dr_list_design" style="color:white;">
                    <div class="title">DESIGN</div>
                    </a>
                 </div>
            </div>
        </div>
        <div class="col-lg-3">        	
            <div class="info-box blue-bg" style="border-radius: 4px;width: 200px; height: 80px ">
                <div class="title">
                <a href="<?php echo base_url(); ?>index.php/drc/dr_list_sales" style="color:white;">
                    <div class="title">SALES</div>
                    </a>
                 </div>
            </div>
        </div>
        <div class="col-lg-3">
        	 <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                <div class="title">
                <a href="<?php echo base_url(); ?>index.php/drc/dr_rpt_summary" style="color:white;">
                    <div class="title">REPORT</div>
                    </a>
                 </div>
            </div>
        </div>

    </div>
    
  </section>
</section>