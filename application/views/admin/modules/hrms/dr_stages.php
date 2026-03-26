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
		max-height: 250px;
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
            <h3><i class="fa fa-laptop"></i>Daily Report Stages</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <section class="panel">
                <header class="panel-heading" style="text-align:center; font-weight:bold">DR Stages</header>

                <div class="panel-body">                    
                    <!-- Accordian Starts-->

                    <!-- Apply -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>DR Apply</b>
                    </button>
                    <div class="panel">
                        <a href="<?php echo base_url(); ?>index.php/hrmsc/dr_form?id=">
                            <h4 style="text-align:center">DR Apply</h4>
                        </a>
                        <br/><br/>
                    </div>

                    <!-- Pending For HOD Approval -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For HOD Approval(<?php echo case_count_dr("Pending For HOD Approval"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Pending For HOD Approval","dr_form?id="); ?>
                        <br/><br/>
                    </div>

                    <!-- Rejected By HOD -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Rejected By HOD(<?php echo case_count_dr("Rejected By HOD"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Rejected By HOD","dr_form?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!-- Pending For HR Approval -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For HR Approval (<?php echo case_count_dr("Pending For HR Approval"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Pending For HR Approval","dr_form?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!-- Rejected By HR -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Rejected By HR(<?php echo case_count_dr("Rejected By HR"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Rejected By HR","dr_form?id="); ?>
                        <br/><br/>
                    </div>

                    <!-- Pending For Management Approval -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For Management Approval (<?php echo case_count_dr("Pending For Management Approval"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Pending For Management Approval","dr_form?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!-- Rejected By Management -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Rejected By Management(<?php echo case_count_dr("Rejected By Management"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Rejected By Management","dr_form?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!--- Approved -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Approved (<?php echo case_count_dr("Approved"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det_dr("Approved","dr_form?id="); ?>
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