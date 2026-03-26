<?php $this->load->helper("dr"); ?>



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
        
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading" style="font-size:18px"><b>
                Daily Report Form</b>
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/drc/dr_entry">
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
                if($dr_id!=""){
                     ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Creditors List</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="credit_list" name="credit_list" value="<?php echo $leads_work_on; ?>" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Due Days</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_days" name="due_days" value="<?php echo $due_days; ?>" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Due Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_date" name="due_date" value="<?php echo $due_date; ?>" required>
                    </div>
                </div>
                <?php } else{?>
                    <div class="form-group">
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Creditors List</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="credit_list" name="credit_list" value="" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Due Days</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_days" name="due_days" value="" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Due Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_date" name="due_date" value="" required>
                    </div>
                </div>
                <?php

                }?>
                <!--- Added by Charu 202010291235 -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Customers Visit</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="credit_list" name="credit_list" value="<?php echo $leads_work_on; ?>" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Leads Assigned</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_days" name="due_days" value="<?php echo $leads_close; ?>" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Payment Recieved Update</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="due_date" name="due_date" value="<?php echo $leads_assign; ?>" required>
                    </div>
                </div>

                <!--- Product Inquiry -->

                
                <!--- lead assign -->
                    
                    <table class="table table-bordered" id="item_tbl1">
                        <tr style="background-color:#ddd">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Monthly Sales Target</b></h5></div>
                            <th>Monthly Sales Target</th>
                            <th>Item wise</th>
                            <th>Volume</th>
                            <th>Value</th>
                            <th>Part Wise</th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_lead_assign where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $sales_pr_nm =$row->name;
                                $leads_no = $row->leads_no;
		                 ?>
                        <tr>
                            <td>Daily Target vs Achievement </td>
                             <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>  
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            </tr>
                            <tr>
                            <td>Daily Average Vs set Average </td>
                             <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>  
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td>Daily Target vs Achievement </td>
                             <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>  
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            </tr>
                            <tr>
                            <td>Daily Average Vs set Average </td>
                             <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>  
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                            </tr>
                        <?php    
                        }
                        ?>
                    </table>
                    <!---monthly sales target -->
                    <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Lead Assignment</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl1">
                        <tr style="background-color:#ddd">
                            <th>Lead Assigned By</th>
                            <th>Number</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow1();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_lead_assign where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $sales_pr_nm =$row->name;
                                $leads_no = $row->leads_no;
		                 ?>
                        <tr>
                            <td> <input type="text" id="sales_pr_nm" name="sales_pr_nm[]" value="<?=$sales_pr_nm;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                            </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td><select id="sales_pr_nm" name="sales_pr_nm[]" class="form-control"><?php echo dr_sales_name(); ?></select></td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>                        
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                        </tr>
                        <?php    
                        }
                        ?>
                    </table>
                
            
                <!--pending orders-->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Pending Orders</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl1">
                        <tr style="background-color:#ddd">
                        <th>Pending Orders</th>
                            <th>Item wise</th>
                            <th>Volume</th>
                            <th>Value</th>
                            <th>Part Wise</th>
                    
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_lead_assign where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $sales_pr_nm =$row->name;
                                $leads_no = $row->leads_no;
		                 ?>
                        <tr>
                            <td> <input type="text" id="sales_pr_nm" name="sales_pr_nm[]" value="<?=$sales_pr_nm;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                            </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td>Orders in delay in context to delivery committment</td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>                        
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>
                        </tr>
                        <?php    
                        }
                        ?>
                    </table>
                
                <!--pending payments-->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Pending Payments</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl1">
                        <tr style="background-color:#ddd">
                            <th>Dues</th>
                            <th>To Remind</th>
                            <th>Over Due</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow1();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_lead_assign where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $sales_pr_nm =$row->name;
                                $leads_no = $row->leads_no;
		                 ?>
                        <tr>
                            <td> <input type="text" id="sales_pr_nm" name="sales_pr_nm[]" value="<?=$sales_pr_nm;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                            </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td></td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>                        
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                        </tr>
                        <?php    
                        }
                        ?>
                    </table>
                
                
