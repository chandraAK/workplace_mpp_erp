<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Special Salary Advance Application</h3>
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
        $sal_adv_id = $_REQUEST['id'];
        if($sal_adv_id != ''){
            foreach($get_by_id->result() as $row){
                $emp_id = $row->emp_id;
                $sal_adv_req = $row->sal_adv_req;
                $sal_adv_rmks = $row->sal_adv_rmks;
                $status = $row->status;
                $reports_to = $row->reports_to;
                $created_by = $row->created_by;
                $created_date = $row->created_date;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name; 

                $app_rmks_hr = $row->app_rmks_hr;
                $app_rmks_mgmt = $row->app_rmks_mgmt;
            }
        } else {
            $emp_id = "";
            $sal_adv_req = "";
            $sal_adv_rmks = "";
            $status = "";
            $reports_to = "";
            $created_by = "";
            $created_date = "";

            $employee_name = "";
            $app_rmks_hr = "";
            $app_rmks_mgmt = "";
        }            

    ?>
   
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading"></header>
            <div class="panel-body">
                    <?php if($status == "Pending For Management Approval"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/spcl_sa_app_mng">
                    <?php }  else if($status == "Pending For Payment"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/spcl_sa_app_pay">
                    <?php } else { ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/spcl_sal_adv_entry" onsubmit="return reqd();">
                    <?php } ?>
                        <input type="hidden" class="form-control" id="sal_adv_id" name="sal_adv_id[]" value="<?php echo $sal_adv_id; ?>">
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($sal_adv_id != ''){
                                echo "<b style='font-size:18px'>Salary Adv No-".$sal_adv_id."</b>";
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
                        <select id="emp_id" name="emp_id" class="form-control" onchange="sal_adv_cal(this.value);" required>
                            <?php 
                                if($sal_adv_id != ''){ 
                            ?>
                                <option value="<?=$emp_id; ?>" selected><?php echo $emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12" id="detail">
                        <input type="hidden" id="sys_cal_advamt" name="sys_cal_advamt" value="0" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Advance Required</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="sal_adv_req" name="sal_adv_req" value="<?=$sal_adv_req;?>" autocomplete="off" required onkeypress="return isNumberKey(event);">
                    </div>  
                </div>
                    
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="sal_adv_rmks" name="sal_adv_rmks" autocomplete="off" required><?=$sal_adv_rmks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($status == "Pending For HR Approval" || $status == "Pending For Management Approval") && $role == 'Admin'){
                        ?>
                        <textarea id="app_rmks" name="app_rmks" class="form-control"></textarea>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-2"><b>Payment Mode</b></div>
                    <div class="col-sm-2">
                        <?php
                        if(($status == "Pending For Payment") && $role == 'Admin'){
                        ?>
                        <select id="PaidMode" name = "PaidMode" class="form-control" required>
                            <option value="">--select--</option>
                            <?php
                                $sql_emp_type = "select employee_type from tabEmployee where name = '".$emp_id."'";
                                $qry_emp_type = $db2->query($sql_emp_type)->row();
                                $employee_type = $qry_emp_type->employee_type;

                                if($employee_type == "On Roll"){
                            ?>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                            <?php
                                } else {
                            ?>
                            <option value="Cash">Cash</option>
                            <?php
                                } 
                            ?>
                        </select>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"><b>Remarks HR: </b></div>
                    <div class="col-sm-3"><?=$app_rmks_hr;?></div>
                    <div class="col-sm-3"><b>Remarks Management: </b></div>
                    <div class="col-sm-3"><?=$app_rmks_mgmt;?></div>
                </div>
                
                <?php
                    if($status != "Paid"){
                ?>
                    <div class="row">
                        <div class="col-lg-2"><b>Approval Status</b></div>
                        <div class="col-lg-2">
                            <select id="app_status" name="app_status" class="form-control">
                                <?php
                                    if($status == "Pending For HOD Approval" || $status == "Pending For HR Approval" || $status == "Pending For Management Approval"){
                                ?>
                                    <option value="Approve">Approve</option>
                                    <option value="Reject">Reject</option>
                                <?php
                                    }
                                ?>

                                <?php
                                    if($status == "Pending For Payment" || $status == "Unpaid"){
                                ?>
                                    <option value="Paid">Paid</option>
                                    <option value="Unpaid">Unpaid</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-2">
                            <?php                        
                                if($status == "Pending For HOD Approval" && ($reports_to == $emp_id1 || $role == 'Admin')){
                                    echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                                }  else if($status == "Pending For HR Approval" && $role == 'Admin'){
                                    echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                                }  else if($status == "Pending For Management Approval" && $role == 'Admin'){
                                        echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                                }  else if($status == "Pending For Payment" && $role == 'Admin'){
                                        echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                                }  else if($status == "Approved"){
                                    //Do Nothing
                                } else if($status == "") {
                                    echo '<input type="submit" id="submit1" name="submit" value="Submit" class="form-control">';
                                }
                            ?>
                        </div>
                    </div>

                <?php
                    }
                ?>

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
                $sql = "select * from spcl_salary_adv where sal_adv_id = '".$sal_adv_id."'";
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
function sal_adv_cal(emp_id){
    //Ajax
    $("#detail").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
        
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        } 

        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('detail').innerHTML=xmlhttp.responseText;
            }
        }
        
        var queryString="?emp_id="+encodeURIComponent(emp_id);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/spcl_sal_adv_cal" + queryString,true);
        xmlhttp.send();
}
</script>

<script>
function reqd(){
    var sys_cal_advamt = document.getElementById("sys_cal_advamt").value;
    var sal_adv_req = document.getElementById("sal_adv_req").value;

    if(sal_adv_req == ""){
        alert("Please enter Salary Advance Amount Required.");
        return false;
    }

    if(sys_cal_advamt == ""){
        alert("System Calculated Advance Amount Cannot be blank.");
        return false;
    }
}
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>