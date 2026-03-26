<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php 
//echo "<h2 style='color:red'>Mispunch Are Not Allowed Since 01 March 2021.</h2>";
//die;
?>

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
    $miss_pun_id = $_REQUEST['id'];
    if($miss_pun_id != ''){
        foreach($get_by_id->result() as $row){
            $miss_pun_date = $row->miss_pun_date;
            $miss_pun_time = $row->miss_pun_time;
            $miss_pun_type = $row->miss_pun_type;
            $mp_hod_id = $row->mp_hod_id;
            $mp_emp_id = $row->mp_emp_id;
            $mp_status = $row->mp_status;
            $mp_reason = $row->mp_reason;

            $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$mp_emp_id."'";
            $qry_emp_name = $this->db->query($sql_emp_name)->row();
            $employee_name = $qry_emp_name->emp_name;

            $app_rmks_hr = $row->app_rmks_hr;
            $app_rmks_mgmt = $row->app_rmks_mgmt;
        }
    } else {
        $miss_pun_date = "";
        $miss_pun_time = "";
        $miss_pun_type = "";
        $mp_hod_id = "";
        $mp_emp_id = "";
        $mp_status = "";
        $mp_reason = "";

        $employee_name = "";
        $app_rmks_hr = "";
        $app_rmks_mgmt = "";
    }   
?>


<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Miss Punch Application Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>    

    <div class="row" style="text-align:center">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <section class="panel">
                <header class="panel-heading" style="font-size:18px"><b>Miss Punch Application Form</b></header>
                <div class="panel-body">
                    <?php if($mp_status == "Pending For HOD Approval"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/mp_app_hod">
                    <?php }  else if($mp_status == "Pending For HR Approval"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/mp_app_hr">
                    <?php } elseif($mp_status == "Pending For Management Approval"){ ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/mp_app_mng">
                    <?php }  else if($mp_status == "Approved"){ ?>
                        <!--Do Nothing-->
                        <form class="form-horizontal" id="myForm" method="post" action="">
                    <?php } else { ?>
                        <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/miss_pun_entry">
                    <?php } ?>
                        <input type="hidden" class="form-control" id="miss_pun_id" name="miss_pun_id" value="<?php echo $miss_pun_id; ?>">
                        
                    
                        <!-- miss punch form-->
                        <div class="form-group">
                            <div class="col-sm-6" style="text-align:left">
                                <?php
                                    if($miss_pun_id != ''){
                                        echo "<h4>Miss Punch No-".$miss_pun_id."</h4>";
                                    }
                                ?>
                            </div>
                            <div class="col-sm-6"  style="text-align:right">
                                <?php
                                    if($miss_pun_id != ''){
                                        echo "<b style='font-size:18px'>Status-".$mp_status."</b>";
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Emp ID</label>
                            <div class="col-sm-3">
                                <select id="mp_emp_id" name="mp_emp_id" class="form-control" required>
                                    <?php 
                                        if($miss_pun_id != ''){ 
                                    ?>
                                        <option value="<?=$mp_emp_id; ?>" selected><?php echo $mp_emp_id." - ".$employee_name;?></option>
                                    <?php 
                                        } 
                                    ?>
                                    <?php echo EmpId(); ?>
                                </select>
                            </div>

                            <label class="col-sm-1 control-label">Miss Punch Type</label>
                            <div class="col-sm-3">
                                <select id="miss_pun_type" name="miss_pun_type" class="form-control" required>
                                    <option value="<?= $miss_pun_type; ?>"><?= $miss_pun_type; ?></option>
                                    <option value="in">In</option>
                                    <option value="out">Out</option>
                                </select>
                            </div>                        
                        </div>                   

                                                 

                        <div class="form-group">  
                            <label class="col-sm-1 control-label">Miss Punch Date</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="miss_pun_date" name="miss_pun_date" value="<?php echo $miss_pun_date; ?>" autocomplete="off" required>
                            </div>           

                            <label class="col-sm-1 control-label">Miss Punch Time</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="time" name="mp_time" value="<?php echo $miss_pun_time; ?>" autocomplete="off" required>
                            </div>
                        </div>                                         

                        <div class="form-group">            
                            <label class="col-sm-1 control-label">Reason</label>
                            <div class="col-sm-11">
                            <textarea type="text" class="form-control" id="mp_reason" name="mp_reason" autocomplete="off" required><?= $mp_reason;?></textarea> 
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-sm-1"><b>Approval Remarks</b></div>
                            <div class="col-sm-11">
                                <?php
                                if(($mp_status == "Pending For HR Approval" || $mp_status == "Pending For Management Approval") && $role == 'Admin'){
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
                                if($mp_status == "Pending For HOD Approval" && ($mp_hod_id == $emp_id || $role == 'Admin')){
                                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                                }  else if($mp_status == "Pending For HR Approval" && $role == 'Admin'){
                                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                                }  else if($mp_status == "Pending For Management Approval" && $role == 'Admin'){
                                     echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                                }  else if($mp_status == "Approved"){
                                    //Do Nothing
                                } else if($mp_status == "") {
                                    echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                                }
                            ?>
                            </div>
                            <div class="col-sm-2">
                            <?php
                                if($mp_status == "Pending For HOD Approval" && ($mp_hod_id == $emp_id || $role == 'Admin')){
                                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                                }  else if($mp_status == "Pending For HR Approval" && $role == 'Admin'){
                                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                                }  else if($mp_status == "Pending For Management Approval" && $role == 'Admin'){
                                     echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                                }  else if($mp_status == "Approved"){
                                    //Do Nothing
                                } else if($mp_status == ""){
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
            <th>HOD Approval By</th>
            <th>HOD Approval Date</th>
            <th>HR Approval By</th>
            <th>HR Approval Date</th>
            <th>Management Approval By</th>
            <th>Management Approval Date</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "select * from miss_punch where miss_pun_id = '".$miss_pun_id."'";
            $query = $this->db->query($sql);
            foreach($query->result() as $row){
                $created_by = $row->created_by;
                $created_date = $row->created_date;
                $hod_approval_by = $row->hod_approval_by;
                $hod_approval_date = $row->hod_approval_date;
                $hr_approval_by = $row->hr_approval_by;
                $hr_approval_date  = $row->hr_approval_date ;            
                $mgmt_app_by = $row->mgmt_app_by;
                $mgmt_app_date = $row->mgmt_app_dt;   
       ?>
        <tr>
            <td><?=$created_by;?></td>
            <td><?=$created_date;?></td>
            <td><?=$hod_approval_by;?></td>
            <td><?=$hod_approval_date;?></td>
            <td><?=$hr_approval_by;?></td>
            <td><?=$hr_approval_date; ?></td>
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

$( function() {
    $( "#miss_pun_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

//Select2
$(function(){
    $("#mp_emp_id").select2();
});


$( function() {
    $( "#time" ).timepicker({
        "timeFormat" : "HH:mm",
        "interval" : 15 
    });
} );
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>
