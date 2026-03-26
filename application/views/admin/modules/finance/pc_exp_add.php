<?php $this->load->helper("finance"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Petty Cash Expense</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $pcexp_id = $_REQUEST['id'];
        if($pcexp_id != ''){
            foreach($get_by_id->result() as $row){
                $pcexp_empname = $row->pcexp_empname;
                $pcexp_balamt = $row->pcexp_balamt;
            }
        } else {
            $pcexp_empname = "";
            $pcexp_balamt = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading">Petty Cash Expense</header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/financec/pc_exp_entry">
            <div class="panel-body">
                <?php
                    if($pcexp_id != ''){
                        echo "<h2>Expense Id - ".$pcexp_id."</h2>";
                ?>
                    <input type="hidden" id="pcexp_id" name="pcexp_id" value="<?=$pcexp_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="pcexp_id" name="pcexp_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Employee Name</label>
                    <div class="col-sm-4">
                        <select id="pcexp_empname" name="pcexp_empname" class="form-control" required onchange="get_bal_amt(this.value)">
                            <?php if($pcexp_empname != ""){ ?>
                                <option value="<?=$pcexp_empname;?>" selected><?=$pcexp_empname;?></option>
                            <?php } ?>
                            <option value="">--Select--</option>
                            <?php echo emp_list(); ?>
                        </select>
                    </div>
                    <div class="col-sm-6"></div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Balance Amount</label>
                    <div class="col-sm-4" id="dtl">
                        <input type="text" id="pc_adv_bal_amt" name="pc_adv_bal_amt" 
                        value="<?php if($pcexp_balamt != ""){ echo $pcexp_balamt; } ?>" class="form-control" readonly>
                    </div>
                    <div class="col-sm-6"></div>
                </div>

                <div class="form-group">
                    <br/><br/>
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-12"><h3>Expenses</b></h3></div>
                            </div>
                        </div>
                        <table class="table table-bordered" id="item_tbl">
                            <thead>
                                <tr>
                                    <th>Expense Date</th>
                                    <th>Amount</th>
                                    <th>Comments</th>
                                    <th>Bill</th>
                                    <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                                </tr>
                            </thead>
                            <tbody style="text-align:left">
                                <?php
                                if($pcexp_id != ''){
                                    $sql_itm_list = "select * from petty_cash_exp_dtl where pcexp_id ='".$pcexp_id."'";
                                    $qry_itm_list = $this->db->query($sql_itm_list);

                                    $cnt = 0;
                                    foreach($qry_itm_list->result() as $row){
                                        $cnt++;
                                        $pcexp_dtl_date = $row->pcexp_dtl_date;
                                        $pcexp_dtl_amt = $row->pcexp_dtl_amt;
                                        $pcexp_dtl_com = $row->pcexp_dtl_com;
                                        $pcexp_dtl_bill = $row->pcexp_dtl_bill;
                                ?>
                                <tr>
                                    <td>
                                        <?=$pcexp_dtl_date;?>
                                        <input type="hidden" id="pcexp_dtl_date" name="pcexp_dtl_date[]" value="<?=$pcexp_dtl_date;?>">
                                    </td>
                                    <td>
                                        <?=$pcexp_dtl_amt;?>
                                        <input type="hidden" class="form-control" id="pcexp_dtl_amt" name="pcexp_dtl_amt[]" 
                                        value="<?=$pcexp_dtl_amt;?>" onkeypress="return isNumberKey(event);">
                                    </td>
                                    <td>
                                        <?=$pcexp_dtl_com;?>
                                        <input type="hidden" id="pcexp_dtl_com" name="pcexp_dtl_com[]" value="<?=$pcexp_dtl_com;?>">
                                    </td>
                                    <td>
                                        <input type="file" class="form-control" id="pcexp_dtl_bill" name="pcexp_dtl_bill[]" value="<?=$pcexp_dtl_bill;?>" onkeypress="return isNumberKey(event);">
                                    </td>
                                    <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                                </tr>
                                <?php
                                    }   
                                } else {
                                ?>
                                <tr>
                                    <td>
                                        <input type="text" id="pcexp_dtl_date" name="pcexp_dtl_date[]" value="" 
                                        class="form-control pcexp_dtl_date" >
                                    </td>
                                    <td>
                                        <input type="text" id="pcexp_dtl_amt" name="pcexp_dtl_amt[]" 
                                        value="" onkeypress="return isNumberKey(event);" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" id="pcexp_dtl_com" name="pcexp_dtl_com[]" value="" class="form-control">
                                    </td>
                                    <td>
                                        <input type="file" id="pcexp_dtl_bill" name="pcexp_dtl_bill[]" value="" class="form-control">
                                    </td>
                                    <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <input type="submit" id="submit" name="submit" value="Submit" class="form-control">
                    </div>
                    <div class="col-sm-4"></div>
                </div>
                  
            </form>
            </div>
        </section>
        </div>
        <div class="col-lg-2"></div>
    </div>
  </section>
</section>

<script>
function get_bal_amt(emp_name){
    //Ajax
    $("#detail").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
        
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById('dtl').innerHTML=xmlhttp.responseText;
        }
    }
    
    var queryString="?emp_name="+emp_name;

    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/financec/pc_adv_balamt" + queryString, true);
    xmlhttp.send();
}

//Restricting Only to insert Numbers
function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
  	return false;

  return true;
  
}

//Add Row
function addrow(){
    //$(".pcexp_dtl_date").datepicker("destroy");

	var table = document.getElementById('item_tbl');
	
	var a =  document.getElementById('item_tbl').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
	newCell1.innerHTML = '<input type="text" id="pcexp_dtl_date'+rowCount+'" name="pcexp_dtl_date[]" value="" class="form-control pcexp_dtl_date">';
	
	var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="pcexp_dtl_amt" name="pcexp_dtl_amt[]" value="" onkeypress="return isNumberKey(event);" class="form-control">';

    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="pcexp_dtl_com" name="pcexp_dtl_com[]" value="" class="form-control">';

    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="file" id="pcexp_dtl_bill" name="pcexp_dtl_bill[]" value="" class="form-control">';
	
	var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow()"></span>';
    
    $("#pcexp_dtl_date"+rowCount).datepicker({
        "dateFormat" : "yy-mm-dd",
    });
}

//Delete Row
function deleterow(){	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

//Datepicker
$( function() {
    $( "#pcexp_dtl_date" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
} );
</script>