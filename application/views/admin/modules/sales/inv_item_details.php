<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script></head>
<?php $db2 = $this->load->database('db2', TRUE);
$this->load->helper("dr"); ?>
<?php 
    $this->load-> helper('dr');
    $db2 = $this->load->database('db2', TRUE);  
    $cust_code =$_REQUEST['cust_id'];
    $inv_no =$_REQUEST['inv_no'];
    $sql_cust = "select customer_name from tabCustomer where name='".$cust_code."'";
    $qry_cust  = $db2->query($sql_cust)->row();
    $cust_name = $qry_cust->customer_name;
    
    //$cust_name = str_replace("'","",$cus_name);

?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Invoice Item Wise Reports</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
<?php 
    $this->load-> helper('dr');
    $db2 = $this->load->database('db2', TRUE);  
    $cust_code =$_REQUEST['cust_id'];
    $sql_cust = "select customer_name from tabCustomer where name='".$cust_code."'";
    $qry_cust  = $db2->query($sql_cust)->row();
    $cust_name = $qry_cust->customer_name;
    
    //$cust_name = str_replace("'","",$cus_name);

?>
    <table>
<table class="table table-bordered" id="example1" style="margin-top:60px">
                    <thead>
                        <th>SNO</th>
                        <th>Customer_ID</th>
                        <th>Customer_name</th>
                        <th>Invoice Number</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Total Amount</th>
                        <th>Total Outstanding Amount</th>
                    </thead>    
                    <tbody>
                <?php
                            $sql_inv = "select item_name,qty,rate,net_amount from `tabSales Invoice Item`
                            where parent = '".$inv_no."'";
                            $qry_inv  = $db2->query($sql_inv);
                            $sno=0;
                            foreach($qry_inv->result() as $row){
                                $sno++;                            
                                $item = $row->item_name;
                                $qty = $row->qty;
                                $rate = $row->rate;
                                $amount = $qty * $rate;
                            $sql_out_amt = "select outstanding_amount from `tabPayment Entry Reference` where reference_name ='".$inv_no."'";
                            $qry_out_amt = $db2->query($sql_out_amt)->row();
                            $out_amt = $qry_out_amt->outstanding_amount;

                        ?>
                       
                        <tr>
                            <td><?=$sno?></td>
                            <td><?=$cust_code?></td>
                            <td><?=$cust_name?></td>
                            <td><?=$inv_no?></td>
                            <td><?=$item?></td>
                            <td><?=$qty?></td>
                            <td><?=$rate?></td>
                            <td><?=number_format($amount,2,".","")?></td> 
                            <td><?=$out_amt;?></td>                                         
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <section>
            </section>