<!--- customer visits-->
           
            
                <!---customer interaction -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                        <div class="col-sm-12" style="text-align:left;"><h5><b>Dispatch target</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl3">
                        <tr style="background-color:#ddd">
                            <th>Dispatch Target VS Achievement</th>
                            <th>Item wise</th>
                            <th>Volume</th>
                            <th>Value</th>
                            <th>Part Wise</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow3();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql3 = "select * from dr_cust_int where dr_id ='".$dr_id."'";
                            $qry3= $this->db->query($sql3);

                            $cnt = 0;
                            foreach($qry3->result() as $row){
                                $cnt++;
                                $party_nm =$row->party_name;
		                        $cont_per = $row->cont_person;
		                        $cont_no= $row->cont_no;
		                        $email= $row->email;
		                        $remarks = $row->remarks;
		        

                        ?>
                        <tr>
                            <td>Daily Average vs set Average</td>
                                <td><input type="text" id="cont_per" name="cont_per[]" value="<?=$cont_per;?>" class="form-control" required></td>
                                <td><input type="text" id="cont_no" name="cont_no[]" value="<?=$cont_no;?>" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="email" name="email[]" value="<?=$email;?>" class="form-control" required></td>
                               <td> <input type="text" id="remarks" name="remarks[]" value="<?=$remarks;?>" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                        </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td>Daily Average vs set Average</td>
                                <td><input type="text" id="cont_per" name="cont_per[]" value="<?=$cont_per;?>" class="form-control" required></td>
                                <td><input type="text" id="cont_no" name="cont_no[]" value="<?=$cont_no;?>" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="email" name="email[]" value="<?=$email;?>" class="form-control" required></td>
                               <td> <input type="text" id="remarks" name="remarks[]" value="<?=$remarks;?>" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                        </tr>
                        <?php    
                        }
                        ?>
                    </table>
                </div>
                <!-- sales person visit-->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                        <div class="col-sm-12" style="text-align:left;"><h5><b>Sales Person Visit to Customer</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl3">
                        <tr style="background-color:#ddd">
                            <th>Customer Order Visit</th>
                            <th>Expected Order Value</th>
                            <th>Remark</th>
                            <th>Next Visit Date</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow3();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql3 = "select * from dr_cust_int where dr_id ='".$dr_id."'";
                            $qry3= $this->db->query($sql3);

                            $cnt = 0;
                            foreach($qry3->result() as $row){
                                $cnt++;
                                $party_nm =$row->party_name;
		                        $cont_per = $row->cont_person;
		                        $cont_no= $row->cont_no;
		                        $email= $row->email;
		                        $remarks = $row->remarks;
		        

                        ?>
                        <tr>
                            <td><input type="text" id="party_nm" name="party_nm[]" value="<?=$party_nm;?>" class="form-control" required></td>
                                <td><input type="text" id="cont_per" name="cont_per[]" value="<?=$cont_per;?>" class="form-control" required></td>
                                <td><input type="text" id="cont_no" name="cont_no[]" value="<?=$cont_no;?>" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="email" name="email[]" value="<?=$email;?>" class="form-control" required></td>
                               <td> <input type="text" id="remarks" name="remarks[]" value="<?=$remarks;?>" class="form-control" required> </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                        </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td><input type="text" id="party_nm" name="party_nm[]" value="" class="form-control" required></td>
                               <td> <input type="text" id="cont_per" name="cont_per[]" value="" class="form-control" required></td>
                                <td><input type="text" id="cont_no" name="cont_no[]" value="" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="email" name="email[]" value="" class="form-control" required></td>
                                 <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                            </tr>
                        <?php    
                        }
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
                    <table class="table table-bordered" id="item_tbl" style="text-align:left">
                        <tr style="background-color:#ddd">
                            <th>Particulars</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql_itm_list = "select * from dr_details where dr_id ='".$dr_id."'";
                            $qry_itm_list = $this->db->query($sql_itm_list);

                            $cnt = 0;
                            foreach($qry_itm_list->result() as $row){
                                $cnt++;
                                $dr_details = $row->dr_details;
                        ?>
                        <tr>
                            <td>
                                <input type="text" id="dr_details" name="dr_details[]" value="<?=$dr_details;?>" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                            </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td>
                                <input type="text" id="dr_details" name="dr_details[]" value="" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                            </tr>
                        <?php    
                        }
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

$(function () {
    $('#frm_tim').datetimepicker({
        format: 'LT'
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
	newCell1.innerHTML = '<input type="text" id="dr_details" name="dr_details[]" value="" class="form-control">';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;"  onclick="deleterow()"></span>';
}
</script>
<script>

function addrow1(){
	
	var table = document.getElementById('item_tbl1');
	
	var a =  document.getElementById('item_tbl1').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<select id="sales_pr_nm" name="sales_pr_nm[]" class="form-control"><?php echo dr_lead_name(); ?></select>'
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="leads_no" name="leads_no[]" value="" class="form-control" >';
	
	var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;"  onclick="deleterow1()"></span>';
}
</script>
<script>
  function addrow2(){
	
	var table = document.getElementById('item_tbl2');
	
	var a =  document.getElementById('item_tbl2').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	 var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<input type="text" id="meet_name" name="meet_name[]" value="" class="form-control">';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="frm_tim" name="frm_tim[]" value="" class="form-control from_time">';
    var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<input type="text" id="to_tim" name="to_tim[]" value="" class="form-control to_time">';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="agenda" name="agenda[]" value="" class="form-control">';
    var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<input type="text" id="total_hrs" name="total_hrs[]" value="" class="form-control" >';
	var newCell1 = row.insertCell(5); 
    newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;"  onclick="deleterow2()"></span>';
 
    
    
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
    newCell1.innerHTML = '<input type="text" id="party_nm" name="party_nm[]" value="" class="form-control">';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="cont_per" name="cont_per[]" value="" class="form-control">';
    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="cont_no" name="cont_no[]" value="" onkeypress="return isNumberKey(event);" class="form-control" >';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="email" name="email[]" value="" class="form-control">';
    var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<input type="text" id="remarks" name="remarks[]" value="" class="form-control">';
	var newCell1 = row.insertCell(5);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span>';
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

$(function() {
$('.datepicker').datepicker({ format : 'dd-mm-yyyy', weekStart: 1 });
});
</script>