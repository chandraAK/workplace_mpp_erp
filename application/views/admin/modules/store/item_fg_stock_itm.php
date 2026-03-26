<?php $this->load->helper("itemlist"); ?>
<div class="form-group">
    <label class="col-sm-2 control-label">Select Item</label>
    <div class="col-sm-3">
        <select id="ifs_itm_id" name="ifs_itm_id" onchange="item_det_ajax(this.value);" class="form-control" required>
            <?php echo item_list(); ?>
        </select>
    </div>
</div><br>

<div id="detail1"></div>