<?php $this->load->helper("hrms"); ?>

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
		overflow: scroll;
		transition: 0.6s ease-in-out;
		opacity: 0;
		margin-bottom:4px;
	}
	
	div.panel.show {
		opacity: 1;
		max-height: 350px;
	}
	
	table thead tr{
		display:block;
	}
	
	table th,table td{
		width:300px;
	}
	
	table  tbody{		
		display:block;
		overflow:auto;
	}
</style>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Adjustment Stages</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <section class="panel">
                <header class="panel-heading" style="text-align:center; font-weight:bold">Adjustment Stages</header>

                <div class="panel-body">    
                    <!-- Adjustment Add -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Adjustments Add</b>
                    </button>
                    <div class="panel">
                        <a href="<?php echo base_url(); ?>index.php/hrmsc/adjustments_add?id=">
                            <h4 style="text-align:center">Adjustment Add</h4>
                        </a>
                        <br/><br/>
                    </div>
                    
                    <!-- Pending For HR Approval -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For HR Approval (<?php echo case_count_adjustments("Pending For HR Approval"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_adjustments("Pending For HR Approval","adjustments_add?id="); ?>
                        <br/><br/>
                    </div>

                    <!---- Rejected By HR ---->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Rejected By HR(<?php echo case_count_adjustments("Rejected By HR"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_adjustments("Rejected By HR","adjustments_add?id="); ?>
                        <br/><br/>
                    </div>

                    <!-- Pending For Management Approval -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For Management Approval (<?php echo case_count_adjustments("Pending For Management Approval"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_adjustments("Pending For Management Approval","adjustments_add?id="); ?>
                        <br/><br/>
                    </div>

                    <!----- Rejected By HR ---->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Rejected By Management(<?php echo case_count_adjustments("Rejected By Management"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_adjustments("Rejected By Management","adjustments_add?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!--- Closed -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Approved (<?php echo case_count_adjustments("Approved"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_adjustments("Approved","adjustments_add?id="); ?>
                        <br/><br/>
                    </div>

                </div><br/><br/>
                <!-- Accordian Ends --> 
            </section>
        </div>
        <div class="col-lg-1"></div>
    </div>
  </section>
</section>

<!-- According Javascript -->
<script type="text/javascript">
    function accordian(){
        var acc = document.getElementsByClassName("accordion");
        var i;
        for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function(){
                this.classList.toggle("active");
                this.nextElementSibling.classList.toggle("show");
            }
        }
    }	
</script>