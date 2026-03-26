<?php $this->load->helper("itemlist"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>PO Received</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <!--- Form Starts -->
    <form action="<?php echo base_url(); ?>index.php/crmc/po_received_entry" method="post" enctype="multipart/form-data">
    
    <!--- CRM Inquiry Details --->
    <?php include("crm_inq_details.php"); ?>

    <!--- Technical Discussion Remarks -->
    <div class="row">
        <div class="col-lg-2"><b>Purchase Order Attachment</b></div>
        <div class="col-lg-4"><input type="file" id="att_po" name="att_po" class="form-control" required></div>
        <div class="col-lg-2"><b>PO Received Remarks</b></div>
        <div class="col-lg-4"><textarea id="po_rec_rmks" name="po_rec_rmks" class="form-control"></textarea></div>
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