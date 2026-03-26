<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Store Dashboard</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
    	<div class="col-lg-2">
        <a href="<?php echo base_url(); ?>index.php/storec/good_load_memo_list">
              <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
              Goods Loading Memo
          </a>
      </div>

      <div class="col-lg-2">
        <a href="<?php echo base_url(); ?>index.php/storec/item_fg_stock_list">
              <img src="<?php echo base_url(); ?>assets/admin/db/updated/flour_mill_dashboard.png" width="50%"/><br><br>
              Item FG Stock
          </a>
      </div>

    </div>
  </section>
</section>