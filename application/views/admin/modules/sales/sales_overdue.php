<?php
    $this->load-> helper('sales');
    $db2 = $this->load->database('db2', TRUE);  
?>

<section id="main-content">
    <section class="wrapper"> 
        <div class="row">
            <div class="col-lg-12">
                <h3><i class="fa fa-laptop"></i> Pending Reports</h3>
                <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
            </div> 
        </div>

        <?php echo get_pending_payment();?>

    </section>
</section>
                        
        