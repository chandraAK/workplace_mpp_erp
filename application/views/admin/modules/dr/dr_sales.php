<?php 
$db2 = $this->load->database('db2', TRUE); 
$this->load->helper("dr");
?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Daily Report Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
    
	    $dr_id = $_REQUEST['id'];
        if($dr_id != ''){
            foreach($get_dr_by_id->result() as $row){
                $dr_date = $row->dr_date;
                $dr_id = $row->dr_id;
            }
        } else {
            $dr_date = "";
            $dr_id  = "";
        }
    ?>
    <?php
     $sql="select * from `tabCustomer`";
    $query = $db2->query($sql);
    foreach($query->result() as $row){
        $cust_id = $row->cust_id;
        $cust_name = $row->customer_name;
        $customer_name = str_replace("'","",$cust_name);
    
        $sql1 = "select count(name) as count from `tabCustomer` where customer_name = '".$customer_name."'";
        $query1 = $db2->query($sql);
        foreach($query->result() as $row){
            $count = $row->count;
        }
       if($count<0){
        $sql_insert = "insert into erp_cust_name(cust_id,customer_name)values
        ('".$cust_id."','".$customer_name."')";
        $query_insert = $this->db->query($sql_insert);
    } 
}

 
    ?> 
    <?php
     $sql="select * from `tabSales Invoice`";
    $query = $db2->query($sql);
    foreach($query->result() as $row){
        $cont_person = $row->cont_person;
        $inv_id = $row->inv_id;
        $cont_person = str_replace("'","",$cont_person);
    
        $sql1 = "select count(inv_id) as count from `tabSales Invoice` where cont_person = '".$cont_person."'";
        $query1 = $db2->query($sql);
        foreach($query->result() as $row){
            $count = $row->count;
        }
       if($count<0){
        $sql_insert = "insert into erp_sales_inv(inv_id,cont_person)values
        ('".$inv_id."','".$cont_person."')";
        $query_insert = $this->db->query($sql_insert);
    } 
} 

 
    ?> 

    
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading" style="font-size:18px"><b>
                Daily Report Form</b>
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/drc/dr_entry_sales">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($dr_id != ''){
                        echo "<h4>DR No-".$dr_id."</h4>";
                ?>
                    <input type="hidden" id="dr_id" name="dr_id" value="<?=$dr_id; ?>">
                <?php
                    } else {
                ?>
                    <input type="hidden" id="dr_id" name="dr_id" value="">
                <?php
                    }
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">DR Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dr_date" name="dr_date" value="<?php echo $dr_date; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">DR Created By</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dr_name" name="dr_name" value="<?php if($dr_created_by == ""){ echo $_SESSION['username']; } else { echo $dr_created_by; }; ?>" readonly>
                    </div>
                </div>

                <!--- Added by Charu 202010291235 -->
                  <?php
                    
                
                ?>
                
                <!--- dispatch summary -->
                    
                    <table class="table table-bordered" id="item_tbl">
                        <tr style="background-color:#ddd">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Dispatch Summary</b></h5></div>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_disp_sum where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $dr_disp_party = $row->dr_disp_party;
                                $dr_disp_product= $row->dr_disp_product;
                                $dr_quantity= $row->dr_quantity;
                                $dr_disp_amount = $row->dr_disp_amount;
		                 ?>
                        <tr>
                             <td><input type="text" id="dr_disp_party" name="dr_disp_party[]" value="<?=$dr_disp_party;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_disp_product" name="dr_disp_product[]" value="<?=$dr_disp_product;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_quantity" name="dr_quantity[]" value="<?=$dr_quantity;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_disp_amount" name="dr_disp_amount[]" value="<?=$dr_disp_amount;?>" class="form-control" required></td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>  
                         </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                        <tr>
                             <td><input type="text" id="dr_disp_party" name="dr_disp_party[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_disp_product" name="dr_disp_product[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_quantity" name="dr_quantity[]" value="" class="form-control"  onkeypress="return isNumberKey(event);" required></td>
                            <td><input type="text" id="dr_disp_amount" name="dr_disp_amount[]" value="" class="form-control" required></td>  
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                         </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                    <!---payment follow up-->
                    <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Payment Follow Up</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl1">
                        <tr style="background-color:#ddd">
                            <th>Customer</th>
                            <th>Invoice No</th>
                            <th>Amount</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow1();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_pay_foll_up where dr_id='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $dr_foll_up_party =$row->dr_foll_up_party;
                                $dr_foll_up_invoice_no = $row->dr_foll_up_invoice_no;
                                $dr_foll_up_amount =$row->dr_foll_up_amount;
		                 ?>
                        <tr>
                            <td> <select  id="cust_name" name="dr_foll_up_party[]" value="<?=$dr_foll_up_party;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_foll_up_invoice_no" name="dr_foll_up_invoice_no[]" value="<?=$dr_foll_up_invoice_no;?>" class="form-control" required></td>
                            <td> <input type="text" id="dr_foll_up_amount" name="dr_foll_up_amount[]" value="<?=$dr_foll_up_amount;?>" class="form-control" required></td>
                             <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                            </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                         <tr>
                         <td> <input type="text" id="dr_foll_up_party" name="dr_foll_up_party[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_foll_up_invoice_no" name="dr_foll_up_invoice_no[]" value="" class="form-control" required></td>
                            <td> <input type="text" id="dr_foll_up_amount" name="dr_foll_up_amount[]" value="" class="form-control" required></td>
                             <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                            </tr>
                        <?php    
                        }*/
                        ?> 
                    </table>
                
            
                <!--payment recieved-->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Payment Recieved</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl2">
                        <tr style="background-color:#ddd">
                            <th>Invoice No</th>
                            <th>Amount Recieved</th>
                            <th>Amount Pending</th>
                            <th>Next Follow Up Date</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow2();"></span></th>
                    
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_pay_recv where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $dr_pay_invoice_no = $row->dr_pay_invoice_no;
                                $dr_amt_recv = $row->dr_amt_recv;
                                $dr_amt_pend = $row->dr_amt_pend;
                                $dr_next_foll_up_date = $row->dr_next_foll_up_date;
		                 ?>
                        <tr>
                            <td> <input type="text" id="dr_pay_invoice_no" name="dr_pay_invoice_no[]" value="<?= $dr_pay_invoice_no;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_amount_recv" name="dr_amt_recv[]" value="<?= $dr_amt_recv;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_amount_pend" name="dr_amt_pend[]" value="<?= $dr_amt_pend;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_next_foll_up_date" name="dr_next_foll_up_date[]" value="<?= $dr_next_foll_up_date;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow2()"></span></td>
                            </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                        <tr>
                            <td> <input type="text" id="dr_pay_invoice_no" name="dr_pay_invoice_no[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_amount_recv" name="dr_amt_recv[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_amount_pend" name="dr_amt_pend[]" value="" class="form-control" required></td>
                            <td><input type="text" id="foll_up_date" name="dr_next_foll_up_date[]" value="" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow2()"></span></td>
                            </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                
                <!--party visit-->
                 <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Party Visit</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl3">
                        <tr style="background-color:#ddd">
                            <th>Party Name</th>
                            <th>Product</th>
                            <th>Lead source</th>
                            <th>Remarks</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow3();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_part_visit where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $dr_part_name =$row->dr_part_name;
                                $dr_part_product = $row->dr_part_product;
                                $dr_part_lead_source = $row->dr_part_lead_src;
                                $dr_part_remarks = $row->dr_part_remarks;
                                
		                 ?>
                        <tr>
                            <td> <input type="text" id="dr_part_name" name="dr_part_name[]" value="<?=$dr_part_name;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_part_product" name="dr_part_product[]" value="<?=$dr_part_product;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_part_lead_source" name="dr_part_lead_src[]" value="<?=$dr_part_lead_source;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_part_remarks" name="dr_part_remarks[]" value="<?=$dr_part_remarks;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                            </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                        <tr>
                        <td> <input type="text" id="dr_part_name" name="dr_part_name[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_part_product" name="dr_part_product[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_part_lead_source" name="dr_part_lead_src[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_part_remarks" name="dr_part_remarks[]" value="" class="form-control" required></td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                        </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                
               
                    <!--- customer visits-->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Customer Visit</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl4">
                        <tr style="background-color:#ddd">
                            <th>Customer Name</th>
                            <th>Product</th>
                            <th>Customer Lead Source</th>
                            <th>Customer Type</th>
                            <th>Remarks</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow4();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_cust_visit where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $dr_cust_name =$row->dr_cust_name;
                                $dr_cust_product = $row->dr_cust_product;
                                $dr_cust_lead_src = $row->dr_cust_lead_src;
                                $dr_cust_type = $row->dr_cust_type;
                                $dr_cust_remarks = $row->dr_cust_remarks;
                                
		                 ?>
                        <tr>
                            <td><input type="text" id="dr_cust_name" name="dr_cust_name[]" class="form-control" value = "<?=$dr_cust_name;?>" ></td> 
                            <td><input type="text" id="dr_cust_product" name="dr_cust_product[]" value="<?=$dr_part_product;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_cust_lead_source" name="dr_cust_lead_src[]" value="<?=$dr_part_lead_source;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_cust_type" name="dr_cust_type[]" value="<?=$dr_cust_type;?>" class="form-control" required></td>
                            <td><input type="text" id="dr_cust_remarks" name="dr_cust_remarks[]" value="<?=$dr_part_remarks;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow4()"></span></td>
                            </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                        <tr>
                        <td> <input type="text" id="dr_cust_name" name="dr_cust_name[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_cust_product" name="dr_cust_product[]" value="" class="form-control" required></td>
                            <td><input type="text" id="dr_cust_lead_source" name="dr_cust_lead_src[]" value="" class="form-control" required></td>
                            <td><select id="dr_cust_type" name="dr_cust_type[]" class="form-control" required>
                            <option value="">--select--</option>
                            <option value="old">old</option>
                            <option value="new">new</option></select></td>
                            <td><input type="text" id="dr_cust_remarks" name="dr_cust_remarks[]" value="" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow4()"></span></td>
                        </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                
                <!---Meetings -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                        <div class="col-sm-12" style="text-align:left;"><h5><b>Meetings</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl5">
                        <tr style="background-color:#ddd">
                            <th>Customer Name</th>
                            <th>From Time</th>
                            <th>To Time</th>
                            <th>Agenda</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow5();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql3 = "select * from dr_off_meet where dr_id ='".$dr_id."'";
                            $qry3= $this->db->query($sql3);

                            $cnt = 0;
                            foreach($qry3->result() as $row){
                                $cnt++;
                                $dr_meet_name =$row->dr_meet_name;
		                        $dr_frm_time = $row->dr_from_time;
		                        $dr_to_time= $row->dr_to_time;
		                        $dr_meet_agenda= $row->dr_meet_agenda;
                         ?>
                            <tr>
                                <td><input type="text" id="dr_meet_name" name="dr_meet_name[]" value="<?=$dr_meet_name;?>" class="form-control" required></td>
                                <td><input type="text" id="frm_time1" name="dr_frm_time[]" value="<?=$dr_frm_time;?>" class="form-control frm_time" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="to_time1" name="dr_to_time[]" value="<?=$dr_to_time;?>" class="form-control to_time"  required onkeypress="alerttime()"></td>
                               <td> <input type="text" id="dr_meet_agenda" name="dr_meet_agenda[]" value="<?=$dr_meet_agenda;?>" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow5()"></span></td>
                        </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                         <tr>
                         <td><input type="text" id="dr_meet_name" name="dr_meet_name[]" value="" class="form-control" required></td>
                                <td><input type="text" id="frm_time1" name="dr_frm_time[]" value="" class="form-control frm_time" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="to_time1" name="dr_to_time[]" value="" class="form-control to_time" required></td>
                               <td> <input type="text" id="dr_meet_agenda" name="dr_meet_agenda[]" value="" class="form-control" required> </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow5()"></span></td>
                        </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                </div>
                <!-- customer interaction-->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                        <div class="col-sm-12" style="text-align:left;"><h5><b>Customer Interaction</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl6">
                        <tr style="background-color:#ddd">
                            <th>Customer Name</th>
                            <th>Contact Person</th>
                            <th>Contact Number</th>
                            <th>E-mail</th>
                            <th>Agenda</th>
                            <th>Remarks</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow6();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql3 = "select * from dr_sales_cust_int where dr_id ='".$dr_id."'";
                            $qry3= $this->db->query($sql3);

                            $cnt = 0;
                            foreach($qry3->result() as $row){
                                $cnt++;
                                $dr_part_int_name =$row->dr_part_int_name;
		                        $dr_cont_person = $row->dr_cont_person;
		                        $dr_cont_no= $row->dr_cont_no;
                                $dr_email= $row->dr_email;
                                $dr_cust_int_agenda = $row->dr_cust_int_agenda;
		                        $dr_cust_int_remarks = $row->dr_cust_int_remarks;
		        

                        ?>
                        <tr>
                            <td><input type="text" id="dr_party_name" name="dr_part_int_name[]" value="<?=$dr_part_int_name;?>" class="form-control" required></td>
                                <td><input type="text" id="dr_cont_person" name="dr_cont_person[]" value="<?=$dr_cont_person;?>" class="form-control" required></td>
                                <td><input type="text" id="dr_cont_no" name="dr_cont_no[]" value="<?=$dr_cont_no;?>" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="dr_email" name="dr_email[]" value="<?=$dr_email;?>" class="form-control" required></td>
                                <td><input type="text" id="dr_cust_int_agenda" name="dr_cust_int_agenda[]" value="<?=$dr_cust_int_agenda;?>" class="form-control" required></td>
                               <td> <input type="text" id="dr_cust_int_remarks" name="dr_cust_int_remarks[]" value="<?=$dr_cust_int_remarks;?>" class="form-control" required> </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow6()"></span></td>
                        </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                        <tr>
                        <td><input type="text" id="dr_party_name" name="dr_part_int_name[]" value="" class="form-control" required></td>
                                <td><input type="text" id="dr_cont_person" name="dr_cont_person[]" value="" class="form-control" required></td>
                                <td><input type="text" id="dr_cont_no" name="dr_cont_no[]" value="" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="dr_email" name="dr_email[]" value="" class="form-control" required></td>
                                <td><input type="text" id="dr_cust_int_agenda" name="dr_cust_int_agenda[]" value="" class="form-control" required></td>
                               <td> <input type="text" id="dr_cust_int_remarks" name="dr_cust_int_remarks[]" value="" class="form-control" required> </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow6()"></span></td> </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                </div>
                
                 <!--Other Tasks -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Other Tasks</b></h5></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl7" style="text-align:left">
                        <tr style="background-color:#ddd">
                            <th>Particulars</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow7();"></span></th>
                        </tr>
                        <?php
                        
                        if($dr_id != ''){
                            $sql_itm_list = "select * from dr_sales_details where dr_id ='".$dr_id."'";
                            $qry_itm_list = $this->db->query($sql_itm_list);

                            $cnt = 0;
                            foreach($qry_itm_list->result() as $row){
                                $cnt++;
                                $dr_details = $row->dr_sales_details;
                        ?>
                        <tr>
                            <td>
                                <input type="text" id="dr_sales_details" name="dr_sales_details[]" value="<?=$dr_details;?>" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow7()"></span></td>
                            </tr>
                        <?php
                            }    
                        } /* else {
                        ?>
                        <tr>
                            <td>
                                <input type="text" id="dr_sales_details" name="dr_sales_details[]" value="" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow7()"></span></td>
                            </tr>
                        <?php    
                        } */
                        ?>
                    </table>
                </div>
                
                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-5"></div>
                </div>

            </form>
            </div>
            <div class="col-lg-2"></div>
        </section>
        </div>
    </div>
  </section>
</section>

<script>
$( function() {
    $( "#dr_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
$( function() {
    $( "#foll_up_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
function alerttime(){
var startTime = $('#frm_time1').val();   
    var endTime   = $('#to_time1').val();    
    if (startTime > endTime) 
    {
        alert('To time  always be greater then from time.');
    }
}

$(function() {
    $('#frm_time1').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        minTime: '10',
        maxTime: '6:00pm',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});

$(function() {
    $('#to_time1').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        minTime: '10',
        maxTime: '6:00pm',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});
/*$(function () {
    $('#to_tim').datetimepicker({
        format: 'LT'
    });
}); 

/* $( function() {
    $( "#frm_tim" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
$( function() {
    $( "#to_tim" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
 */
//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>
<script>

function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<select id="dr_disp_party" name="dr_disp_party[]" value="" class="form-control" required><option value="select">--select---</option><?php echo customer_name();?><select>'
    var newCell1 = row.insertCell(1);
    newCell1.innerHTML =  '<select  id="dr_disp_product" name="dr_disp_product[]" value="" class="form-control"><option value="select">--select---</option><?php echo prod_name();?><select>'
    var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<input type="text" id="dr_quantity" name="dr_quantity[]" value="" class="form-control"  onkeypress = "return isNumberKey(event);" >'
     var newCell1 = row.insertCell(3);
     newCell1.innerHTML  = '<input type="text" id="dr_disp_amount" name="dr_disp_amount[]" value="" class="form-control" onkeypress="return isNumberKey(event);">'
     var newCell1 = row.insertCell(4);
     newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>'  

}
</script>
<script>

function addrow1(){
	
	var table = document.getElementById('item_tbl1');
	
	var a =  document.getElementById('item_tbl1').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<input type="text" id="dr_party" name="dr_foll_up_party[]" value="" class="form-control" >'
    var newCell1 = row.insertCell(1);
    newCell1.innerHTML =  '<input type="text" id="dr_foll_up_invoice_no" name="dr_foll_up_invoice_no[]" value="" class="form-control">'
    var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<input type="text" id="dr_foll_up_amount" name="dr_foll_up_amount[]" value="" class="form-control" onkeypress="return isNumberKey(event);">'
     var newCell1 = row.insertCell(3);
     newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span>'  

}
</script>
<script>
  function addrow2(){
	
	var table = document.getElementById('item_tbl2');
	
	var a =  document.getElementById('item_tbl2').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
    var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<input type="text" id="dr_party" name="dr_pay_invoice_no[]" value="" class="form-control">'
    var newCell1 = row.insertCell(1);
    newCell1.innerHTML =  '<input type="text" id="dr_product" name="dr_amt_recv[]" value="" class="form-control" onkeypress="return isNumberKey(event);" >'
    var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<input type="text" id="dr_quantity" name="dr_amt_pend[]" value="" class="form-control" onkeypress="return isNumberKey(event);">'
     var newCell1 = row.insertCell(3);
     newCell1.innerHTML  = '<input type="text" id="dr_amount" name="dr_next_foll_up_date[]" value="" class="form-control dr_date" >'
     var newCell1 = row.insertCell(4);
     newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow2()"></span>'  

     $( function() {
    $( ".dr_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
    
 }
 /* $(document).ready( function(){
    $('#to_tim').datetimepicker({
        format: 'LT'
    });
 }); */

</script>
<script>

function addrow3(){
	
	var table = document.getElementById('item_tbl3');
	
	var a =  document.getElementById('item_tbl3').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<select  id="party_nm" name="dr_part_name[]" value="" class="form-control"><option value="select">---select---</option><?php echo customer_name();?></select>';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<select id="dr_part_product" name="dr_part_product[]" value="" class="form-control"><option value="select">---select---</option><?php echo prod_name();?></select>';
    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="dr_part_lead_src" name="dr_part_lead_src[]" value=""  class="form-control" >';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="dr_part_remarks" name="dr_part_remarks[]" value="" class="form-control">';
	var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span>';
}
</script>
<script>
  function addrow4(){
	var table = document.getElementById('item_tbl4');
	
	var a =  document.getElementById('item_tbl4').rows.length;
	var rowCount = a-1;

    //alert(a); return false;
	
	var row = table.insertRow(a);
	
    var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<select id="dr_cust_name" name="dr_cust_name[]" class="form-control"><option value="select">---select---</option><?php echo customer_name();?></select>';
    var newCell1 = row.insertCell(1);
    newCell1.innerHTML =  '<input type="text" id="dr_cust_product" name="dr_cust_product[]" value="" class="form-control">';
    var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<input type="text" id="dr_cust_lead_source" name="dr_cust_lead_src[]" value="" class="form-control" required>';
    var newCell1 = row.insertCell(3);
    newCell1.innerHTML  = '<select id="dr_cust_type" name="dr_cust_type[]" class="form-control"> <option value="">--select--</option><option value="old">old</option><option value="new">new</option></select>';
    var newCell1 = row.insertCell(4);
    newCell1.innerHTML  = '<input type="text" id="dr_cust_remarks" name="dr_cust_remarks[]" value="" class="form-control" required>';
    var newCell1 = row.insertCell(5);
    newCell1.innerHTML = '';  
}
 </script>

<script>

function addrow5(){
	
	var table = document.getElementById('item_tbl5');
	
	var a =  document.getElementById('item_tbl5').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<input type="text" id="meet_name" name="dr_meet_name[]" value="" class="form-control">';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="frm_time'+rowCount+'" name="dr_frm_time[]" value="" class="form-control from_time">';
    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="to_time'+rowCount+'" name="dr_to_time[]" value=""  class="form-control to_time">';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="dr_meet_agenda" name="dr_meet_agenda[]" value="" class="form-control" onclick=alerttime()>';
	var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow5()"></span>';
    $(function() {
    $('.from_time').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        minTime: '10',
        maxTime: '6:00pm',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});

$(function() {
    $('.to_time').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        minTime: '10',
        maxTime: '6:00pm',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});
function alerttime(){

var timefrom = new Date();
temp = $('#frmtime').val().split(":");
timefrom.setHours((parseInt(temp[0]) - 1 + 24) % 24);
timefrom.setMinutes(parseInt(temp[1]));

var timeto = new Date();
temp = $('#totime').val().split(":");
timeto.setHours((parseInt(temp[0]) - 1 + 24) % 24);
timeto.setMinutes(parseInt(temp[1]));

if (timeto < timefrom){
    alert('start time should be smaller than end time!');
}
}

}
</script>
<script>

function addrow6(){
	
	var table = document.getElementById('item_tbl6');
	
	var a =  document.getElementById('item_tbl6').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<input type="text" id="dr_part_name" name="dr_part_int_name[]" value="" class="form-control">';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="dr_cont_person" name="dr_cont_person[]" value="" class="form-control">';
    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="dr_cont_no" name="dr_cont_no[]" value="" onkeypress="return isNumberKey(event);" class="form-control" >';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="dr_email" name="dr_email[]" value=""  class="form-control" >';
    var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<input type="text" id="dr_cust_int_agenda" name="dr_cust_int_agenda[]" value="" class="form-control">';
    var newCell1 = row.insertCell(5);
	newCell1.innerHTML = '<input type="text" id="dr_cust_int_remarks" name="dr_cust_int_remarks[]" value="" class="form-control">';
	
	var newCell1 = row.insertCell(6);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow6()"></span>';
}
</script>
<script>

function addrow7(){
	
	var table = document.getElementById('item_tbl7');
	
	var a =  document.getElementById('item_tbl7').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<input type="text" id="dr_sales_details" name="dr_sales_details[]" value="" class="form-control">';
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow7()"></span>';
}
</script>
<script>

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

function deleterow1(){	
	var table = document.getElementById('item_tbl1');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

function deleterow2(){
	var table = document.getElementById('item_tbl2');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

function deleterow3(){
	var table = document.getElementById('item_tbl3');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
function deleterow4(){
	var table = document.getElementById('item_tbl4');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
function deleterow5(){
	var table = document.getElementById('item_tbl5');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
function deleterow6(){
	var table = document.getElementById('item_tbl6');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
function deleterow7(){
	var table = document.getElementById('item_tbl7');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

$(function() {
$('.datepicker').datepicker({ format : 'dd-mm-yyyy', weekStart: 1 });
});

</script>

//Restricting Only to insert Numbers
<script>
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>
<script type="text/javascript">

    $(document).ready(function() {
        $('select[name="cust_name"]').on('change', function() {
            var custId = $(this).val();
            if(custId) {
                $.ajax({
                    url: 'dependent-dropdown/ajax/'+custId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="invoice"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="invoice"]').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="invoice"]').empty();
            }
        });
    });
</script>