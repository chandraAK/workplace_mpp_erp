<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php $yes_date = date("Y-m-d",strtotime("-1 days")); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>HRMS PNI Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=present">
                        Total Present Yesterday <br><h2><?=att_count_tot("present", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=leaves">
                        Total On Leave Yesterday <br><h2><?=att_count_tot("leaves", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=emergency_leave">
                        Total Emergency Leave Yesterday <br><h2><?=att_count_tot("emergency_leave", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=half_day">
                        Total Half Day Yesterday <br><h2><?=att_count_tot("half_day", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=late_entry">
                        Total Late Entry Yesterday <br><h2><?=att_count_tot("late_entry", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=early_exit">
                        Total Early Exit Yesterday <br><h2><?=att_count_tot("early_exit", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_det_tot?status=mispunch">
                        Total Mispunch Yesterday <br><h2><?=att_count_tot("mispunch", $yes_date, $yes_date); ?></h2>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_card">Attendance Card</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/monthly_att_rpt">Monthly Attendance Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/monthly_mp_rpt">Monthly Mispunch Report</a>
                </div>
            </div>
        </div>
        
        <?php
            $username = $_SESSION['username'];
            if($username == 'chandra.sharma'){
        ?>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <div class="info-box green-bg">
                    <div class="title">
                        <a href="<?php echo base_url(); ?>index.php/hrmsc/att_calc">Attendance Calculate</a>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mispunch_script">Mispunch Script</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/early_exit_script">Early Exit Script</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/late_entry_script">Late Entry Script</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mail_script">Mail Script</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_log_report">Attendence Log Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_sheet_monthly">Salary Sheet(Type1)</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_sheet_daily">Salary Sheet(Type2)</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/penalty_type1">Penalties(Type1)</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/penalty_type2">Penalties(Type2)</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mp_stages">Miss Punch Application</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/gp_list">Gate Pass Application</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/leave_stages">Leave Application</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/ot_stages">Over Time Application</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_adv_rpt">Salary Advance</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/spcl_sal_adv_rpt">Special Salary Advance</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/penalty_stages">Penalties</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/adjustments_stages">Adjustments</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/fixed_ot_main">Fixed Overtime Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_adv_rpt">Salary Advance Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/spcl_sal_adv_rpt">Special Salary Advance Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pcpb_sal_adv_rpt">Paper Cup Advance Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pb_sal_adv_rpt">Paper Blank Advance Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/arrear_rpt_main">Arrear Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/ded_rpt_main">Deductions Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/dr_stages">DR Tour</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/dr_tour_rpt_main">DR Tour Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/hkcl_stages">Housekeeping DR</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pr_stages">Payment Request / Return</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pf_rpt_main">PF Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/esic_rpt_main">ESIC Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_app_main">Salary Approval</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/ledger_main">Ledger</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/counter_sheet_main">Counter Sheet</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/hkcl_rpt_main">HouseKeeping DR Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pc_cont_sal_main">Paper Cup Contact Salary</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pb_cont_sal_main">Paper Blank Contact Salary</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/pni_sal_main">PNI Counter Sheet(ON)</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mdpl_sal_main">MDPL Counter Sheet(ON)</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/emp_det_main">Employee Details</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/neg_sal_rpt_main">Negative Salary Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/lv_bal_rpt_main">Leave Balance Report</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mpp_prod_emp_rpt">MPP Prod. & Others Employees</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mpp_prod_sal_adv_rpt">MPP Prod. & Others Salary Adv</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mpp_prod_sal_add">MPP Prod. & Others Salary Entry</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/mpp_prod_sal_main">MPP Prod. & Others Salary Sheet</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/sal_slip_main">Salary Slip</a>
                </div>
            </div>
        </div>

        <!---- Regular Relaxation---->
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/reg_relax">Regular Relaxation</a>
                </div>
            </div>
        </div>

        <!---- Occassional Relaxation---->
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/occ_relax">Occassional Relaxation</a>
                </div>
            </div>
        </div>

        <?php /*
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_rpt_new">Attendance Report New</a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/att_pd_rpt">Paid Days Report</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box green-bg">
                <div class="title">
                    <a href="<?php echo base_url(); ?>index.php/hrmsc/tea_pay_main">Tea Payment Report</a>
                </div>
            </div>
        </div>
        */ ?>

    </div> 

  </section>
</section>