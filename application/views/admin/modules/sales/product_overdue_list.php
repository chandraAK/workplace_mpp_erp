<?php
//echo "charu";die;
    $db2 = $this->load->database('db2', TRUE);  
    $item_category = "Paper Cup";
    ?>

 <html>
<head>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Invoice Item Wise Reports</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

<table class="table table-bordered" id="example1" style="margin-top:60px">
<thead>
                <th>SNO</th>               
                <th>Item_Category</th>                
                <th>Item Name</th>                
                <th>Total Amount</th>                
                <th>Received Amount</th>                
                <th>Pending Amount</th>                
            </thead>    
            <tbody>
            <?php
            $date = date('Y-m-d');
            $overdue_amt = 0;
            $sql = "select distinct item_name,parent from `tabItem` where item_group = '".$item_category."'";
            //echo $sql;die;
            $query = $db2->query($sql);
            $sno=0;
            foreach($query->result() as $row){
            $sno++;
            $tot_rec_amt = 0;
            $item_name= $row->item_name;
           // $main_cat = $row->parent;

/*             $sql_item = "select * from `tabItem` where item_group = '".$sub_cat."'";
            //echo $sql_item;die;
            $qry_item  =$db2->query($sql_item)->row();
            $item_name = $qry_item->item_name;
            $item_group = $qry_item->item_group; */

            $sql_tot_item_amt = "select sum(net_amount) as amount,parent from `tabSales Invoice Item` 
            where item_name = '".$item_name."'";
           // echo $sql_tot_item_amt;die;
            $qry_tot_item_amt = $db2->query($sql_tot_item_amt);
            
                foreach($qry_tot_item_amt->result() as $row){
                 $net_amount = $row->amount;
                $inv_no = $row->parent;
                $item = $row->item_name;               
            
            $sql_rec_amt = "select sum(allocated_amount) as received_amt,due_date from `tabPayment Entry Reference` 
            where reference_name= '".$inv_no."' and due_date < '".$date."'";
            
            $qry_rec_amt = $db2->query($sql_rec_amt)->row();
            $inv_rec_amt = $qry_rec_amt->received_amt;
            $tot_rec_amt = $tot_rec_amt + $inv_rec_amt;           
           }
            $pend_amt = $net_amount-$tot_rec_amt;
           
            if($pend_amt >0){
            ?>
                <tr>           
                    <td><?=$sno;?></td>                                                
                    <td><?=$item_category;?></a></td>
                    <td><?=$item_name;?></a></td>
                    <td><?=number_format($net_amount,2,".","");?></td>                                                
                    <td><?=number_format($tot_rec_amt,2,".","");?></td>                                                
                    <td><?=number_format($pend_amt,2,".","");?></td>                                                
                                                                   
                </tr>
            <?php
            $overdue_amt = $overdue_amt + $pend_amt;
            }
            
        }
            ?>     <tr style="background-color: #57889c">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>OverDue Amount</b></td>
                    <td><?=number_format($overdue_amt,2,".","");?></td>                                        

                 </tbody>
                </table>
                </section>
            </section>
   