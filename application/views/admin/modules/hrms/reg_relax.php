<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Regular Relaxation</h3>
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

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading"></header>
            <div class="panel-body">
                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/reg_relax_entry">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Employee Type</label>
                        <div class="col-sm-2">
                            <select id="relax_emp_type" name="relax_emp_type" class="form-control" required>
                                <option value="">--Select--</option>
                                <option value="0">Type 1</option>
                                <option value="1">Type 2</option>  
                            </select>
                        </div>

                        <label class="col-sm-2 control-label">Relaxation Time (Minutes)</label>
                        <div class="col-sm-2">
                            <input type="text" id="relax_time" name="relax_time" class="form-control" required onkeypress="return isNumberKey(event);">
                        </div>

                        <label class="col-sm-1 control-label">Applicable Date</label>
                        <div class="col-sm-2">
                            <input type="text" id="relax_app_date" name="relax_app_date" class="form-control" required>
                        </div>

                        <div class="col-sm-2">
                            <input type="submit" class="form-control" id="submit1" name="submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-1"></div>
        </section>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Emp Type</th>
                        <th>Time</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `reg_relax` order by created_date desc";
                    $qry = $this->db->query($sql);
                    foreach($qry->result() as $row){
                    ?>
                    <tr>
                        <td><?=$row->relax_emp_type;?></td>
                        <td><?=$row->relax_time;?></td>
                        <td><?=$row->created_by;?></td>
                        <td><?=$row->created_date;?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-1"></div>
    </div>
  </section>
</section>
                                 
<script>
var today = new Date();

$( function() {
    $( "#relax_app_date" ).datepicker({
        "dateFormat" : "yy-mm-dd",
        "minDate" : today
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
