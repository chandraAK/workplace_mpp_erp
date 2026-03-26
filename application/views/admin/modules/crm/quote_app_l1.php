<?php $this->load->helper("itemlist"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Quotation Approval L1</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <!--- Form Starts -->
    <form action="<?php echo base_url(); ?>index.php/crmc/quote_app_l1_entry" method="post" enctype="multipart/form-data">
    
    <!--- CRM Inquiry Details --->
    <?php include("crm_inq_details.php"); ?>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-1"><b>Remarks</b></div>
        <div class="col-sm-2">
            <textarea id="app_rmks" name="app_rmks" class="form-control"></textarea>
        </div>
        <div class="col-sm-2">
            <input type="submit" class="form-control" id="quote_app_l1_inst" name="quote_app_l1_inst" value="Approve">
        </div>
        <div class="col-sm-2">
            <input type="submit" class="form-control" id="quote_app_l1_inst" name="quote_app_l1_inst" value="Disapprove">
        </div>
        <div class="col-sm-3"></div>
    </div>

    </form><br>
    <!--- Form Ends -->

    <?php include('crm_att_quote.php'); ?>
    <?php include('crm_conv_hist.php'); ?>

  </section>
</section>