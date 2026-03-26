<?php $this->load->helper("finance"); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Petty Cash Advance</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <?php
        $pc_adv_id = $_REQUEST['id'];
        if($pc_adv_id != ''){
            foreach($get_by_id->result() as $row){
                $pc_emp_name = $row->pc_emp_name;
                $pc_adv_date = $row->pc_adv_date;
                $pc_adv_bal_amt = $row->pc_adv_bal_amt;
                $pc_adv_hot = $row->pc_adv_hot;
                $pc_adv_amt = $row->pc_adv_amt;
            }
        } else {
            $pc_emp_name = "";
            $pc_adv_date = "";
            $pc_adv_bal_amt = "";
            $pc_adv_hot = "";
            $pc_adv_amt = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
        <section class="panel">
            <header class="panel-heading">Petty Cash Advance</header>
            <form class="form-horizontal " method="post" action="<?php echo base_url(); ?>index.php/financec/pc_adv_entry">
            <div class="panel-body">
                <?php
                    if($pc_adv_id != ''){
                        echo "<h2>Advance Id - ".$pc_adv_id."</h2>";
                ?>
                    <input type="hidden" id="pc_adv_id" name="pc_adv_id" value="<?=$pc_adv_id; ?>">
                <?php } else { ?>
                    <input type="hidden" id="pc_adv_id" name="pc_adv_id" value="">
                <?php } ?>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Employee Name</label>
                    <div class="col-sm-8">
                        <select id="pc_emp_name" name="pc_emp_name" class="form-control" required onchange="get_bal_amt(this.value)">
                            <?php if($pc_emp_name != ""){ ?>
                                <option value="<?=$pc_emp_name;?>" selected><?=$pc_emp_name?></option>
                            <?php } ?>
                            <option value="">--Select--</option>
                            <?php echo emp_list(); ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Date</label>
                    <div class="col-sm-8">
                        <input type="text" id="pc_adv_date" name="pc_adv_date" value="<?php echo date("Y-m-d"); ?>" 
                        class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Balance Amount</label>
                    <div class="col-sm-8" id="dtl">
                        <input type="text" id="pc_adv_bal_amt" name="pc_adv_bal_amt" 
                        value="<?php if($pc_adv_bal_amt != ""){ echo $pc_adv_bal_amt; } ?>" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Handed Over To</label>
                    <div class="col-sm-8">
                        <input type="text" id="pc_adv_hot" name="pc_adv_hot" 
                        value="<?php if($pc_adv_hot != ""){ echo $pc_adv_hot; } ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Amount</label>
                    <div class="col-sm-8">
                        <input type="text" id="pc_adv_amt" name="pc_adv_amt" 
                        value="<?php if($pc_adv_amt != ""){ echo $pc_adv_amt; } ?>" class="form-control" 
                        onkeypress="return isNumberKey(event);" required>
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
        <div class="col-lg-3"></div>
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
</script>