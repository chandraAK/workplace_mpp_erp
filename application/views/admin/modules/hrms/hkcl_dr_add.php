<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Housekeeping & Construction Labour Dr</h3>
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
        $hkcl_dr_id = $_REQUEST['id'];
        if($hkcl_dr_id != ''){
            foreach($get_by_id->result() as $row){
                $dr_date = $row->dr_date;
                $dr_type = $row->dr_type;
                $dr_comp = $row->dr_comp;
                $dr_name = $row->dr_name;
                $dr_status = $row->dr_status;
            }
        } else {
            $dr_date = "";
            $dr_type = "";
            $dr_comp = "";
            $dr_name = "";
            $dr_status = "";
        }
        
    ?>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading"></header>
            <div class="panel-body">
            
            <?php if($dr_status == "Pending For Management Approval"){ ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/hkcl_dr_app_mng">
            <?php }  else if($dr_status == "Approved"){ ?>
                <!--Do Nothing-->
                <form class="form-horizontal" id="myForm" method="post" action="">
            <?php } else { ?>
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/hkcl_dr_entry">
            <?php } ?>
                <input type="hidden" class="form-control" id="hkcl_dr_id" name="hkcl_dr_id" value="<?php echo $hkcl_dr_id; ?>">
                
                <div class="form-group">
                    <div class="col-sm-6" style="text-align:left">
                        <?php
                            if($hkcl_dr_id != ''){
                                echo "<b style='font-size:18px'>No-".$hkcl_dr_id."</b>";
                            }
                        ?>
                    </div>
                    <div class="col-sm-6"  style="text-align:right">
                        <?php
                            if($hkcl_dr_id != ''){
                                echo "<b style='font-size:18px'>Status-".$dr_status."</b>";
                            }
                        ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">DR Date</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="dr_date" name="dr_date" value="<?=$dr_date;?>" autocomplete="off" required>
                    </div>

                    <label class="col-sm-1 control-label">DR Type</label>
                    <div class="col-sm-2">
                        <select id="dr_type" name="dr_type" class="form-control" required>
                            <option value="<?=$dr_type;?>"><?=$dr_type;?></option>
                            <option value="Housekeeping">Housekeeping</option>
                            <option value="Construction">Construction</option>
                        </select>
                    </div>

                    <label class="col-sm-1 control-label">Company</label>
                    <div class="col-sm-2">
                        <select id="dr_comp" name="dr_comp" class="form-control" required>
                            <option value="<?=$dr_comp;?>"><?=$dr_comp;?></option>
                            <option value="PNI">PNI</option>
                            <option value="MPP">MPP</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="dr_name" name="dr_name" value="<?=$dr_name;?>" autocomplete="off" required>
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
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($hkcl_dr_id != ''){
                                $sql_itm_list = "select * from hkcl_dr_det where hkcl_dr_id ='".$hkcl_dr_id."'";
                                $qry_itm_list = $this->db->query($sql_itm_list);

                                $cnt = 0;
                                foreach($qry_itm_list->result() as $row){
                                    $cnt++;
                                    $dr_details = $row->dr_details;
                            ?>
                            <tr>
                                <td>
                                    <input type="text" id="dr_details" name="dr_details[]" value="<?=$dr_details;?>" class="form-control" required>
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
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <?php
                            if($dr_status == "Pending For Management Approval" && $role == 'Admin'){
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
                            if($dr_status == "Pending For Management Approval" && $role == 'Admin'){
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
                <th>Management Approval By</th>
                <th>Management Approval Date</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "select * from hkcl_dr_mst where hkcl_dr_id = '".$hkcl_dr_id."'";
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
$( function() {
    $( "#dr_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
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