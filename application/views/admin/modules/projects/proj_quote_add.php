<?php $this->load->helper("itemlist"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Quote Add Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    <?php
        $quote_id = $_REQUEST['id'];
        if($quote_id != ''){
            foreach($get_quote_by_id->result() as $row){
                $quote_inquiry_no = $row->quote_inquiry_no;
                $quote_rmks = $row->quote_rmks;
            }
        } else {
                $quote_inquiry_no = "";
                $quote_rmks = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
            Quote Add Form
            </header>
            <div class="panel-body">
            <?php
                if($quote_id != ''){
                    echo "<h2>Quote Id - ".$quote_id."</h2>";
                }
            ?>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/projectsc/proj_quote_entry">
                <?php
                    if($quote_id != ''){
                        echo "<input type='hidden' id='quote_id' name='quote_id' value='".$quote_id."'>";
                    } else {
                        echo "<input type='hidden' id='quote_id' name='quote_id' value=''>";
                    }
                ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Quote Inquiry No</label>
                    <div class="col-sm-10">
                        <select id="quote_inquiry_no" name="quote_inquiry_no" class="form-control" required>
                            <option value="">--select--</option>
                            <?php
                                if($quote_id != ''){
                            ?>
                            <option value="<?php echo $quote_inquiry_no; ?>" selected><?php echo $quote_inquiry_no; ?></option>
                            <?php
                                }
                            ?>
                            <?php 
                                $sql_enq = "select inq_no from inq_mst"; 
                                $qry_enq = $this->db->query($sql_enq);
                                foreach($qry_enq->result() as $row){
                            ?>
                            <option value="<?php echo $row->inq_no; ?>"><?php echo $row->inq_no; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Quote Remarks</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="quote_rmks" name="quote_rmks" 
                        value="<?php if($quote_id != ''){ echo $quote_rmks; } else { echo ""; }?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Quote For</label>
                    <div class="col-sm-10">
                        <b>Wonder Mill :</b>
                        <input type="checkbox" id="quote_for_wm" name="quote_for_wm" value="Yes" checked>&nbsp;&nbsp;&nbsp;

                        <b>Atta Expert :</b>
                        <input type="checkbox" id="quote_for_ae" name="quote_for_ae" value="Yes" checked>&nbsp;&nbsp;&nbsp;

                        <b>Standard Mill :</b>
                        <input type="checkbox" id="quote_for_sm" name="quote_for_sm" value="Yes" checked>
                    </div>
                </div>

                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h3>Quotation Item Details</b></h3></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Item Quantity</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($quote_id != ''){
                                $sql_itm_list = "select * from quote_item_details where qitm_quote_id='".$quote_id."'";
                                $qry_itm_list = $this->db->query($sql_itm_list);

                                $cnt = 0;
                                foreach($qry_itm_list->result() as $row){
                                    $cnt++;
                                    $qitm_item_id = $row->qitm_item_id;
                                    $qitm_qty = $row->qitm_qty;

                                    $sql_itm_nm = "select * from item_mst where item_id = '".$qitm_item_id."'";
                                    $qry_itm_nm = $this->db->query($sql_itm_nm);

                                    $item_name;
                                    foreach($qry_itm_nm->result() as $row){
                                        $item_name = $row->item_name;
                                    }
                            ?>
                            <tr>
                                <td>
                                    <?=$item_name;?>
                                    <input type="hidden" id="qitm_item_id" name="qitm_item_id[]" value="<?=$qitm_item_id;?>">
                                </td>
                                <td>
                                    <?=$qitm_qty;?>
                                    <input type="hidden" class="form-control" name="qitm_qty[]" id="qitm_qty" onkeypress="return isNumberKey(event);" value="<?=$qitm_qty;?>" required>
                                </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                             </tr>
                            <?php
                                }    
                            } else {
                            ?>
                            <tr>
                                <td>
                                    <select id="qitm_item_id" name="qitm_item_id[]" class="form-control" required>
                                        <?php echo item_list(); ?>
                                    </select>
                                </td>
                                <td>
                                <input type="text" class="form-control" name="qitm_qty[]" id="qitm_qty" onkeypress="return isNumberKey(event);" required>
                                </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                             </tr>
                            <?php    
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                        <?php 
                        if($cnt > 0){
                        ?>
                        <a href="<?php echo base_url(); ?>index.php/projectsc/proj_quote_pdf?id=<?=$quote_id;?>" target="_blank">
                            <input type="button" class="form-control" id="pdf" name="pdf" value="PDF">
                        </a>
                        <?php
                        }
                        ?>
                        
                    </div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </form>
            </div>
            <div class="col-lg-2"></div>
        </section>
        </div>
    </div>
  </section>
</section>

<script>
//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}
</script>

<script>
function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<select id="qitm_item_id" name="qitm_item_id[]" class="form-control" required><?php echo item_list(); ?></select>';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" class="form-control" name="qitm_qty[]" id="qitm_qty" onkeypress="return isNumberKey(event);" required>';
	
	var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
</script>