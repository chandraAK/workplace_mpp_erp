<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$from_dt = $_REQUEST['from_dt'];
$to_dt = $_REQUEST['to_dt'];
$status = $_REQUEST['status'];
$shift_type = $_REQUEST['shift_type'];
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php echo att_det_tot($status, $from_dt, $to_dt, $shift_type);?>
    </div>
</div>