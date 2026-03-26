<?php
//echo "charu";die;
    $db2 = $this->load->database('db2', TRUE);  ?>

 <html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script></head>
<?php $db2 = $this->load->database('db2', TRUE);
$this->load->helper("dr"); ?>

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
                <th>Amount(Total)</th>                
                <th>Received Amount</th>                
                <th>Pending Amount</th>                
            </thead>    
            <tbody>
            <?php
            $sql = "select * from `tabItem Group`";
            //echo $sql;die;
            $query = $db2->query($sql);
            $sno=0;
            foreach($query->result() as $row){
            $sno++;
            $sub_cat = $row->item_group_name;
            $main_cat = $row->parent;

            $sql_item = "select * from `tabItem` where item_group = '".$sub_cat."'";
            //echo $sql_item;die;
            $qry_item  =$db2->query($sql_item)->row();
            $item_name = $qry_item->item_name;
            $item_group = $qry_item->item_group;

            $sql_tot_item_amt = "select sum(net_amount) as amount,item_name,parent from `tabSales Invoice Item` 
            where item_group = '".$item_group."'";
           // echo $sql_tot_item_amt;die;
            $qry_tot_item_amt = $db2->query($sql_tot_item_amt)->row();
            $amount = $qry_tot_item_amt->amount;
            $inv_no = $qry_tot_item_amt->parent;
            $item = $qry_tot_item_amt->item_name;
            
            $sql_rec_amt = "select sum(allocated_amount) as received_amt from `tabPayment Entry Reference` 
            where reference_name= '".$inv_no."'";
            //echo $sql_rec_amt;die;
            $qry_rec_amt = $db2->query($sql_rec_amt)->row();
            $inv_rec_amt = $qry_rec_amt->received_amt;
            $pend_amt = $amount-$inv_rec_amt;
            ?>
                <tr>           
                    <td><?=$sno;?></td>                                                
                    <td><a href ="<?php echo base_url(); ?>index.php/salesc/product_overdue_list?category=<?=$item_group;?>"><?=$item_group;?></a></td>
                    <td><?=number_format($amount,2,".","");?></td>                                                
                    <td><?=number_format($inv_rec_amt,2,".","");?></td>                                                
                    <td><?=number_format($pend_amt,2,".","");?></td>                                                
                </tr>
            <?php
            }
            ?>
            
                    </tbody>
                </table>
                </section>
            </section>
   