<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script></head>
<?php $db2 = $this->load->database('db2', TRUE);
$this->load->helper("dr"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Invoice Reports</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
<?php 
    $this->load-> helper('sales');
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
                        <th>Sales Order Number</th>                        
                        <th>SO Amount(Total)</th>
                        <th>Sales Person Name</th>
                        <th>Invoice Numbers</th>
                        <th>Invoiced Date</th>
                        <th>Invoiced Due Date</th><th>Invoiced Amount</th>                        
                        <th>Invoice Received Amount</th>
                        <th>Pending Amount</th>                       
                    </thead>    
                    <tbody>
                        <?php
                        $sql_inv_amt = "select * from `tabSales Invoice` where customer_name = '".$cust_name."'";
                         echo $sql_inv_amt;
                        $qry_inv_amt  = $db2->query($sql_inv_amt);                      
                       
                        /* $sql_sales_inv = "select a.*,b.* from tab_sales_invoice a inner join tab_sales_order b 
                        on a.customer_name=b.customer_name "; */
                        //echo $sql_sales_inv; die;
                        //$qry_sales_inv = $this->db->query($sql_sales_inv);
                        $sno = 0; 
                        $inv_total=0;
                        $inv_rec_total=0; 
                        $so_total = 0;                  
                        foreach($qry_inv_amt->result() as $row){
                            $sno++;
                            //$inv_no = $row->name;
                            //$inv_tot_amt = $row->rounded_total;
                            $inv_no = $row->name;
                            $rounded_total = $row->rounded_total;
                            $inv_total = $inv_total + $rounded_total;
                            $inv_date = $row->creation;
		                    $due_date = $row->due_date;
                            //$grand_total = $row->grand_total;                        
                            //$due_date = $row->due_date;
                            //$commitment_date = $row->commitment_date;
                            //$commitment_amt = $row->commitment_amt;
                            $sql_inv ="select sum(allocated_amount) as rec_amt from `tabPayment Entry Reference`
                             where reference_name = '".$inv_no."' and reference_doctype='Sales Invoice'";
                            $qry_inv = $db2->query($sql_inv)->row();
                            $inv_rec_amt = $qry_inv->rec_amt;
                            $inv_rec_total = $inv_rec_total + $inv_rec_amt;
                            //ISNULL(CAST(NULLIF($inv_rec_amt,0) AS INT), '');
                           //$inv_rec_amt = str_replace("","0",$inv_rec;);
                           
                            
                            $sql_so = "select sales_order from `tabSales Invoice Item`
                             where parent='".$inv_no."'";                    
                            $qry_so  = $db2->query($sql_so)->row();
                            //foreach($qry_so->result() as $row){
                            $so_id = $qry_so->sales_order;                     
                            
                            $sql_so_total = "select sales_person_name, sum(grand_total) as total from `tabSales Order` 
                            where name='".$so_id."'";
                            $qry_so_total = $db2->query($sql_so_total)->row();
                            $total = $qry_so_total->total;
                            $so_total = $so_total + $total;
                            $sales_pr = $qry_so_total->sales_person_name;

                            /* $sql_inv = "select sum(base_received_amount) as inv_rec_total from `tabPayment Entry`
                             where party_name='".$customer_name."' and payment_type = 'Receive'";
                            $qry_inv  = $db2->query($sql_inv)->row();
                            $inv_rec_total = $qry_inv->inv_rec_total;
                            $total_pend_amt = $inv_total - $inv_rec_total; */
                            
                            /* $sql_rec_amt ="select sum(total_allocated_amount) as tot_rec_amt from `tab_pay_entry` 
                            where title = '$customer_name'";
                            //echo $sql_rec_amt;die;
                            $qry_rec_amt = $this->db->query($sql_rec_amt)->row();
                            $tot_rec_amt = $qry_rec_amt->tot_rec_amt;
                            if($total_rec_amt == 0){
                                $tot_rec_amt = 0;
                            } */

                            $pending_amt = $rounded_total - $inv_rec_amt; 
                            $tot_pend_amt = $tot_pend_amt + $pending_amt;
                        ?>
                        <tr>
                            <td><?=$sno;?></td>
                            <td><?=$cust_code;?></td>
                            <td><?=$cust_name?></td>
                            <td><?=$so_id;?></td>                            
                            <td><?=number_format($total,2,".","");?></td>
                            <td><?=$sales_pr;?></td>
                            <td><?=$inv_no?></td>
                            <td><?=$inv_date?></td>
                            <td><?=$due_date?></td>
                            <td><?=number_format($rounded_total,2,".","");?></td>                            
                            <td><?=$inv_rec_amt;?></td> 
                            <td><?=$pending_amt;?></td>            
                                      
                        </tr>
                        <?php } ?>                        
                        <tr>
                        <td colspan ="4"><h5><b>Total</b></h5></td>                        
                        <td><b><?=$so_total?><b></td>
                        <td></td>                            
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b><?=$inv_total?></b></td>                        
                        <td><b><?=$inv_rec_total?></b></td>
                        <td><b><?=$tot_pend_amt;?></b></td>  
                           
                        </tr>
                    </tbody>
                </table>
                </section>
            </section>
