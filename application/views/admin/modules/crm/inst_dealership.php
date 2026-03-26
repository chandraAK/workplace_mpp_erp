<?php $this->load->helper("itemlist"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Interested In Dealership</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <!--- Form Starts -->
    <form action="<?php echo base_url(); ?>index.php/crmc/inst_dealership_entry" method="post" enctype="multipart/form-data">
    
    <!--- CRM Inquiry Details --->
    <?php include("crm_inq_details.php"); ?>

    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-2"><b>Interested In Dealership Remarks</b></div>
        <div class="col-lg-4">
            <textarea id="inst_dealership_rmks" name="inst_dealership_rmks" class="form-control"></textarea>
        </div>
        <div class="col-lg-2"></div>
    </div><br><br>

    <!--- Change Status --->
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-1"><b>Change Status</b></div>
        <div class="col-lg-3">
            <select id="change_status" name="change_status" class="form-control" required>
                <option value="">--Select--</option>
                <?php
                    $sql_stages = "select * from crm_stage_mst order by stage_id";
                    $qry_stages = $this->db->query($sql_stages); 
                    foreach($qry_stages->result() as $row){
                        $stage = $row->stage_name;
                ?>
                    <option value="<?=$stage; ?>"><?=$stage; ?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-lg-4"></div>
    </div><br>

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