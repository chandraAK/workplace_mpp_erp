<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php
$status = $_REQUEST['status'];
$url = "sal_adv_add?id=";
?>

<?php 
    $username = $_SESSION['username'];
    $sql_user_det = "select * from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $email = $qry_user_det->email;
    $name = $qry_user_det->name;
    $emp_id1 = $qry_user_det->emp_id;
    $role = $qry_user_det->role;
?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Salary Advance </h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <form action="<?php echo base_url(); ?>index.php/hrmsc/sa_stages_all_sbmt" method="post">
    <div class="row">
        <div class="col-lg-12">
                <input type="hidden" id="status" name="status" value="<?=$status;?>">
                <?php echo case_det_sa_all($status, $url); ?>
        </div>
    </div><br>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-2">
            <?php                        
                if($status == "Pending For HR Approval" && $role == 'Admin'){
                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                }  else if($status == "Pending For Management Approval" && $role == 'Admin'){
                        echo '<input type="submit" class="form-control" id="submit" name="submit" value="Approve">';
                }  else if($status == "Approved"){
                    //Do Nothing
                } else if($status == "") {
                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Submit">';
                }
            ?>
        </div>
        <div class="col-sm-2">
            <?php                    
                    
                if($status == "Pending For HR Approval" && $role == 'Admin'){
                    echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                }  else if($status == "Pending For Management Approval" && $role == 'Admin'){
                        echo '<input type="submit" class="form-control" id="submit" name="submit" value="Reject">';
                }  else if($status == "Approved"){
                    //Do Nothing
                } else if($status == "") {
                }
            ?>
        </div>
        <div class="col-sm-4"></div>
    </div>
    </form>

  </section>
</section>