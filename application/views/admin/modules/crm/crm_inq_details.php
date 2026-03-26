<?php
    $inq_no = $_REQUEST['id'];
    if($inq_no != ''){
        foreach($get_inq_by_id->result() as $row){
            $inq_rec_by = $row->inq_rec_by;
            $inq_rec_on = $row->inq_rec_on;
            $inq_source = $row->inq_source;
            $inq_cust_nm = $row->inq_cust_nm;
            $inq_cust_type = $row->inq_cust_type;
            $inq_add = $row->inq_add;
            $inq_add_dist = $row->inq_add_dist;
            $inq_add_state = $row->inq_add_state;
            $inq_add_pin = $row->inq_add_pin;
            $inq_folup_date = $row->inq_folup_date;
            $inq_status = $row->inq_status;
            $inq_contact_person = $row->inq_contact_person;
            $inq_email1 = $row->inq_email1;
            $inq_email2 = $row->inq_email2;
            $inq_mob1 = $row->inq_mob1;
            $inq_mob2 = $row->inq_mob2;
            $inq_landline = $row->inq_landline;
            $inq_turnky_sol = $row->inq_turnky_sol;
            $inq_turnky_sol_pkg = $row->inq_turnky_sol_pkg;
            $inq_turnky_sol_rmk = $row->inq_turnky_sol_rmk;
            $inq_spares = $row->inq_spares;
            $inq_lead_priority = $row->inq_lead_priority;
            $inq_lead_owner = $row->inq_lead_owner;
            $inq_lead_rmk = $row->inq_lead_rmk;
            $inq_last_conv = $row->inq_last_conv;
            $inq_file_att = $row->inq_file_att;
            $fst_lvl_quote = $row->fst_lvl_quote;
            $fst_lvl_quoteby = $row->fst_lvl_quoteby;
            $fst_lvl_quotedate = $row->fst_lvl_quotedate;
        }
    } else {
        $inq_rec_by = "";
        $inq_rec_on = "";
        $inq_source = "";
        $inq_cust_nm = "";
        $inq_cust_type = "";
        $inq_add = "";
        $inq_add_dist = "";
        $inq_add_state = "";
        $inq_add_pin = "";
        $inq_folup_date = "";
        $inq_status = "";
        $inq_contact_person = "";
        $inq_email1 = "";
        $inq_email2 = "";
        $inq_mob1 = "";
        $inq_mob2 = "";
        $inq_landline = "";
        $inq_turnky_sol = "";
        $inq_turnky_sol_pkg = "";
        $inq_turnky_sol_rmk = "";
        $inq_spares = "";
        $inq_lead_priority = "";
        $inq_lead_owner = "";
        $inq_lead_rmk = "";
        $inq_last_conv = "";
        $inq_file_att = "";
        $fst_lvl_quote = "";
        $fst_lvl_quoteby = "";
        $fst_lvl_quotedate = "";
    }
?>

<style>
    .div_style{
        font-size:14px;
    }
</style>

<!--hidden feilds-->
<input type="hidden" id="inq_no" name="inq_no" value="<?=$inq_no;?>">

<div class="row">
    <div class="col-lg-6" style="text-align:left"><h3>Inquiry No - <?=$inq_no; ?></h3></div>
    <div class="col-lg-6" style="text-align:right"><h3>Status - <?=$inq_status; ?></h3></div>
</div><br>

<div class="row" style="text-align:center">
    <div class="col-lg-12">
        <h3><u>Inquiry Details</u></h3>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" style="font-size:14px">
            <tr>
                <td><b>Inquiry Recorded by</b><br><?=$inq_rec_by;?></td>
                <td><b>Inquiry received on</b><br><?=$inq_rec_on;?></td>
                <td><b>Inquiry Source</b><br><?=$inq_source;?></td>
                <td><b>Customer Name</b><br><?=$inq_cust_nm;?></td>
                <td><b>Customer Type</b><br><?=$inq_cust_type;?></td>
                <td><b>Address</b><br><?=$inq_add;?></td>
            </tr>
            <tr>
                <td><b>City/District</b><br><?=$inq_add_dist;?></td>
                <td><b>State & Union Territory</b><br><?=$inq_add_state;?></td>
                <td><b>PIN Code</b><br><?=$inq_add_pin;?></td>
                <td><b>Next Follow-Up Date</b><br><?=$inq_folup_date;?></td>
                <td><b>Contact Person</b><br><?=$inq_contact_person;?></td>
                <td><b>Email 1</b><br><?=$inq_email1;?></td>
            </tr>
            <tr>
                <td><b>Email 2</b><br><?=$inq_email2;?></td>
                <td><b>Mobile No.1</b><br><?=$inq_mob1;?></td>
                <td><b>Mobile No.2</b><br><?=$inq_mob2;?></td>
                <td><b>Landline No.</b><br><?=$inq_landline;?></td>
                <td><b>Turnkey Solutions</b><br><?=$inq_turnky_sol;?></td>
                <td><b>Turnkey Solutions - Package Type</b><br><?=$inq_turnky_sol_pkg;?></td>
            </tr>
            <tr>
                <td><b>Remark For Product Or Turnkey Solution</b><br><?=$inq_turnky_sol_rmk;?></td>
                <td><b>Is Inquiry For Spares</b><br><?=$inq_spares;?></td>
                <td><b>Lead Priority</b><br><?=$inq_lead_priority;?></td>
                <td><b>Lead Owner</b><br><?=$inq_lead_owner;?></td>
                <td><b>Lead Remark</b><br><?=$inq_lead_rmk;?></td>
                <td><b>Last Conversation</b><br><?=$inq_last_conv;?></td>
            </tr>
            <tr>
                <td><b>File Attachment</b><br><?=$inq_file_att;?></td>
                <td colspan="5"></td>
            </tr>
        </table>
    </div>
</div>

<!--- Product Inquiry -->
<div class="row" style="text-align:center">
    <div class="col-lg-12"><h3>Inquiry Item Details</b></h3></div>
</div>

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <table class="table table-bordered" id="item_tbl">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Item Quantity</th>
                </tr>
            </thead>
            <tbody style="text-align:left">
                <?php
                
                    $sql_itm_list = "select * from crm_inq_itm_details where inq_no ='".$inq_no."'";
                    $qry_itm_list = $this->db->query($sql_itm_list);

                    $cnt = 0;
                    foreach($qry_itm_list->result() as $row){
                        $cnt++;
                        $inq_itm_id = $row->inq_itm_id;
                        $inq_itm_qty = $row->inq_itm_qty;

                        $sql_itm_nm = "select * from item_mst where item_id = '".$inq_itm_id."'";
                        $qry_itm_nm = $this->db->query($sql_itm_nm);

                        $item_name;
                        foreach($qry_itm_nm->result() as $row){
                            $item_name = $row->item_name;
                        }
                ?>
                <tr>
                    <td><?=$item_name;?></td>
                    <td><?=$inq_itm_qty;?></td>
                </tr>
                <?php  }  ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-2"></div>
</div><br><br>