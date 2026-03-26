<?php $this->load->helper("itemlist"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>First Level Quotation</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <!--- Form Starts -->
    <form action="<?php echo base_url(); ?>index.php/crmc/fst_lvl_entry" method="post" enctype="multipart/form-data">
    
    <!--- CRM Inquiry Details --->

    <?php include("crm_inq_details.php"); ?>

    <!--- First Level Quotation Attachment --->

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-1"><b>Attach Quotation</b></div>
        <div class="col-lg-3">
            <input type="file" id="att_quote" name="att_quote" class="form-control" required>
        </div>
        <div class="col-lg-4"></div>
    </div><br>

    <!--- Change Status --->
    
    <div class="row">
        <div class="col-sm-5"></div>
        <div class="col-sm-2">
            <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
        </div>
        <div class="col-sm-5"></div>
    </div>

    </form><br>
    <!--- Form Ends -->

    <?php include('crm_att_quote.php'); ?>
    <?php include('crm_conv_hist.php'); ?>
 
  </section>
</section>