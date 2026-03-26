<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>User Dashboard</h3>
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
        $user_id = $qry_user_det->id;
    ?>
    
    <div class="row" style="text-align:center">
        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/dbuserc/add_user?id=<?=$user_id;?>">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Update User Details
            </a>
        </div>

    	<div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/dbuserc/ViewList">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                User List
            </a>
        </div>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/dbuserc/UserRightList">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Manage Rights
            </a>
        </div>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/dbuserc/module_list">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Module Register
            </a>
        </div>

        <div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/dbuserc/masters_db">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Masters
            </a>
        </div>
    </div>

  </section>
</section>