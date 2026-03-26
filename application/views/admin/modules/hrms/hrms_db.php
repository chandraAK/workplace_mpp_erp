<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $yes_date = date("Y-m-d",strtotime("-1 days")); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>HRMS Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/hrms_pni_db">
                        PNI
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/hrms_mpp_db">
                        MPP
                    </a>
                </div>
            </div>
        </div>
    </div>

  </section>
</section>