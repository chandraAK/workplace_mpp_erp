<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Sales Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-3">        	
             <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                <div class="title">
                <a href="<?php echo base_url(); ?>index.php/salesc/pt_summary" style="color:white";>
                    <div class="title">Payment Tracker Summary</div>
                    </a>
                 </div>
            </div>
         </a>
    </div>

        <div class="col-lg-3">        	
                <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px">
                 <div class="title">
                 <a href="<?php echo base_url(); ?>index.php/salesc/mm_app" style="color:white;">
                        <div class="title">Pending Approvals</div>
                    </a>
                </div>
            </div>
        </a>
    </div>

        <div class="col-lg-3">
        	<a href="<?php echo base_url(); ?>index.php/salesc/dr_pending_pay">
                <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                    <div class="title">
                     <a href="<?php echo base_url(); ?>index.php/salesc/dr_pending_pay" style="color:white">
                        <div class="title">Pending Payment Dashboard</div>
                    </a>
                   </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
        	<a href="<?php echo base_url(); ?>index.php/salesc/dr_pend_pay_filter">
                <div class="info-box blue-bg" style=" border-radius: 4px;width: 200px; height: 80px ">
                    <div class="title">
                        <a href="<?php echo base_url(); ?>index.php/salesc/dr_pend_pay_filter" style="color:white">
                            <div class="title">Pending Payment Reports</div>
                         </a>
                    </div>
                </div>       
            </a>
        </div>
    </div>
    
  </section>
</section>