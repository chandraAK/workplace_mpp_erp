<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Leave Application</h3>
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

    $from_date = date("Y")."-01-01";
    $to_date = date("Y")."-12-31";
    ?>
    
    <?php
        $leave_id = $_REQUEST['id'];
        if($leave_id != ''){
            foreach($get_by_id->result() as $row){
                $leave_emp_id = $row->leave_emp_id;
                $reports_to = $row->reports_to;
                $leave_type = $row->leave_type;
                $leave_from_date = $row->leave_from_date;
                $leave_days = $row->leave_days;
                $leave_to_date = $row->leave_to_date;
                $is_halfday = $row->is_halfday;
                $half_day_type = $row->half_day_type;
                $half_day_date = $row->half_day_date;
                $leave_status = $row->leave_status;
                $leave_remarks = $row->leave_remarks;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$leave_emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name;

                $app_rmks_hr = $row->app_rmks_hr;
                $app_rmks_mgmt = $row->app_rmks_mgmt;
            }
        } else {
            $leave_emp_id = "";
            $reports_to = "";
            $leave_type = "";
            $leave_from_date = "";
            $leave_to_date = "";
            $leave_days = "";
            $is_halfday = "";
            $half_day_type = "";
            $half_day_date = "";
            $leave_status = "";
            $leave_remarks = "";
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
            <?php if($leave_status == "Pending For HOD Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_app_hod">
            <?php }  else if($leave_status == "Pending For HR Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_app_hr">
            <?php } else if($leave_status == "Pending For Management Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_app_mng">
            <?php }  else if($leave_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/leave_entry" onsubmit="return reqd()">
            <?php } ?>
                <input type="hidden" class="form-control" id="leave_id" name="leave_id" value="<?php echo $leave_id; ?>">
                <input type="hidden" class="form-control" id="curr_date" name="curr_date" value="<?php echo date("Y-m-d"); ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($leave_id != ''){
                                echo "<b style='font-size:18px'>No-".$leave_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($leave_id != ''){
                                echo "<b style='font-size:18px'>Status-".$leave_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-5">
                        <select id="leave_emp_id" name="leave_emp_id" class="form-control" onchange="leave_alloc(this.value);"  required>
                            <?php 
                                if($leave_id != ''){ 
                            ?>
                                <option value="<?=$leave_emp_id; ?>" selected><?php echo $leave_emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12" id="detail">
                        <input type="hidden" id="Casual_Leave" name="Casual_Leave" value="0">
                        <input type="hidden" id="Sick_Leave" name="Sick_Leave" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Leave Type</label>
                    <div class="col-sm-2">
                        <select id="leave_type" name="leave_type" class="form-control" required>
                            <option value="<?=$leave_type;?>"><?=$leave_type;?></option>
                            <option value="Casual_Leave">Casual_Leave</option>
                            <option value="Sick_Leave">Sick_Leave</option>                           
                            <option value="Without_Pay_Leave">Without_Pay_Leave</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">From Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="leave_from_date" name="leave_from_date" value="<?=$leave_from_date;?>" onclick="cal_days()" autocomplete="off" required>
                    </div>

                    <label class="col-sm-1 control-label">To Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="leave_to_date" name="leave_to_date" value="<?=$leave_to_date;?>" onclick="cal_days()" autocomplete="off" required>
                    </div>

                    <label class="col-sm-1 control-label">Halfday</label>
                    <div class="col-sm-2">
                        <input type="checkbox" id="is_halfday" name="is_halfday" onclick="cal_days()" <?php if($is_halfday > 0){echo "checked"; } ?> >
                    </div>
                </div>

                <div class="form-group" id="halfdaydiv" <?php if($leave_status == ""){ ?>style="display:none"<?php } ?>>
                    <label class="col-sm-1 control-label">Half Day Type</label>
                    <div class="col-sm-2">
                        <select id="half_day_type" name="half_day_type" class="form-control">
                            <?php if($leave_status != ""){ ?>
                                <option value="<?=$half_day_type;?>"><?=$half_day_type;?></option>
                            <?php } else { ?>
                                <option value="">--select--</option>
                            <?php } ?>
                            <option value="First Half">First Half</option>
                            <option value="Second Half">Second Half</option>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Halfday Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="half_day_date" name="half_day_date" value="<?=$half_day_date;?>" autocomplete="off" onclick="cal_days()">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Total Days</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="tot_days" name="tot_days" value="<?=$leave_days;?>" autocomplete="off" required readonly>
                    </div>
                </div>
                    
                <div class="form-group">
                    <label class="col-sm-1 control-label">Remarks</label>
                    <div class="col-sm-11">
                        <textarea type="text" class="form-control" id="leave_remarks" name="leave_remarks" autocomplete="off" required onkeypress="cal_days()"><?=$leave_remarks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($leave_status == "Pending For HR Approval" || $leave_status == "Pending For Management Approval") && $role == 'Admin'){
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
                            if($leave_status == "Pending For HOD Approval" && ($reports_to == $emp_id || $role == 'Admin')){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($leave_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($leave_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($leave_status == "Approved"){
                                //Do Nothing
                            } else if($leave_status == "") {
                                echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                            }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                            if($leave_status == "Pending For HOD Approval" && ($reports_to == $emp_id || $role == 'Admin')){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($leave_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($leave_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($leave_status == "Approved"){
                                //Do Nothing
                            } else if($leave_status == "") {
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
    
    <?php if($leave_emp_id != ""){?>
    <h3>Leave Allocation</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2">Allocated</th>
                <th colspan="2">Availed</th>
                <th colspan="2">Pending</th>
            </tr>
            <tr>
                <th>Leave Type</th>
                <th>Leaves</th>
                <th>Leave Type</th>
                <th>Leaves</th>
                <th>Leave Type</th>
                <th>Leaves</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql_cnt = "select count(*) as cnt from `tabLeave Allocation` 
                where employee = '".$leave_emp_id."'
                and from_date between '".$from_date."' and '".$to_date."'
                and to_date between '".$from_date."' and '".$to_date."'";

                $qry_cnt = $db2->query($sql_cnt)->row();

                $cnt = $qry_cnt->cnt;

                if($cnt > 0){

                    $sql = "select distinct `tabLeave Allocation`.leave_type from `tabLeave Allocation` 
                    where employee = '".$leave_emp_id."'
                    and from_date between '".$from_date."' and '".$to_date."'
                    and to_date between '".$from_date."' and '".$to_date."'";

                    //echo $sql; die;

                    $qry = $db2->query($sql);
                    foreach($qry->result() as $row){
                        $leave_type = $row->leave_type;
                ?>
                <tr>
                    <td><?=$leave_type;?></td>
                    <td><?=$leave_alloc = number_format(lv_allocated($leave_emp_id, $leave_type, $from_date, $to_date),2,".","");?></td>
                    <td><?=$leave_type;?></td>
                    <td><?=$leave_avail = number_format(lv_availed($leave_emp_id, $leave_type, $from_date, $to_date),2,".",""); ?></td>
                    <td><?=$leave_type;?></td>
                    <td><?php echo number_format($leave_alloc-$leave_avail,2,".",""); ?></td>
                </tr>
            <?php
                    }
                } 
            ?>                
        </tbody>
    </table>
    <?php } ?>

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
                $sql = "select * from leave_mst where leave_id = '".$leave_id."'";
                $query = $this->db->query($sql);
                foreach($query->result() as $row){
                    $created_by = $row->created_by;
                    $created_date = $row->created_date;
                    $hod_app_by = $row->hod_app_by;
                    $hod_app_date = $row->hod_app_date;
                    $hr_app_by = $row->hr_app_by;
                    $hr_app_date  = $row->hr_app_date ;            
                    $mgmt_app_by = $row->mgmt_app_by;
                    $mgmt_app_date = $row->mgmt_app_date;   
        ?>
            <tr>
                <td><?=$created_by;?></td>
                <td><?=$created_date;?></td>
                <td><?=$hod_app_by;?></td>
                <td><?=$hod_app_date;?></td>
                <td><?=$hr_app_by;?></td>
                <td><?=$hr_app_date; ?></td>
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

<script type="text/javascript">
    $(function(){
        $("#is_halfday").click(function () {
            if ($(this).is(":checked")) {
                $("#halfdaydiv").show();
                $("#half_day_type").prop('required', true);
                $("#half_day_date").prop('required', true);
            } else {
                $("#halfdaydiv").hide();
                $("#half_day_type").prop('required', false);
                $("#half_day_date").prop('required', false);
            }
        });
    });
</script>

                                 
<script>
var today = new Date();

$( function() {
    $( "#leave_from_date" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        "minDate" : today
    });
} );

$( function() {
    $( "#leave_to_date" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        "minDate" : today
    });
} );

//Select2
$(function(){
    $("#leave_emp_id").select2();
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
function leave_alloc(emp_id){
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
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/leave_alloc_ajax" + queryString,true);
        xmlhttp.send();
}
</script>

<script>
function cal_days(){
    var leave_from_date = document.getElementById("leave_from_date").value;
    var leave_to_date = document.getElementById("leave_to_date").value;
    var is_halfday = document.getElementById("is_halfday").checked;
    var half_day_date = document.getElementById("half_day_date").value;
    var hd = 0;
    
    if(leave_from_date == ""){
        //alert("Please select from date.");
        document.getElementById("leave_from_date").focus();
        return false;
    }

    if(leave_to_date == ""){
        //alert("Please select To date.");
        document.getElementById("leave_to_date").focus();
        return false;
    }

    //define two date object variables with dates inside it
    var date1 = new Date(leave_from_date); 
    var date2 = new Date(leave_to_date);

    if(date2 < date1){
        alert("Leave To Date Cannot Be Less Than Leave From Date");
        return false;
    }

    //alert(hd);

    //calculate time difference  
    var time_difference = date2.getTime() - date1.getTime();  

    //calculate days difference by dividing total milliseconds in a day  
    var days_difference = time_difference / (1000 * 60 * 60 * 24)+1;

    
    if(is_halfday == true){
        var date3 = new Date(half_day_date);
        hd = 0.5;

        $( function() {
            $( "#half_day_date" ).datepicker({
                "dateFormat" : "yy-mm-dd",
                "minDate" : date1,
                "maxDate" : date2
            });
        } );  
    }

    //alert(hd);
    
    var days_difference1 = days_difference-hd;

    //alert(days_difference);
    document.getElementById("tot_days").value = days_difference1;

}
</script>
<script>
function reqd(){
    var tot_days = document.getElementById("tot_days").value;
    var leave_type = document.getElementById("leave_type").value;
    var Casual_Leave = document.getElementById("Casual_Leave").value;
    var Sick_Leave = document.getElementById("Sick_Leave").value;
    var leave_from_date = document.getElementById("leave_from_date").value;
    var leave_to_date = document.getElementById("leave_to_date").value; 
    var curr_date = document.getElementById("curr_date").value; 

    if(tot_days > 2 && leave_type == 'Casual_Leave'){
        alert("Casual Leave Cannot be applied for more than 2 Days.");
        return false;
    }

    if(tot_days > 2 && leave_type == 'Sick_Leave'){
        alert("Sick Leave Cannot be applied for more than 2 Days.");
        return false;
    }

    if(tot_days > Sick_Leave && leave_type == 'Sick_Leave'){
        alert("Sick Leave Cannot be applied for more than Pending Sick Leaves in System.");
        return false;
    }

    if(tot_days > Casual_Leave && leave_type == 'Casual_Leave'){
        alert("Casual Leave Cannot be applied for more than Pending Casual Leaves in System.");
        return false;
    }

    if(leave_type == 'Casual_Leave' && leave_from_date <= curr_date ){
        alert("Casual Leave Cannot be applied for Todays Date and Less Than Todays Date.");
        return false;   
    }
}
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>
