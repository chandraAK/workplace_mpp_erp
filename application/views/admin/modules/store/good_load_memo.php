<?php $this->load->helper("itemlist"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Goods Loading Memo</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading"><h3 style="padding:8px">Goods Loading Memo</h3></header>
                <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/storec/good_load_memo_entry">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Date</label>
                            <div class="col-sm-2">
                                <input type="text" id="glm_date" name="glm_date" value="<?php echo date("Y-m-d"); ?>" class="form-control" readonly required>
                            </div>

                            <label class="col-sm-2 control-label">Vehicle No.</label>
                            <div class="col-sm-2">
                                <input type="text" id="glm_vehicle_no" name="glm_vehicle_no" value="" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Party Name</label>
                            <div class="col-sm-6">
                                <input type="text" id="glm_party_name" name="glm_party_name" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="table-wrapper">
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-12"><h3 style="text-align:center">Item Details</b></h3></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered" id="item_tbl">
                                            <thead>
                                                <tr style="font-weight:bold">
                                                    <th rowspan="2">Item Name</th>
                                                    <th colspan="2" style="text-align:center">SVIPL Unit1</th>
                                                    <th colspan="2" style="text-align:center">SBMI</th>
                                                    <th colspan="2" style="text-align:center">Total</th>
                                                    <th rowspan="2"><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <th>Runner</th>
                                                    <th>Fix</th>
                                                    <th>Runner</th>
                                                    <th>Fix</th>
                                                    <th>Runner</th>
                                                    <th>Fix</th>
                                                </tr>
                                            </thead>
                                            <tbody style="text-align:left">
                                                <tr>
                                                    <td>
                                                        <select id="glm_itm_id1" name="glm_itm_id[]" class="form-control  glm_itm_id" required>
                                                            <?php echo item_list(); ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="glm_svipl1_runner1" name="glm_svipl1_runner[]" onkeyup="line_tot_runner(1);" value="0" onkeypress="return isNumberKey(event);">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="glm_svipl1_fix1" name="glm_svipl1_fix[]" onkeyup="line_tot_fix(1);"  value="0" onkeypress="return isNumberKey(event);">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="glm_sbmi_runner1" name="glm_sbmi_runner[]" onkeyup="line_tot_runner(1);"  value="0" onkeypress="return isNumberKey(event);">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" id="glm_sbmi_fix1" name="glm_sbmi_fix[]" onkeyup="line_tot_fix(1);"  value="0" onkeypress="return isNumberKey(event);">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control glm_svipl1_runner" id="glm_tot_runner1" name="glm_tot_runner[]" onkeyup="line_tot_runner(1);"  value="0" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control glm_svipl1_fix" id="glm_tot_fix1" name="glm_tot_fix[]" onkeyup="line_tot_fix(1);"  value="0" readonly>
                                                    </td>
                                                    <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-1"><b>Total Runner</b></div>
                                    <div class="col-lg-2"><input type="text" class="form-control" id="tot_runner" name="tot_runner" value="0" readonly></div>
                                    <div class="col-lg-1"><b>Total Fixed</b></div>
                                    <div class="col-lg-2"><input type="text" class="form-control" id="tot_fix" name="tot_fix" value="0" readonly></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-2">
                                <input type="submit" class="form-control" id="submit" name="submit" value="Submit">
                            </div>
                            <div class="col-sm-5"></div>
                        </div>

                    </div>   
                </form>
            </section>
        </div>
    </div>

  </section>
</section>

<script>
//select2
//Select 2 Function
$( function(){
    $(".glm_itm_id1").select2();
});

//datepicker
$( function() {
    $( "#glm_date" ).datepicker({
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
//Item Table
function addrow(){
	
	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<select class="form-control glm_itm_id" id="glm_itm_id'+rowCount+'" name="glm_itm_id[]" required><?php echo item_list(); ?></select>';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" class="form-control" id="glm_svipl1_runner'+rowCount+'" name="glm_svipl1_runner[]" onkeyup="line_tot_runner('+rowCount+');"  value="0" onkeypress="return isNumberKey(event);">';

    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" class="form-control" id="glm_svipl1_fix'+rowCount+'" name="glm_svipl1_fix[]" onkeyup="line_tot_fix('+rowCount+');"  value="0" onkeypress="return isNumberKey(event);">';

    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" class="form-control" id="glm_sbmi_runner'+rowCount+'" name="glm_sbmi_runner[]" onkeyup="line_tot_runner('+rowCount+');"  value="0" onkeypress="return isNumberKey(event);">';

    var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<input type="text" class="form-control" id="glm_sbmi_fix'+rowCount+'" name="glm_sbmi_fix[]" onkeyup="line_tot_fix('+rowCount+');"  value="0" onkeypress="return isNumberKey(event);">';

    var newCell1 = row.insertCell(5);
	newCell1.innerHTML = '<input type="text" class="form-control glm_svipl1_runner" id="glm_tot_runner'+rowCount+'" name="glm_tot_runner[]" onkeyup="line_tot_runner('+rowCount+');"  value="0" readonly>';

    var newCell1 = row.insertCell(6);
	newCell1.innerHTML = '<input type="text" class="form-control glm_svipl1_fix" id="glm_tot_fix'+rowCount+'" name="glm_tot_fix[]"  onkeyup="line_tot_fix('+rowCount+');" value="0" readonly>';
	
	var newCell1 = row.insertCell(7);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';

    $( function(){
        $(".glm_itm_id").select2();
    });
}

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);

    tot_runner();
    tot_fix();
}

//Runner Line Total
function line_tot_runner(rowCount){
    var glm_svipl1_runner = document.getElementById("glm_svipl1_runner"+rowCount).value;
    var glm_sbmi_runner = document.getElementById("glm_sbmi_runner"+rowCount).value;

    var RunTot = Number(glm_svipl1_runner)+Number(glm_sbmi_runner);
    //alert(RunTot);
    document.getElementById("glm_tot_runner"+rowCount).value = RunTot;

    tot_runner();
    tot_fix();

}

//Fix Line Total
function line_tot_fix(rowCount){
    var glm_svipl1_fix = document.getElementById("glm_svipl1_fix"+rowCount).value;
    var glm_sbmi_fix = document.getElementById("glm_sbmi_fix"+rowCount).value;

    var fixTot = Number(glm_svipl1_fix)+Number(glm_sbmi_fix);
    //alert(fixTot);
    document.getElementById("glm_tot_fix"+rowCount).value = fixTot;

    tot_runner();
    tot_fix();

}

//fix total
function tot_fix(){
    //alert();
    var total = 0;
    var list = document.getElementsByClassName("glm_svipl1_fix");
    var values = [];
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });
    //alert(total);
    document.getElementById("tot_fix").value = total;
}

//Runner total
function tot_runner(){
    //alert();
    var total = 0;
    var list = document.getElementsByClassName("glm_svipl1_runner");
    var values = [];
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });
    //alert(total);
    document.getElementById("tot_runner").value = total;
}
</script>

<script>
/*
function item_det(item_id, row_id){
    //alert(item_id);
    //return false;
    $("#ajax_div"+row_id).empty().html('<img src="<?php echo base_url(); ?>assets/images/loading.gif" width="317px" height="58px"/>');
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();	
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");	
    }

    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById("#ajax_div"+row_id).innerHTML=xmlhttp.responseText;
        } 
    }
        
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/storec/good_load_memo_ajax", true);    	
    xmlhttp.send();    
} 
*/
</script>