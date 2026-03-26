<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Payment Request / Return Application</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <?php 
    $username = $_SESSION['username'];
    if($username == ""){
        $url = base_url()."index.php/logout";
        redirect($url);
    }

    $sql_user_det = "select * from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $email = $qry_user_det->email;
    $name = $qry_user_det->name;
    $emp_id1 = $qry_user_det->emp_id;
    $role = $qry_user_det->role;
    ?>
    
    <?php
        $pr_id = $_REQUEST['id'];
        if($pr_id != ''){
            foreach($get_by_id->result() as $row){
                $emp_id = $row->emp_id;
                $pr_type = $row->pr_type;
                $pr_amt = $row->pr_amt;
                $pr_rmks = $row->pr_rmks;
                $pay_type = $row->pay_type;
                $pay_mode = $row->pay_mode;
                $status = $row->status;
                $reports_to = $row->reports_to;
                $created_by = $row->created_by;
                $created_date = $row->created_date;
                $chk_utr_no = $row->chk_utr_no;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name; 
            }
        } else {
            $emp_id = "";
            $pr_type = "";
            $pr_amt = "";
            $pr_rmks = "";
            $pay_type = "";
            $pay_mode = "";
            $status = "";
            $reports_to = "";
            $created_by = "";
            $created_date = "";
            $chk_utr_no = "";

            $employee_name = "";
        }            

    ?>
   
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading"></header>
            <div class="panel-body">
                    <?php if($status == "Pending For Management Approval"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/pr_app_mng">
                    <?php }  else if($status == "Pending For Payment"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/pr_app_pay" enctype="multipart/form-data">
                    <?php } else { ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/pr_entry" onsubmit="return reqd();">
                    <?php } ?>
                        <input type="hidden" class="form-control" id="pr_id" name="pr_id" value="<?php echo $pr_id; ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($pr_id != ''){
                                echo "<b style='font-size:18px'>No-".$pr_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($status != ''){
                                echo "<b style='font-size:18px'>Status-".$status."</b>";
                            }
                        ?>
                    </div>
                </div>

               
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-5">
                        <select id="emp_id" name="emp_id" class="form-control" required>
                            <?php 
                                if($pr_id != ''){ 
                            ?>
                                <option value="<?=$emp_id; ?>" selected><?php echo $emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Payment Request Type</label>
                    <div class="col-sm-3">
                        <select id="pr_type" name="pr_type" class="form-control" required>
                            <option value="<?=$pr_type;?>"><?=$pr_type;?></option>
                            <option value="Request">Request</option>
                            <option value="Return">Return</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Amount Required</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="pr_amt" name="pr_amt" value="<?=$pr_amt;?>" autocomplete="off" required onkeypress="return isNumberKey(event);">
                    </div>  
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Payment Type</label>
                    <div class="col-sm-5">
                        <select id="pay_type" name="pay_type" class="form-control" required>
                            <option value="<?=$pay_type;?>"><?=$pay_type;?></option>
                            <option value="On Roll">On Roll</option>
                            <option value="Off Roll">Off Roll</option>
                        </select>
                    </div> 

                    <label class="col-sm-1 control-label">Payment Mode</label>
                    <div class="col-sm-5">
                        <select id="pay_mode" name="pay_mode" class="form-control" required>
                            <option value="<?=$pay_mode;?>"><?=$pay_mode;?></option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                        </select>
                    </div>  
                </div>
                    
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="pr_rmks" name="pr_rmks" autocomplete="off" required><?=$pr_rmks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Cheque / UTR No</label>
                    <div class="col-sm-5">
                        <?php if($status == "Pending For Payment" && $pay_mode == "Bank"){ ?>
                            <input type="text" class="form-control" id="chk_utr_no" name="chk_utr_no" value="" autocomplete="off" >
                        <?php 
                        } else {
                        ?>
                            <input type="text" class="form-control" id="chk_utr_no" name="chk_utr_no" value="<?=$chk_utr_no;?>" readonly>
                        <?php
                        } 
                        ?>
                    </div>  
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Attachment</label>
                    <div class="col-sm-5">
                        <?php if($status == "Pending For Payment" && $pay_mode == "Cash"){ ?>
                            <input type="file" class="form-control" id="cash_att" name="cash_att" value="" autocomplete="off" >
                        <?php 
                        } else {
                        ?>
                            <?=$cash_att;?>
                        <?php
                        } 
                        ?>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <?php    
                            if($status == "Pending For Management Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            } else if($status == "Pending For Payment"){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Paid">';
                            } else if($status == "") {
                                echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                            }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php  
                            if($status == "Pending For Management Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($status == "Pending For Payment"){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Unpaid">';
                            } else if($status == "") {
                            }
                        ?>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </form>
            </div>
            <div class="col-lg-1"></div>
        </section>
        </div>
    </div>


    <h3><centre>Action Timing </centre></h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Created by</th>
                <th>Created date</th>
                <th>Management Approval By</th>
                <th>Management Approval Date</th>
                <th>Payment By</th>
                <th>Payment Date</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "select * from pr_mst where pr_id = '".$pr_id."'";
                $query = $this->db->query($sql);
                foreach($query->result() as $row){
                    $created_by = $row->created_by;
                    $created_date = $row->created_date;            
                    $mgmt_app_by = $row->mgmt_app_by;
                    $mgmt_app_date = $row->mgmt_app_date;   
                    $payment_by = $row->payment_by;   
                    $payment_date = $row->payment_date;   
        ?>
            <tr>
                <td><?=$created_by;?></td>
                <td><?=$created_date;?></td>
                <td><?=$mgmt_app_by; ?></td>
                <td><?=$mgmt_app_date; ?></td>
                <td><?=$payment_by; ?></td>
                <td><?=$payment_date; ?></td>
            </tr>
            <?php
                }
            
            ?>              
        </tbody>
    </table>
 

  </section>
</section>


<script>
//Select2
$(function(){
    $("#emp_id").select2();
});


//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>

<script>
function reqd(){
    var pr_type = document.getElementById("pr_type").value;
    var pr_amt = document.getElementById("pr_amt").value;

    if(pr_type == ""){
        alert("Please Enter Payment Type.");
        return false;
    }

    if(pr_amt == ""){
        alert("Please Enter Advance Amount.");
        return false;
    }
}
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>