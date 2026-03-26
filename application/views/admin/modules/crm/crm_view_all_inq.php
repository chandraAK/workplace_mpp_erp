<?php $this->load->helper("crm"); ?>
<?php
    $status = $_REQUEST['status'];
    
    $sql_url_get = "select * from crm_stage_mst where stage_name = '".$status."'";
    $qry_url_get = $this->db->query($sql_url_get)->row();
    $url = $qry_url_get->stage_url;

?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>All <?=$status;?></h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <?php echo case_det($status, $url); ?>
        </div>
    </div>
    
  </section>
</section>