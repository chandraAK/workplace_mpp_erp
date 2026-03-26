<?php $this->load->helper("dr"); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Daily Report Form</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $dr_id = $_REQUEST['id'];
        if($dr_id != ''){
            foreach($get_dr_by_id->result() as $row){
                $dr_date = $row->dr_date;
                $dr_created_by = $row->dr_created_by;
            }
        } else {
            $dr_date = "";
            $dr_created_by = "";
        }
    ?>
    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">
                Daily Report Form
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/drc/dr_entry_it">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($dr_id != ''){
                        echo "<h2>DR No-".$dr_id."</h2>";
                ?>
                    <input type="hidden" id="dr_id" name="dr_id" value="<?=$dr_id; ?>">
                <?php
                    } else {
                ?>
                    <input type="hidden" id="dr_id" name="dr_id" value="">
                <?php
                    }
                ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">DR Date</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dr_date" name="dr_date" value="<?php echo $dr_date; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">DR Created By</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="dr_name" name="dr_name" value="<?php echo $dr_created_by; ?>" readonly>
                    </div>
                </div>
                
                <!--- Product Inquiry -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-8"><h4>Daily Report Details</b></h4></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl">
                        <thead>
                            <tr>
                                <th>Tasks</th>
                                <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                            </tr>
                        </thead>
                        <tbody style="text-align:left">
                            <?php
                            if($dr_id != ''){
                                $sql_itm_list = "select * from dr_details where dr_id ='".$dr_id."'";
                                $qry_itm_list = $this->db->query($sql_itm_list);

                                $cnt = 0;
                                foreach($qry_itm_list->result() as $row){
                                    $cnt++;
                                    $dr_details = $row->dr_details;
                            ?>
                            <tr>
                                <td>
                                    <input type="text" id="dr_details" name="dr_details[]" value="<?=$dr_details;?>" class="form-control" required>
                                </td>
                                <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                             </tr>
                            <?php
                                }    
                            } else {
                            ?>
                            <tr>
                                <td>
                                    <input type="text" id="dr_details" name="dr_details[]" value="" class="form-control" required>
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
                    <div class="col-sm-5"></div>
                    <div class="col-sm-2">
                        <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                    </div>
                    <div class="col-sm-5"></div>
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
$( function() {
    $( "#dr_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );

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
	newCell1.innerHTML = '<input type="text" id="dr_details" name="dr_details[]" value="" class="form-control">';
	
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    

}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}
</script>