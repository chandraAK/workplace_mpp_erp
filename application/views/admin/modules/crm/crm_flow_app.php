<style>
	button.accordion {
		background-color:#ddd;
		color: #444;
		cursor: pointer;
		padding: 5px;
		width: 100%;
		border: none;
		text-align: center;
		font-weight:bold;
		outline: none;
		font-size: 14px;
		transition: 0.4s;
		border-radius:8px;
	}
	
	button.accordion.active, button.accordion:hover {
		background-color: #999999;
	}
	
	button.accordion:after {
		content: '\02795';
		font-size: 13px;
		color: #777;
		float: right;
		margin-left: 5px;
	}
	
	button.accordion.active:after {
		content: "\2796";
	}
	
	div.panel {
		padding: 0 5px;
		background-color: white;
		max-height: 0;
		overflow: hidden;
		transition: 0.6s ease-in-out;
		opacity: 0;
		margin-bottom:4px;
	}
	
	div.panel.show {
		opacity: 1;
		max-height: 300px;
	}
	
	table thead tr{
		display:block;
	}
	
	table th,table td{
		width:300px;
	}
	
	table  tbody{		
		display:block;
		height:200px;
		overflow:auto;
	}
</style>

<?php $this->load->helper("crm"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>CRM Approvals</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
    	<div class="col-lg-2"></div>
    	<div class="col-lg-8">
            <!-- Accordian Starts -->
            <?php
                $sql_stage = "select * from crm_stage_mst where stage_id in(3,4,5,6,11,12,13,14,16,17,18,19) order by stage_id";
                $qry_stage = $this->db->query($sql_stage);
                $count=0;
                foreach($qry_stage->result() as $row){
                    $count++;
                    $status = $row->stage_name;
                    $url = $row->stage_url;
            ?>
                <button class="accordion" style="color:black; font-weight:bold;">
                    <?php echo $count.". ".$row->stage_name; ?> (<?php echo case_count($status); ?>)
                </button>
                <div class="panel">
                    <div><?php echo case_det($status, $url); ?></div>

                    <!-- View All Inquiries -->
                    <a href="<?php echo base_url(); ?>index.php/crmc/crm_view_all_inq?status=<?=$status;?>" target="_blank">
                        <h5>View All <?=$status;?></h5>
                    </a>
                </div>
            <?php } ?>
            <!-- Accordian Ends -->
        </div>
    	<div class="col-lg-2"></div>
    </div>
    
  </section>
</section>
<!-- According Javascript -->
<script type="text/javascript">
	var acc = document.getElementsByClassName("accordion");
	var i;
	for (i = 0; i < acc.length; i++) {
		acc[i].onclick = function(){
			this.classList.toggle("active");
			this.nextElementSibling.classList.toggle("show");
	  }
	}
</script>