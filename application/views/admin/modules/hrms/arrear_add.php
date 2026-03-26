<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Arrear Add</h3>
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
        $arrear_id = $_REQUEST['id'];
        if($arrear_id != ''){
            foreach($get_by_id->result() as $row){
                $emp_id = $row->emp_id;
                $arrear_amt = $row->arrear_amt;
                $arrear_rmks = $row->arrear_rmks;
                $status = $row->status;
                $reports_to = $row->reports_to;
                $created_by = $row->created_by;
                $created_date = $row->created_date;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name; 

                $app_rmks_mgmt = $row->app_rmks_mgmt;
            }
        } else {
            $emp_id = "";
            $arrear_amt = "";
            $arrear_rmks = "";
            $status = "";
            $reports_to = "";
            $created_by = "";
            $created_date = "";

            $employee_name = "";
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
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/arrear_app_mng">
                    <?php } else { ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/arrear_entry" onsubmit="return reqd();">
                    <?php } ?>
                        <input type="hidden" class="form-control" id="arrear_id" name="arrear_id[]" value="<?php echo $arrear_id; ?>">
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($arrear_id != ''){
                                echo "<b style='font-size:18px'>Arrear No-".$arrear_id."</b>";
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
                                if($arrear_id != ''){ 
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
                    <label class="col-sm-1 control-label">Arrear Amount</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="arrear_amt" name="arrear_amt" value="<?=$arrear_amt;?>" autocomplete="off" required onkeypress="return isNumberKey(event);">
                    </div>  
                </div>
                    
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="arrear_rmks" name="arrear_rmks" autocomplete="off" required><?=$arrear_rmks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($status == "Pending For Management Approval") && $role == 'Admin'){
                        ?>
                        <textarea id="app_rmks" name="app_rmks" class="form-control"></textarea>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
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
                                    if($status == "Pending For Management Approval"){
                                ?>
                                    <option value="Approve">Approve</option>
                                    <option value="Reject">Reject</option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col-lg-2">
                            <?php                        
                                if($status == "Pending For Management Approval" && $role == 'Admin'){
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
                
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "select * from arrear where arrear_id = '".$arrear_id."'";
                $query = $this->db->query($sql);
                foreach($query->result() as $row){
                    $created_by = $row->created_by;
                    $created_date = $row->created_date;            
                    $mgmt_app_by = $row->mgmt_app_by;
                    $mgmt_app_date = $row->mgmt_app_date;   
        ?>
            <tr>
                <td><?=$created_by;?></td>
                <td><?=$created_date;?></td>
                <td><?=$mgmt_app_by; ?></td>
                <td><?=$mgmt_app_date; ?></td>
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
    var arrear_amt = document.getElementById("arrear_amt").value;

    if(arrear_amt == ""){
        alert("Please enter Arrear Amount.");
        return false;
    }
}
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>