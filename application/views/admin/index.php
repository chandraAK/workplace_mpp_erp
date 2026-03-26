<?php include'header.php'; ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i> Master Dashboard</h3>
            <ol class="breadcrumb">
                <li><i class="fa fa-home"></i><a href="<?php echo base_url(); ?>index.php/welcome/dashboard">Home</a></li>
                <li><i class="fa fa-laptop"></i>Dashboard </li>						  	
            </ol>
        </div> 
    </div>
    
  <?php if($role == "Admin" || $role == "Management"){ ?>

  <div class="row" style="text-align:center">
    	<div class="col-lg-2">
        	<a href="<?php echo base_url(); ?>index.php/projectsc">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
                Projects
            </a>
        </div>

        <div class="col-lg-2">
            <a href="<?php echo base_url(); ?>index.php/crmc">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/inventory_management.png" width="50%"/><br /><br />
                CRM
            </a>
        </div>

        <div class="col-lg-2">
            <a href="<?php echo base_url(); ?>index.php/hrmsc">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/logistics_management.png" width="50%"/><br /><br />
                HRMS
            </a>
        </div>

        <div class="col-lg-2">
            <a href="<?php echo base_url(); ?>index.php/financec">
                <img src="<?php echo base_url(); ?>assets/admin/db/updated/purchase_management.png" width="50%"/><br /><br />
                Finance
            </a>
        </div>

        <div class="col-lg-2">
          <a href="<?php echo base_url(); ?>index.php/purchasec">
            <img src="<?php echo base_url(); ?>assets/admin/db/updated/sales_management.png" width="50%"/><br /><br />
            Purchase
          </a>
        </div>

        <div class="col-lg-2">
          <a href="<?php echo base_url(); ?>index.php/productionc">
            <img src="<?php echo base_url(); ?>assets/admin/db/updated/order_management.png" width="50%"/><br /><br />
            Production
          </a>
        </div>
    </div><br /><br />
    
    <div class="row" style="text-align:center">
      <div class="col-lg-2">
        <a href="<?php echo base_url(); ?>index.php/storec">
          <img src="<?php echo base_url(); ?>assets/admin/db/updated/hrms.png" width="50%"/><br /><br />
          Store
        </a>
      </div>

      <div class="col-lg-2">
        <a href="<?php echo base_url(); ?>index.php/mrpc">	
          <img src="<?php echo base_url(); ?>assets/admin/db/updated/crm.png" width="50%"/><br /><br />
          MRP
        </a>
      </div>
      
      <!--
      <div class="col-lg-2">	
        <a href="<?php echo base_url(); ?>index.php/shrihitc">
          <img src="<?php echo base_url(); ?>assets/admin/db/updated/distributor_management.png" width="50%"/><br /><br />
          Shrihit
        </a>
      </div>

      <div class="col-lg-2">
        <a href="<?php echo base_url(); ?>index.php/wfmc">	
          <img src="<?php echo base_url(); ?>assets/admin/db/updated/visitors.png" width="50%"/><br /><br />
          WFM
        </a>
      </div>
      -->

      <div class="col-lg-2">
        <a href="<?php echo base_url(); ?>index.php/servicec">
          <img src="<?php echo base_url(); ?>assets/admin/db/updated/contacts.png" width="50%"/><br /><br />
          Service
        </a>
      </div>

        <div class="col-lg-2">
          <a href="<?php echo base_url(); ?>index.php/drc/">
            <img src="<?php echo base_url(); ?>assets/admin/db/updated/contacts.png" width="50%"/><br /><br />
        	  DR
          </a>
        </div>

    </div><br /><br />

    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="https://www.zoho.com/creator/login.html" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/projectsc">
              Projects
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="https://www.zoho.com/creator/login.html" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/crmc">
            CRM
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="https://www.zoho.com/creator/login.html" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/hrmsc">
            HRMS
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="https://www.zoho.com/creator/login.html" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/projectsc">
            Finance
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="https://www.zoho.com/creator/login.html" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/projectsc">
            Purchase
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

      <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
        <a href="https://www.zoho.com/creator/login.html" target="_blank">
        <div class="info-box green-bg">
          <div class="title">
            <a href="<?php echo base_url(); ?>index.php/projectsc">
              Production
            </a>
          </div>
        </div>
        </a>
        <!--/.info-box-->
      </div>
      <!--/.col-->

    </div>
    <!--/.row-->

    <?php } else { echo "<h2 style='text-align:center'>Welcome To Mahaveer Group Dashboard</h2>"; } ?>
    
  </section>
</section>
 
  
  <script>

      //knob
      $(function() {
        $(".knob").knob({
          'draw' : function () { 
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
          $("#owl-slider").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
	  
	  /* ---------- Map ---------- */
	$(function(){
	  $('#map').vectorMap({
	    map: 'world_mill_en',
	    series: {
	      regions: [{
	        values: gdpData,
	        scale: ['#000', '#000'],
	        normalizeFunction: 'polynomial'
	      }]
	    },
		backgroundColor: '#eef3f7',
	    onLabelShow: function(e, el, code){
	      el.html(el.html()+' (GDP - '+gdpData[code]+')');
	    }
	  });
	});



  </script>

<?php include('footer.php'); ?>