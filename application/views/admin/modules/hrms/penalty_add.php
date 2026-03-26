<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Penalty Add</h3>
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
        $penalty_id = $_REQUEST['id'];
        if($penalty_id != ''){
            foreach($get_by_id->result() as $row){
                $penalty_emp_id = $row->penalty_emp_id;
                $penalty_hours = $row->penalty_hours;
                $penalty_date = $row->penalty_date;
                $penalty_remarks = $row->penalty_remarks;
                $penalty_status = $row->penalty_status;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$penalty_emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name;

                $app_rmks_hr = $row->app_rmks_hr;
                $app_rmks_mgmt = $row->app_rmks_mgmt;
                
            }
        } else {
            $penalty_emp_id = "";
            $penalty_hours = "";
            $penalty_date = "";
            $penalty_remarks = "";
            $penalty_status = "";
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
            <?php if($penalty_status == "Pending For HR Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/penalty_app_hr">
            <?php } else if($penalty_status == "Pending For Management Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/penalty_app_mng">
            <?php }  else if($penalty_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/penalty_entry">
            <?php } ?>
                <input type="hidden" class="form-control" id="penalty_id" name="penalty_id" value="<?php echo $penalty_id; ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($penalty_id != ''){
                                echo "<b style='font-size:18px'>No-".$penalty_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($penalty_id != ''){
                                echo "<b style='font-size:18px'>Status-".$penalty_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-5">
                        <select id="penalty_emp_id" name="penalty_emp_id" class="form-control" required>
                            <?php 
                                if($penalty_id != ''){ 
                            ?>
                                <option value="<?=$penalty_emp_id; ?>" selected><?php echo $penalty_emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Penalty Hours</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="penalty_hours" name="penalty_hours" value="<?=$penalty_hours; ?>" onkeypress="return isNumberKey(event);" required>
                    </div>

                    <label class="col-sm-1 control-label">Penalty Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="penalty_date" name="penalty_date" value="<?=$penalty_date;?>" required>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="penalty_remarks" name="penalty_remarks" required><?=$penalty_remarks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($penalty_status == "Pending For HR Approval" || $penalty_status == "Pending For Management Approval") && $role == 'Admin'){
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
                            if($penalty_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($penalty_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($penalty_status == "Approved"){
                                //Do Nothing
                            } else if($penalty_status == "") {
                                echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                            }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                            if($penalty_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($penalty_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($penalty_status == "Approved"){
                                //Do Nothing
                            } else if($penalty_status == "") {
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
            $sql = "select * from penalty where penalty_id = '".$penalty_id."'";
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
    $( "#penalty_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

//Select2
$(function(){
    $("#penalty_emp_id").select2();
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
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>