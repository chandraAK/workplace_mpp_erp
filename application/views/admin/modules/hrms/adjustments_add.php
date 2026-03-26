<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Adjustment Add</h3>
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
    $emp_id = $qry_user_det->emp_id;
    $role = $qry_user_det->role;
    ?>
    
    <?php
        $adjustments_id = $_REQUEST['id'];
        if($adjustments_id != ''){
            foreach($get_by_id->result() as $row){
                $adjustments_emp_id = $row->adjustments_emp_id;
                $adjustments_hours = $row->adjustments_hours;
                $adjustments_date = $row->adjustments_date;
                $adjustments_rmks = $row->adjustments_rmks;
                $adjustments_status = $row->adjustments_status;
                $adjustments_type = $row->adjustments_type;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$adjustments_emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name;

                $app_rmks_hr = $row->app_rmks_hr;
                $app_rmks_mgmt = $row->app_rmks_mgmt;
            }
        } else {
            $adjustments_emp_id = "";
            $adjustments_hours = "";
            $adjustments_date = "";
            $adjustments_rmks = "";
            $adjustments_status = "";
            $adjustments_type = "";
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
            <?php if($adjustments_status == "Pending For HR Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/adjustments_app_hr">
            <?php } else if($adjustments_status == "Pending For Management Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/adjustments_app_mng">
            <?php }  else if($adjustments_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/adjustments_entry">
            <?php } ?>
                <input type="hidden" class="form-control" id="adjustments_id" name="adjustments_id" value="<?php echo $adjustments_id; ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($adjustments_id != ''){
                                echo "<b style='font-size:18px'>No-".$adjustments_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($adjustments_id != ''){
                                echo "<b style='font-size:18px'>Status-".$adjustments_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-5">
                        <select id="adjustments_emp_id" name="adjustments_emp_id" class="form-control" required>
                            <?php 
                                if($adjustments_id != ''){ 
                            ?>
                                <option value="<?=$adjustments_emp_id; ?>" selected><?php echo $adjustments_emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Adjustment Hours</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="adjustments_hours" name="adjustments_hours" value="<?=$adjustments_hours; ?>" onkeypress="return isNumberKey(event);" required>
                    </div>

                    <label class="col-sm-1 control-label">Adjustment Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="adjustments_date" name="adjustments_date" value="<?=$adjustments_date;?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Adjustment Type</label>
                    <div class="col-sm-2">
                        <select id="adjustments_type" name="adjustments_type" class="form-control" required>
                            <option value="<?=$adjustments_type;?>"><?=$adjustments_type;?></option>
                            <option value="In">In</option>
                            <option value="Out">Out</option>
                        </select>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="adjustments_rmks" name="adjustments_rmks" required><?=$adjustments_rmks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($adjustments_status == "Pending For HR Approval" || $adjustments_status == "Pending For Management Approval") && $role == 'Admin'){
                        ?>
                        <textarea id="app_rmks" name="app_rmks" class="form-control"></textarea>
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-3"><b>Remarks HR: </b></div>
                    <div class="col-sm-3"><?=$app_rmks_hr;?></div>
                    <div class="col-sm-3"><b>Remarks Management: </b></div>
                    <div class="col-sm-3"><?=$app_rmks_mgmt;?></div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <?php
                            if($adjustments_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($adjustments_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($adjustments_status == "Approved"){
                                //Do Nothing
                            } else if($adjustments_status == "") {
                                echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                            }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                            if($adjustments_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($adjustments_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($adjustments_status == "Approved"){
                                //Do Nothing
                            } else if($adjustments_status == "") {
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
                <th>HR Approval By</th>
                <th>HR Approval Date</th>
                <th>Management Approval By</th>
                <th>Management Approval Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "select * from adjustments where adjustments_id = '".$adjustments_id."'";
            $query = $this->db->query($sql);
            foreach($query->result() as $row){
                $created_by = $row->created_by;
                $created_date = $row->created_date;
                $hr_app_by = $row->hr_app_by;
                $hr_app_date  = $row->hr_app_date ;            
                $mgmt_app_by = $row->mgmt_app_by;
                $mgmt_app_date = $row->mgmt_app_date;   
            ?>
            <tr>
                <td><?=$created_by;?></td>
                <td><?=$created_date;?></td>
                <td><?=$hr_app_by;?></td>
                <td><?=$hr_app_date; ?></td>
                <td><?=$mgmt_app_by; ?></td>
                <td><?=$mgmt_app_date; ?></td>
            </tr>
            <?php } ?>              
        </tbody>
    </table>  
  </section>
</section>
                                 
<script>
$( function() {
    $( "#adjustments_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

//Select2
$(function(){
    $("#adjustments_emp_id").select2();
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
/*
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});*/
</script>