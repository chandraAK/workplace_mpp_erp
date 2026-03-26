<?php $db2 = $this->load->database('db2', TRUE); ?>
                <?php
                    $from_dt = $_REQUEST['from_dt'];
                    //$frm_dat = date("Y-m-d",strtotime($from_dt));
                    $to_dt = $_REQUEST['to_dt'];
                    //$to_dat = date("Y-m-d",strtotime($to_dt));
                    $item_group = $_REQUEST['prod_cat'];
                    $amta = $_REQUEST['amta'];
                    //echo $amta;die;
                    $amtb = $_REQUEST['amtb'];
                    //echo $item_group;die;
                    $item_name =$_REQUEST['prod'];
                    //echo $item_name;die;
                    $sales_pr_nm = $_REQUEST['so'];
                    
                
                
                    if($from_dat=="" && $to_dt ==""){
                        $where_str="";
                    }
                    else{
                        $where_str="and c.due_date between '".$from_dt."' and '".$to_dt."'";
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
                                $qry_join = $db2->query($sql_join);                
                                $sno = 0;
                                $tot_pending_amt = 0;
                                $date = date('Y-m-d');
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
                                    //echo $sql_inv;die;
                                   $qry_inv = $db2->query($sql_inv)->row();
                                   $inv_rec_amt = $qry_inv->rec_amt;
                                   $inv_rec_total = $inv_rec_total + $inv_rec_amt;
                                   $pending_amt = $inv_total - $inv_rec_amt; 
                
                                    $tot_pending_amt = $tot_pending_amt + $pending_amt;
                                    //echo $tot_pending_amt;die;
                                ?>                                
                                  <?php
                                  if($pending_amt>0){
                                    $diff = strtotime($date) - strtotime($due_date); 
                                    //echo $diff;die;
                                    $over_due_age=abs(round($diff / 86400)); 
                                }
                                else{
                                    $over_due_age = 0;
                                }

                                 if($amta!="a" && $amtb!="a"){
                                    if($pending_amt<$amtb && $pending_amt>$amta){
                                        $pend_amt = $pending_amt;
                                    }                               
      
                                    ?> 
                                <tr>
                                    <td><?=$sno;?></td>
                                    <td><?=$cust_name;?></td>
                                    <td><?=$item_group;?></td>
                                    <td><?=$item_name;?></td>
                                    <td><?=$sales_pr_nm;?></td>
                                    <td><?=$so_id;?></td>
                                    <td><?=$pend_amt;?></td>
                                    <td><?=$inv_date;?></td>
                                    <td><?=$due_date;?></td>
                                    <td><?=$over_due_age;?></td>
                                   <?php
                                    }
                                
                                    else
                                    {
                                        ?><tr>
                                        <td><?=$sno;?></td>
                                    <td><?=$cust_name;?></td>
                                    <td><?=$item_group;?></td>
                                    <td><?=$item_name;?></td>
                                    <td><?=$sales_pr_nm;?></td>
                                    <td><?=$so_id;?></td>
                                    <td><?=$pending_amt;?></td>
                                    <td><?=$inv_date;?></td>
                                    <td><?=$due_date;?></td>
                                    <td><?=$over_due_age;?></td>                                    
                                </tr>
                                <?php 
                                }
                            }
                                /* else{
                                    echo "no data";
                                } */
                                
                                ?><tr style="background-color: #57889c">
                                <td colspan="6">Total</td>
                                <td colspan="4"><?=$tot_pending_amt?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                            
