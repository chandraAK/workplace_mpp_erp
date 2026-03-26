<?php $this->load->helper("finance"); ?>

<div class="row">
    <div class="col-lg-1"><b>From Date:</b></div>
    <div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control" required></div>

    <div class="col-lg-1"><b>To Date:</b></div>
    <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control" required></div>

    <div class="col-lg-1"><b>Company:</b></div>
    <div class="col-lg-2">
        <select id="comp_id" name="comp_id" class="form-control" required>
            <?=company_list();?>
        </select>
    </div>
    
    <div class="col-lg-1"><input type="button" id="submit" name="submit" value="Submit" class="form-control" onClick="filter()"></div>
    <div class="col-lg-2"></div>
</div><br><br>

<div id="detail"></div><br><br>