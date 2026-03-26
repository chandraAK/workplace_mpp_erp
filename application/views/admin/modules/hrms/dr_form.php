<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    echo "<h2 style='color:red'>DR not allowed in workplace.</h2>"; die;
?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Tour DR Application</h3>
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
        $dr_id = $_REQUEST['id'];
        if($dr_id != ''){
            foreach($get_by_id->result() as $row){
                $dr_emp_id = $row->dr_emp_id;
                $dr_date = $row->dr_date;
                $dr_att_type = $row->dr_att_type;
                $reports_to = $row->reports_to;
                $dr_status = $row->dr_status;

                $sql_emp_name = "select emp_name from emp_rep_to_mst where emp_id = '".$dr_emp_id."'";
                $qry_emp_name = $this->db->query($sql_emp_name)->row();
                $employee_name = $qry_emp_name->emp_name;

                $app_rmks_hr = $row->app_rmks_hr;
                $app_rmks_mgmt = $row->app_rmks_mgmt;
            }
        } else {
            $dr_emp_id = "";
            $dr_date = "";
            $dr_att_type = "";
            $dr_status = "";
            $reports_to = "";
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
            
            <?php if($dr_status == "Pending For HOD Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/dr_app_hod">
            <?php }  else if($dr_status == "Pending For HR Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/dr_app_hr">
            <?php } else if($dr_status == "Pending For Management Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/dr_app_mng">
            <?php }  else if($dr_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/dr_entry" onsubmit="return reqd()">
            <?php } ?>
                <input type="hidden" class="form-control" id="dr_id" name="dr_id" value="<?php echo $dr_id; ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($dr_id != ''){
                                echo "<b style='font-size:18px'>No-".$dr_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($dr_id != ''){
                                echo "<b style='font-size:18px'>Status-".$dr_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-5">
                        <select id="dr_emp_id" name="dr_emp_id" class="form-control" required>
                            <?php 
                                if($dr_id != ''){ 
                            ?>
                                <option value="<?=$dr_emp_id; ?>" selected><?php echo $dr_emp_id." - ".$employee_name;?></option>
                            <?php 
                                } 
                            ?>
                            <?php echo EmpId(); ?>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">DR Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="dr_date" name="dr_date" value="<?=$dr_date;?>" autocomplete="off" required>
                    </div>

                    <label class="col-sm-1 control-label">Attendence Type</label>
                    <div class="col-sm-2">
                        <select id="dr_att_type" name="dr_att_type" class="form-control" required>
                            <option value="<?=$dr_att_type;?>"><?=$dr_att_type;?></option>
                            <option value="Half_Day">Half_Day</option>
                            <option value="Full_Day">Full_Day</option>                           
                            <option value="Absent">Absent</option>
                            <option value="WFH">WFH</option>
                        </select>
                    </div>
                </div>

                <!--- DR Details -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h4>DR Details</b></h4></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Tasks</th>
                                <th>Tour Location</th>
                                <th>From Time</th>
                                <th>To Time</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($dr_id != ''){
                                $sql_itm_list = "select * from dr_hrms_dtl where dr_id ='".$dr_id."'";
                                $qry_itm_list = $this->db->query($sql_itm_list);

                                $cnt = 0;
                                foreach($qry_itm_list->result() as $row){
                                    $cnt++;
                                    $dr_details = $row->dr_details;
                                    $dr_tour_loc = $row->dr_tour_loc;
                                    $dr_from_time = $row->dr_from_time;
                                    $dr_to_time = $row->dr_to_time;
                            ?>
                            <tr>
                                <td>
                                    <input type="text" id="dr_details" name="dr_details[]" value="<?=$dr_details;?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" id="dr_tour_loc" name="dr_tour_loc[]" value="<?=$dr_tour_loc;?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" id="dr_from_time" name="dr_from_time[]" value="<?=$dr_from_time;?>" class="form-control">
                                </td>
                                <td>
                                    <input type="text" id="dr_to_time" name="dr_to_time[]" value="<?=$dr_to_time;?>" class="form-control">
                                </td>
                                <td>
                                    <span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>
                                </td>
                             </tr>
                            <?php
                                }    
                            } else {
                            ?>
                            <tr>
                                <td>
                                    <input type="text" id="dr_details" name="dr_details[]" value="" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" id="dr_tour_loc" name="dr_tour_loc[]" value="" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" id="dr_from_time" name="dr_from_time[]" value="" class="form-control">
                                </td>
                                <td>
                                    <input type="text" id="dr_to_time" name="dr_to_time[]" value="" class="form-control">
                                </td>
                                <td>
                                    <span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>
                                </td>
                             </tr>
                            <?php    
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <div class="col-sm-1"><b>Approval Remarks</b></div>
                    <div class="col-sm-11">
                        <?php
                        if(($dr_status == "Pending For HR Approval" || $dr_status == "Pending For Management Approval") && $role == 'Admin'){
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
                            if($dr_status == "Pending For HOD Approval" && ($reports_to == $emp_id || $role == 'Admin')){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($dr_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($dr_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                            }  else if($dr_status == "Approved"){
                                //Do Nothing
                            } else if($dr_status == "") {
                                echo '<input type="submit" class="form-control" id="submit1" name="submit" value="Submit">';
                            }
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php
                            if($dr_status == "Pending For HOD Approval" && ($reports_to == $emp_id || $role == 'Admin')){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($dr_status == "Pending For HR Approval" && $role == 'Admin'){
                                echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($dr_status == "Pending For Management Approval" && $role == 'Admin'){
                               echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                            }  else if($dr_status == "Approved"){
                                //Do Nothing
                            } else if($dr_status == "") {
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
                $sql = "select * from dr_hrms_mst where dr_id = '".$dr_id."'";
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
                                 
<script>
var today = new Date();

$( function() {
    $( "#dr_date" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        "minDate" : today,
        "maxDate" : today
    });
} );

//Timepicker
$( function() {
    $( "#dr_from_time" ).timepicker({
        "timeFormat" : "HH:mm",
        "interval" : 15 
    });
} );

$( function() {
    $( "#dr_to_time" ).timepicker({
        "timeFormat" : "HH:mm",
        "interval" : 15 
    });
} );

//Select2
$(function(){
    $("#dr_emp_id").select2();
});
</script>

<script>
function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<input type="text" id="dr_details" name="dr_details[]" value="" class="form-control" required>';

    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="dr_tour_loc" name="dr_tour_loc[]" value="" class="form-control" required>';

    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="dr_from_time" name="dr_from_time[]" value="" class="form-control">';

    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="dr_to_time" name="dr_to_time[]" value="" class="form-control">';
	
	
	var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>