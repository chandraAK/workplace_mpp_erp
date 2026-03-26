<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>MPP Production Employees & Others Add</h3>
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
        /*
        $sal_adv_id = $_REQUEST['id'];
        if($sal_adv_id != ''){
            foreach($get_by_id->result() as $row){
                $emp_id = $row->emp_id;
                $sal_adv_req = $row->sal_adv_req;
                $sal_adv_rmks = $row->sal_adv_rmks;
                $status = $row->status;
                $reports_to = $row->reports_to;
                $created_by = $row->created_by;
                $created_date = $row->created_date;
            }
        } else {
            $emp_id = "";
            $sal_adv_req = "";
            $sal_adv_rmks = "";
            $status = "";
            $reports_to = "";
            $created_by = "";
            $created_date = "";
        }  */          

    ?>
   
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
        <section class="panel">
            <header class="panel-heading"></header>
            <div class="panel-body">

                <form class="form-horizontal" id="myForm" method="post" action="<?php echo base_url(); ?>index.php/hrmsc/mpp_prod_emp_entry">
                    
                <input type="hidden" class="form-control" id="emp_id" name="emp_id" value="">
                
                <div class="form-group">
                    <label class="col-sm-1 control-label">Employee Name</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="emp_name" name="emp_name" value="" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-1 control-label">Type</label>
                    <div class="col-sm-5">
                        <select id="type" name="type" class="form-control" required>
                            <option value="" selected disabled>--Select--</option>
                            <option value="Production">Production</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>  
                </div>
                
                <div class="row">
                    
                    <div class="col-lg-2">
                        <input type="submit" id="submit1" name="submit" value="Submit" class="form-control">
                    </div>
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
$('#myForm').on('submit', function () {
    $('#submit1').attr('disabled', 'disabled');
});
</script>