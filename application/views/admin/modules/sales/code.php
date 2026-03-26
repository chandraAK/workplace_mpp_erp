<table class="table table-bordered" id="example1" style="margin-top:60px">
                    <thead>
                        <th>SNO</th>
                        <th>Customer Code</th>
                        <th>Customer Name</th>
                        <th>SO Amount(Total)</th>
                        <th>Invoice Amount(Total)</th>
                        <th>Invoice Amount(Received)</th>
                        <th>Pending Amount </th>
                    </thead>    
                    <tbody>
                        <?php
                        $sql_cust_nt="SELECT sum(rounded_total) as credit_total from `tabSales Invoice` where name like  '%CN%'";
                        $qry_cust_nt =$db2->query($sql_cust_nt)->row();
                        $cust_nt_total = $qry_cust_nt->credit_total;
                        $sql_cust = "select distinct name, customer_name from `tabCustomer` where name in
                        (select distinct (customer) from `tabSales Order`) order by creation desc";
                        $qry_cust  = $db2->query($sql_cust);
                       
                       
                        /* $sql_sales_inv = "select a.*,b.* from tab_sales_invoice a inner join tab_sales_order b 
                        on a.customer_name=b.customer_name "; */
                        //echo $sql_sales_inv; die;
                        //$qry_sales_inv = $this->db->query($sql_sales_inv);

                        $sno = 0;
                        $grand_total = 0;
                        $inv_grand_total = 0;
                        $inv_rec_grand_total= 0;
                        $grand_total_pend_amt = 0;

                        foreach($qry_cust->result() as $row){
                            $sno++;
                            //$inv_no = $row->name;
                            //$inv_tot_amt = $row->rounded_total;
                            $customer_code = $row->name;
                            $cust_name = $row->customer_name;
                            $customer_name = str_replace("'","",$cust_name);
                            //$due_date = $row->due_date;
                            //$commitment_date = $row->commitment_date;
                            //$commitment_amt = $row->commitment_amt;
                            $sql_so = "select name, sum(grand_total) as total from `tabSales Order` 
                            where customer_name='".$customer_name."'";
                            $qry_so  = $db2->query($sql_so)->row();
                            $total = $qry_so->total;
                            $so_id = $qry_so->name;
                            
                            $grand_total = $grand_total + $total;

                            $sql_inv = "select name,base_rounded_total, sum(rounded_total) as inv_total from `tabSales Invoice`
                             where customer_name='".$customer_name."'";
                            $qry_inv  = $db2->query($sql_inv)->row();
                            $inv_total = $qry_inv->inv_total;
                            $inv_no = $qry_inv->name;
                            $inv_grand_total = $inv_grand_total + $inv_total;

                            $sql_inv = "select sum(total_allocated_amount) as inv_rec_total from `tabPayment Entry`
                             where party_name='".$customer_name."' and payment_type = 'Receive'";
                            $qry_inv  = $db2->query($sql_inv)->row();
                            $inv_rec_total = $qry_inv->inv_rec_total;
                            $inv_rec_grand_total = $inv_rec_grand_total + $inv_rec_total;
                            $total_pend_amt = $inv_total - $inv_rec_total;
                            $grand_total_pend_amt = $grand_total_pend_amt + $total_pend_amt;
                            
                            
                            /* $sql_rec_amt ="select sum(total_allocated_amount) as tot_rec_amt from `tab_pay_entry` 
                            where title = '$customer_name'";
                            //echo $sql_rec_amt;die;
                            $qry_rec_amt = $this->db->query($sql_rec_amt)->row();
                            $tot_rec_amt = $qry_rec_amt->tot_rec_amt;
                            if($total_rec_amt == 0){
                                $tot_rec_amt = 0;
                            }

                            $tot_pending_amt = $inv_tot_amt - $tot_rec_amt; */
                        ?>
                        <tr>
                            <td><?=$sno;?></td>
                            <td><a href ="<?php echo base_url(); ?>index.php/salesc/inv_amount?cust_id=<?=$customer_code;?>&cust_name=<?=$customer_name;?>"><?=$customer_code?></a></td>
                            <td><?=$customer_name;?></td>
                            <td><?=number_format($total,2,".","");?></td>
                            <td><?=number_format($inv_total,2,".","");?></td>
                            <td><?=number_format($inv_rec_total,2,".","");?></td>
                            <td><?=number_format($total_pend_amt,2,".","");?></td>
                        </tr>
                       
                        <?php } 
                            $total_pending_pay =$grand_total_pend_amt-$cust_nt_total;
                        ?>
                         <tr>  <td></td>
                                <td></td>                                                 
                             <td>TOTAL</td>
                             <td><b><?=$grand_total;?></b></td>
                             <td><b><?=$inv_grand_total;?></b></td>
                             <td><b><?=$inv_rec_grand_total;?></b></td>
                             <td><b><?=$grand_total_pend_amt;?></b></td>
                        </tr>
                    </tbody>
                </table>
                <?//ajax pending pay
                <?php $db2 = $this->load->database('db2', TRUE); ?>
                
                    $from_dt = $_REQUEST['from_dt'];
                    $frm_dat = date("Y-m-d",strtotime($from_dt));
                    $to_dt = $_REQUEST['to_dt'];
                    $to_dat = date("Y-m-d",strtotime($to_dt));
                    $item_group = $_REQUEST['prod_cat'];
                    $amta = $_REQUEST['amta'];
                    $amtb = $_REQUEST['amtb'];
                    //echo $item_group;die;
                    $item_name =$_REQUEST['prod'];
                    //echo $item_name;die;
                    $sales_pr_nm = $_REQUEST['so'];
                
                
                    if($frm_dat=="" && $to_dat ==""){
                        $where_str="";
                    }
                    else{
                        $where_str="and c.due_date between '".$frm_dat."' and '".$to_dat."'";
                    }
                
                     if($item_group =="a"){
                    $where_str1 = "";
                    }
                    else{
                    $where_str1 = "and a.item_group='".$item_group."'";
                    } 
                
                    if($item_name =="a"){
                    $where_str2 = "";
                    }
                    else{
                    $where_str2 = "and a.item_name='".$item_name."'";
                    } 
                
                    if($sales_pr_nm =="a"){
                    $where_str3 = "";
                    }
                    else{
                    $where_str3 = "and c.sales_person_name='".$sales_pr_nm."'";
                    } 
                
                    ?>
                
                
                
                <div class="box-body table-responsive">
                    <div id="printableArea">
                        <table class="table table-bordered" id="example1" style="margin-top:60px">
                            <thead>
                                <th>SNO</th>
                                <th>Customer Name</th>                
                                <th>Item Category</th>                
                                <th>Item Name</th>                
                                <th>Sales Person</th>                
                                <th>Sales Order</th>                
                                <th>Pending Amount</th>
                                <th>Invoice Date</th>
                                <th>Due Date</th>
                                <th>Overdue Age</th>            
                            </thead>    
                            <tbody>
                            <?php //echo $item_group;die;?>
                                <?php
                                $sql_join="select distinct a.item_name,a.item_group,a.parent,b.title,c.name,c.rounded_total,c.sales_person_name,c.creation,c.due_date
                                from `tabSales Order Item` a inner join `tabSales Order` b on a.parent=b.name ".$where_str1." ".$where_str2."
                                inner join `tabSales Invoice` c on b.title=c.customer_name ".$where_str3." ".$where_str."";
                               //echo $sql_join;die; /* $sql_item = "select * from `tabSales Order Item`
                                // where item_group ='".$item_group."'";
                                // echo $sql_item;die; */
                                $qry_join  = $db2->query($sql_join);                
                                $sno = 0;
                                $tot_pending_amt = 0;
                                foreach($qry_join->result() as $row){
                                    $sno++;
                                    //$inv_no = $row->name;
                                    //$inv_tot_amt = $row->rounded_total;
                                    $item_name = $row->item_name;
                                    //echo $item_name;die;
                                    $item_group = $row->item_group;
                                    $so_id = $row->parent;
                                    $cust_name = $row->title;
                                    $inv_no = $row ->name;
                                    $rounded_total =  $row->rounded_total;
                                    $inv_total = $inv_total + $rounded_total;
                                    $inv_date = $row->creation;
                                    $due_date = $row->due_date;
                                    $sales_person = $row->$sales_person_name;
                                    //$due_date = $row->due_date;
                                    //$commitment_date = $row->commitment_date;
                                    //$commitment_amt = $row->commitment_amt;
                
                                    /* $sql_cust ="select * from  `tabSales Order` where name = '".$so_id."'"; 
                                   // echo $sql_cust;die;
                                    $qry_cust = $db2->query($sql_cust)->row();
                
                                    //echo $sql_rec_amt;die;                   
                                   
                                    $sql_inv_amt = "select * from `tabSales Invoice` 
                                    where customer_name = '".$cust_name."'";
                                   // echo $sql_inv_amt;die;
                                    $qry_inv_amt  = $db2->query($sql_inv_amt)->row(); 
                                    
                 */
                                    $sql_inv ="select sum(allocated_amount) as rec_amt from `tabPayment Entry Reference`
                                    where reference_name = '".$inv_no."' and reference_doctype='Sales Invoice'";
                                   // echo $sql_inv;die;
                                   $qry_inv = $db2->query($sql_inv)->row();
                                   $inv_rec_amt = $qry_inv->rec_amt;
                                   $inv_rec_total = $inv_rec_total + $inv_rec_amt;
                                   $pending_amt = $rounded_total - $inv_rec_amt; 
                
                                    $tot_pending_amt = $tot_pending_amt + $pending_amt;
                                ?>
                                <tr>
                                    <td><?=$sno;?></td>
                                    <td><?=$cust_name;?></td>
                                    <td><?=$item_group;?></td>
                                    <td><?=$item_name;?></td>
                                    <td><?=$sales_pr_nm;?></td>
                                    <td><?=$so_id;?></td>
                                    <td><?=$pending_amt;?></td>
                                    <td><?=$inv_date;?></td>
                                    <td><?=$due_date;?></td>
                                </tr>
                                <?php } 
                                ?><tr>
                                <td colspan="6">Total</td>
                                <td colspan="3"><?=$tot_pending_amt?></td>
                            </tbody>
                        </table>
                    </div>
                </div>
                            
if($amta!="" && $amtb!=""){

    if($pending_amt>$amta && $pending_amt< $amtb){
        
    }
}