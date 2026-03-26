<?php $this->load->helper("it"); ?>

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
		max-height: 750px;
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
            <h3><i class="fa fa-laptop"></i>Ticket Stages</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <section class="panel">
                <header class="panel-heading" style="text-align:center; font-weight:bold">Ticket Stages</header>

                <div class="panel-body">                    
                    <!-- Accordian Starts-->

                    <!-- Ticket Register -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Ticket Booking</b>
                    </button>
                    <div class="panel">
                        <a href="<?php echo base_url(); ?>index.php/itc/ticket_reg_form?id=">
                            <h4 style="text-align:center">Ticket Booking</h4>
                        </a>
                        <br/><br/>
                    </div>

                    <!-- Pending For Assign-->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For Assign (<?php echo case_count("Pending For Assignment"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det("Pending For Assignment","ticket_pend_assign?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!-- Open -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Open (<?php echo case_count("Open"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det("Open","ticket_open?id="); ?>
                        <br/><br/>
                    </div>

                    <!-- Pending For Clarification -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Pending For Clarification (<?php echo case_count("Pending For Clarification"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det("Pending For Clarification","ticket_pc?id="); ?>
                        <br/><br/>
                    </div>
                    
                    <!--- Closed -->
                    <button class="accordion" style="color:black; font-weight:bold;" onclick="accordian();" type="button">
                        <b>Closed (<?php echo case_count("Closed"); ?>)</b>
                    </button>
                    <div class="panel">
                        <?php echo case_det("Closed","ticket_closed?id="); ?>
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