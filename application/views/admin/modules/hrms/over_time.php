<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Over Time Application Form</h3>
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
        $over_tim_id = $_REQUEST['id'];
        if($over_tim_id != ''){
            foreach($get_by_id->result() as $row){
                $over_tim_id =$row->over_tim_id;
                $ot_reports_to=$row->ot_reports_to;              
                $ot_emp_id= $row->ot_emp_id;
                $ot_frm_date= $row->ot_frm_date;
                $ot_to_date= $row->ot_to_date;
                $ot_remarks= $row->ot_remarks;
                $ot_frm_time= $row->ot_frm_time;
                $ot_to_time= $row->ot_to_time;
                $ot_tot_hrs = $row->ot_tot_hrs;
                $ot_status =  $row->ot_status;
                $created_by= $row->created_by;
                $created_date= $row->created_date;
                $modified_by= $row->modified_by;
                $modified_date= $row->modified_date;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$ot_emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name;

                $app_rmks_hr = $row->app_rmks_hr;
                $app_rmks_mgmt = $row->app_rmks_mgmt;                   
              
            }
        } else {
            $over_tim_id  = "";
            $ot_reports_to = "";           
            $ot_emp_id = "";
            $ot_frm_date= "";
            $ot_to_date  = "";
            $ot_frm_time="";
            $ot_remarks = "";
            $ot_to_time="";
            $ot_tot_hrs =""; 
            $ot_status = "";         
            $created_by ="";
            $created_by = "";
            $created_date ="";
            $modified_by="";

            $employee_name = "";
            $app_rmks_hr = "";
            $app_rmks_mgmt = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading" style="font-size:18px"><b>
                Over Time Application Form</b>
            </header>

            <div class="panel-body">
            <?php if($ot_status == "Pending For HOD Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/ot_app_hod">
            <?php }  else if($ot_status == "Pending For HR Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/ot_app_hr">
            <?php } else if($ot_status == "Pending For Management Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/ot_app_mng">
            <?php }  else if($ot_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/over_time_entry">
            <?php } ?>
                <input type="hidden" class="form-control" id="over_tim_id" name="over_tim_id" value="<?php echo $over_tim_id; ?>">
                
            
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($over_tim_id != ''){
                                echo "<h4>".$over_tim_id."</h4>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($over_tim_id != ''){
                                echo "<b style='font-size:18px'>Status-".$ot_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-3">
                        <select id="ot_emp_id" name="ot_emp_id" class="form-control"   required>
                            <?php 
                                if($over_tim_id != ''){ 
                            ?>
                                <option value="<?=$ot_emp_id; ?>" selected><?php echo $ot_emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>
                    <label class="col-sm-1 control-label">From Date</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="frm_dt" name="ot_frm_date" value="<?php echo $ot_frm_date; ?>" autocomplete="off" required >
                    </div>

                    <label class="col-sm-1 control-label">From Time</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="frm_time" name="ot_frm_time" value="<?php echo $ot_frm_time; ?>" autocomplete="off" required >
                     </div> 
                     </div> 
                     
                     <div class="form-group">       
                     <label class="col-sm-1 control-label">To Date</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="to_dt" name="ot_to_date" value="<?php echo $ot_to_date; ?>"  autocomplete="off" required >
                    </div>

                    <label class="col-sm-1 control-label">To Time</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="to_time" name="ot_to_time" value="<?php echo $ot_to_time; ?>" autocomplete="off" required >
                     </div>
                     </div>
                    
                    <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="ot_remarks" name="ot_remarks" autocomplete="off"  required onclick="check_date();"><?=$ot_remarks;?></textarea>
                    </div>  
                </div> 

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($ot_status == "Pending For HR Approval" || $ot_status == "Pending For Management Approval") && $role == 'Admin'){
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
                    <div class="col-sm-3"></div>
                    <div class="col-sm-2">
                        <?php
                            if($ot_status == "Pending For HOD Approval" && ($ot_reports_to == $emp_id || $role == 'Admin')){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($ot_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($ot_status == "Pending For Management Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($ot_status == "Approved"){
                                //Do Nothing
                            } else if($ot_status == "") {
                                echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                            }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                            if($ot_status == "Pending For HOD Approval" && ($ot_reports_to == $emp_id || $role == 'Admin')){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($ot_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($ot_status == "Pending For Management Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($ot_status == "Approved"){
                                //Do Nothing
                            } else if($ot_status == "") {
                            }
                        ?>
                    </div>
                    <div class="col-sm-3"></div>
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
            $sql = "select * from over_time where over_tim_id = '".$over_tim_id."'";
            $query = $this->db->query($sql);
            foreach($query->result() as $row){
                $created_by = $row->created_by;
                $created_date = $row->created_date;
                $hod_app_by = $row->hod_app_by;
                $hod_app_date = $row->hod_app_date;
                $hr_app_by = $row->hr_app_by;
                $hr_app_date  = $row->hr_app_date ;            
                $mgm_app_by = $row->mgm_app_by;
                $mgm_app_date = $row->mgm_app_date;   
       ?>
        <tr>
            <td><?=$created_by;?></td>
            <td><?=$created_date;?></td>
            <td><?=$hod_app_by;?></td>
            <td><?=$hod_app_date;?></td>
            <td><?=$hr_app_by;?></td>
            <td><?=$hr_app_date; ?></td>
            <td><?=$mgm_app_by; ?></td>
            <td><?=$mgm_app_date; ?></td>
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
    $( "#frm_dt" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        "minDate" : "-2d"
    });
} );

$( function() {
    $( "#to_dt" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        "minDate" : "-2d"
    });
} );

function calculate(){
    var time1 = $("#frm_time").val();
    var time2 = $("#to_time").val();
    var time1 = time1.split(':');
    var time2 = time2.split(':');
    var hours1 = parseInt(time1[0], 10), 
    hours2 = parseInt(time2[0], 10),
    mins1 = parseInt(time1[1], 10),
    mins2 = parseInt(time2[1], 10);
    var hours = hours2 - hours1, mins = 0;
    if(hours < 0) hours = 24 + hours;
    if(mins2 >= mins1) {
        mins = mins2 - mins1;
    }
    else {
      mins = (mins2 + 60) - mins1;
      hours--;
    }
    if(mins < 9)
    {
      mins = '0'+mins;
    }
    if(hours < 9)
    {
      hours = '0'+hours;
    }
    $("#tot_hrs").val(hours+':'+mins);
  }
  $(function(){
    $("#ot_emp_id").select2();
});

$( function() {
    $( "#frm_time" ).timepicker({
        "timeFormat" : "HH:mm",
        "interval" : 15 
    });
} );

$( function() {
    $( "#to_time" ).timepicker({
        "timeFormat" : "HH:mm",
        "interval" : 15 
    });
} );
//Restricting Only to insert Numbers
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

    return true;
  
}

function check_date(){     
    var startDate = new Date($('#frm_dt').val());
    var endDate = new Date($('#to_dt').val());

    if (startDate > endDate){
        alert("To date should be greater than From date");
    }
}

</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>
