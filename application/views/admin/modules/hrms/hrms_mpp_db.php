<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $yes_date = date("Y-m-d",strtotime("-1 days")); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>HRMS MPP Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <!---- Mahaveer Poly Pack --->

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_card_mpp">Attendance Card MPP</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/monthly_att_rpt_mpp">Monthly Attendance Report MPP</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_sheet_daily_mpp">Salary Sheet Daily MPP</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_sheet_monthly_mpp">Salary Sheet Monthly MPP</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_adv_sheet_mpp">Salary Advance MPP</a>
                </div>
            </div>
        </div>

    </div>

  </section>
</section>