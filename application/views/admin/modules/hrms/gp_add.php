<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Gate Pass Application</h3>
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

    //Reports To ID
    $sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";
    $qry_reports_to = $db2->query($sql_reports_to)->row();
    $reports_to = $qry_reports_to->reports_to;

    //Reports To Name, Email
    $sql_rp = "select employee_name, prefered_email from `tabEmployee` where name = '".$reports_to."'";
    $qry_rp = $db2->query($sql_rp)->row();
    $reports_to_name = $qry_rp->employee_name;
    $prefered_email = $qry_rp->prefered_email;

    ?>
    
    <?php
        $gp_id = $_REQUEST['id'];
        if($gp_id != ''){
            foreach($get_by_id->result() as $row){
                $gp_emp_id = $row->gp_emp_id;
                $gp_emp_name = $row->gp_emp_name;
                $gp_date = $row->gp_date;
                $gp_from_datetime = $row->gp_from_datetime;
                $gp_to_datetime = $row->gp_to_datetime;
                $gp_type = $row->gp_type;
                $gp_permission = $row->gp_permission;
                $gp_remarks = $row->gp_remarks;
                $gp_reports_to = $row->gp_reports_to;
                $gp_status = $row->gp_status;
                $created_by = $row->created_by;
                $created_date = $row->created_date;

                //Reports To Name, Email
                $sql_rp = "select employee_name, prefered_email from `tabEmployee` where name = '".$gp_reports_to."'";
                $qry_rp = $db2->query($sql_rp)->row();
                $reports_to_name = $qry_rp->employee_name;
                $prefered_email = $qry_rp->prefered_email;
            }
        } else {
            $gp_emp_id = "";
            $gp_emp_name = "";
            $gp_date = "";
            $gp_from_datetime = "";
            $gp_to_datetime = "";
            $gp_type = "";
            $gp_permission = "";
            $gp_remarks = "";
            $gp_reports_to = "";
            $gp_status = "";
            $created_by = "";
            $created_date = "";
        }
    ?>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading"></header>
            <div class="panel-body">
            <div class="panel-body">
            <?php if($mp_status == "Fresh"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/gp_sfa">
            <?php } else if($gp_status == "Pending For HOD Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/gp_app_hod">
            <?php }  else if($gp_status == "Pending For HR Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/gp_app_hr">
            <?php }  else if($gp_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/gp_entry">
            <?php } ?>
                <input type="hidden" class="form-control" id="gp_id" name="gp_id" value="<?php echo $gp_id; ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($gp_id != ''){
                                echo "<b style='font-size:18px'>Gate Pass No-".$gp_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($gp_id != ''){
                                echo "<b style='font-size:18px'>Status-".$gp_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee ID</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="gp_emp_id" name="gp_emp_id" value="<?php if($gp_id != ''){ echo $gp_emp_id; } else { echo $emp_id; }; ?>" required readonly>
                    </div>

                    <label class="col-sm-1 control-label">Employee Name</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="gp_emp_name" name="gp_emp_name" value="<?php if($gp_id != ''){ echo $gp_emp_name; } else { echo $name; }; ?>" readonly>
                    </div>

                    <label class="col-sm-1 control-label">Report To</label>
                    <div class="col-sm-3">
                        <input type="hidden" class="form-control" id="gp_reports_to" name="gp_reports_to" value="<?php echo $reports_to; ?>">
                        <input type="hidden" class="form-control" id="gp_reports_email" name="gp_reports_email" value="<?php echo $prefered_email; ?>">
                        <input type="text" class="form-control" id="gp_reports_to_name" name="gp_reports_to_name" value="<?php echo $reports_to_name; ?>" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Date</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="gp_date" name="gp_date" value="<?=$gp_date;?>" required>
                    </div>

                    <label class="col-sm-1 control-label">From</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="gp_from_datetime" name="gp_from_datetime" value="<?=$gp_from_datetime;?>" required>
                    </div>

                    <label class="col-sm-1 control-label">To</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="gp_to_datetime" name="gp_to_datetime" value="<?=$gp_to_datetime;?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Type</label>
                    <div class="col-sm-3">
                        <select id="gp_type" name="gp_type" class="form-control" required>
                            <option value="<?=$gp_type;?>"><?=$gp_type;?></option>
                            <option value="Personal">Personal</option>
                            <option value="Official">Official</option>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Permission</label>
                    <div class="col-sm-3">
                        <select id="gp_permission" name="gp_permission" class="form-control" required>
                            <option value="<?=$gp_permission;?>"><?=$gp_permission;?></option>
                            <option value="Without Pay">Without Pay</option>
                            <option value="With Pay">With Pay</option>
                        </select>
                    </div> 
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Remarks</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="gp_remarks" name="gp_remarks"><?=$gp_remarks;?></textarea>
                    </div>  
                </div>

                <div class="form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit1" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-5"></div>
                </div>
            </form>
            </div>
            <div class="col-lg-1"></div>
        </section>
        </div>
    </div>
  </section>
</section>

<script>
$( function() {
    $( "#gp_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

$( function() {
    $( "#gp_from_datetime" ).timepicker({
        "timeFormat" : "h:mm:ss p",
        "interval" : 15 
    });
} );

$( function() {
    $( "#gp_to_datetime" ).timepicker({
        "timeFormat" : "h:mm:ss p",
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
</script>

<script>
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>