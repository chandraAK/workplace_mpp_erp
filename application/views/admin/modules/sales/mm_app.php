<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $this->load->helper("sales"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Management Appproval</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="col-lg-12"></div>
    </div><br><br>

    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/projectsc">
              SO Approvals
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->
        
      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="#" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/crmc">
            PO Approvals
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

    </div>
    <!--/.row-->
    
  </section>
</section>