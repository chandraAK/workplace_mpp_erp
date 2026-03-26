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
                $dept = $row->dept;
                $dr_created_by = $row->dr_created_by;
                $leads_work_on = $row->leads_work_on;
                $leads_close = $row->leads_close;
                $leads_assign = $row->leads_assign;
                $sales_pr_nm =$row->$name;
                //echo $sales_pr_nm;
                $leads_no = $row->leads_no;
                $meet_name = $row->name;
                $frm_tim = $row->from_time;
                $to_tim = $row->to_time;
                $agenda = $row->agenda;
                $total_hrs=$row->total_hrs;
                $party_nm =$row->party_name;
                $cont_per = $row->cont_person;
                $cont_no= $row->cont_no;
                $email= $row->email;
                $remarks = $row->remarks;
                $dr_modified_date = $row->modified_date;
            }
        } else {
            $dept = "";
            $dr_date = "";
            $dr_created_by = "";
            $leads_work_on = "";
            $leads_close = "";
            $leads_assign = "";
            $sales_pr_nm ="";
            $leads_no = "";
            $meet_name = "";
            $frm_tim ="";
            $to_tim ="";
            $agenda = "";
            $total_hrs="";
            $party_nm ="";
            $cont_per ="";
            $cont_no= "";
            $email= "";
            $remarks = "";
            $dr_modified_date = "";
        }
    ?>

    <div class="row" style="text-align:center">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
        <section class="panel">
            <header class="panel-heading" style="font-size:18px"><b>
                Daily Report Form</b>
            </header>
            <form class="form-horizontal " method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>index.php/drc/dr_entry">
            <div class="panel-body">
                <!-- Inquiry Details -->
                <?php
                    if($dr_id != ''){
                        echo "<h4>DR No-".$dr_id."</h4>";
                ?>
                    <input type="hidden" id="dr_id" name="dr_id" value="<?=$dr_id; ?>">
                    <input type="hidden" id="dept" name="dept" value="<?=$dept; ?>">

                <?php
                    } else {
                ?>
                    <input type="hidden" id="dr_id" name="dr_id" value="">
                    <input type="hidden" id="dept" name="dept" value="">
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
                        <input type="text" class="form-control" id="dr_name" name="dr_name" value="<?php if($dr_created_by == ""){ echo $_SESSION['username']; } else { echo $dr_created_by; }; ?>" readonly>
                    </div>
                </div>

                <!--- Added by Charu 202010291235 -->
                <div class="form-group">
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Leads worked on</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="leads_work_on" name="leads_work_on" value="<?php echo $leads_work_on; ?>" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Leads closed</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="leads_close" name="leads_close" value="<?php echo $leads_close; ?>" required>
                    </div>
                    <label class="col-sm-2 control-label"><span style="color:red">*</span>&nbsp;Leads Assigned</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="leads_assign" name="leads_assign" value="<?php echo $leads_assign; ?>" required>
                    </div>
                </div>
                <!--- Added by Charu 202010291235 -->

                <!--- Product Inquiry -->

                
                <!--- lead assign -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Lead Assignment</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl1">
                        <tr style="background-color:#ddd">
                            <th>Name</th>
                            <th>Number</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow1();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql1 = "select * from dr_lead_assign where dr_id ='".$dr_id."'";
                         
                            $qry1= $this->db->query($sql1);

                            $cnt = 0;
                            foreach($qry1->result() as $row){
                                $cnt++;
                                $sales_pr_nm =$row->name;
                                $leads_no = $row->leads_no;
		                 ?>
                        <tr>
                            <td> <input type="text" id="sales_pr_nm" name="sales_pr_nm[]" value="<?=$sales_pr_nm;?>" class="form-control" required></td>
                            <td><input type="text" id="leads_no" name="leads_no[]" value="<?=$leads_no;?>" class="form-control" required></td>
                                
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                            </tr>
                        <?php
                            }    
                        } else {
                        ?>
                        <tr>
                            <td><select id="sales_pr_nm" name="sales_pr_nm[]" class="form-control">
                                <option value="Select">Select</option>
                                <?php echo dr_lead_name(); ?></select></td>
                            <td><input type="text" id="cont_per" name="leads_no[]" value="" class="form-control" required></td>                        
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow1()"></span></td>
                        </tr>
                        <?php    
                        }
                        ?>
                    </table>
             
                <!---meetings -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                        <div class="col-sm-12" style="text-align:left"><h5><b>Meetings</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl2">
                        <tr style="background-color:#ddd">
                            <th>Name</th>
                            <th>From Time</th>
                            <th>To Time</th>
                            <th>Agenda</th>
                            <th>Total Hours</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow2();"></span></th>
                        </tr>
                        <?php 
                        if($dr_id != ''){
                            $sql2 = "select * from dr_meet where dr_id ='".$dr_id."'";
                            $qry2= $this->db->query($sql2);

                            $cnt = 0;
                            foreach($qry2->result() as $row){
                                $cnt++;
                                $meet_name = $row->name;
		                         $frm_tim = $row->from_time;
		                        $to_tim = $row->to_time;
                                $agenda = $row->agenda;
                                $total_hrs = $row->total_hrs;
		                 ?>
                         <tr>
                            <td>
                            <?=$meet_name;?>
                            <input type="hidden" id="meet_nm" name="meet_name[]" value="<?=$meet_name;?>" class="form-control" required></td>
                             <td><input type="hidden" id="frm_tim1" name="frm_tim[]" value="<?=$frm_tim;?>" class="form-control from_time" required></td>
                            <td><input type="hidden" id="to_tim" name="to_tim[]" value="<?=$to_tim;?>" class="form-control to_time" required></td>
                             <td><input type="hidden" id="agenda" name="agenda[]" value="<?=$agenda;?>" class="form-control" required> </td>
                             <td><input type="hidden" id="total_hrs" name="total_hrs[]" value="<?=$total_hrs;?>" class="form-control" required onclick="calculate()"> </td>

                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow2()"></span></td>
                            </tr> 
                        <?php
                            }    
                        
                        ?>
                        <!-- <tr>
                            <td>
                            <input type="text" id="meet_nm1" name="meet_name[]" value="" class="form-control" required></td>
                                <td><input type="text" id="frm_tim1" name="frm_tim[]" value="" class="form-control from_time" required onclick="calculate(1);"></td>
                                <td><input type="text" id="to_tim1" name="to_tim[]" value="" class="form-control to_time" required onclick="calculate(1);"></td>
                               <td> <input type="text" id="agenda1" name="agenda[]" value="" class="form-control" required></td>
                               <td> <input type="text" id="total_hrs1" name="total_hrs[]" value="" class="form-control total_hrs" required onclick="calculate(1)"></td>
                               
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow2()"></span></td>
                            </tr> -->
                        <?php 
                             
                        }
                        ?>
                    </table>
                </div>
             
                <!---customer interaction -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                        <div class="col-sm-12" style="text-align:left;"><h5><b>Customer Interaction</b></h5></div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" id="item_tbl3">
                        <tr style="background-color:#ddd">
                            <th>Party Name</th>
                            <th>Contact Person</th>
                            <th>Contact No.</th>
                            <th>Email</th>
                            <th>Remarks</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow3();"></span></th>
                        </tr>
                        <?php
                        if($dr_id != ''){
                            $sql3 = "select * from dr_cust_int where dr_id ='".$dr_id."'";
                            $qry3= $this->db->query($sql3);

                            $cnt = 0;
                            foreach($qry3->result() as $row){
                                $cnt
                                ++;
                                $party_nm =$row->party_name;
		                        $cont_per = $row->cont_person;
		                        $cont_no= $row->cont_no;
		                        $email= $row->email;
		                        $remarks = $row->remarks;
		        

                        ?>
                        <tr>
                            <td><input type="hidden" id="party_nm" name="party_nm[]" value="<?=$party_nm;?>" class="form-control" required></td>
                                <td><input type="hidden" id="cont_per" name="cont_per[]" value="<?=$cont_per;?>" class="form-control" required></td>
                                <td><input type="hidden" id="cont_no" name="cont_no[]" value="<?=$cont_no;?>" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="hidden" id="email" name="email[]" value="<?=$email;?>" class="form-control" required></td>
                               <td> <input type="hidden" id="remarks" name="remarks[]" value="<?=$remarks;?>" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                        </tr>
                        <?php
                            }    
                        
                        ?>
                        <!-- <tr>
                            <td>
                            <input type="text" id="party_nm" name="party_nm[]" value="" class="form-control" required></td>
                               <td> <input type="text" id="cont_per" name="cont_per[]" value="" class="form-control" required></td>
                                <td><input type="text" id="cont_no" name="cont_no[]" value="" class="form-control" onkeypress="return isNumberKey(event);" required></td>
                                <td><input type="text" id="email" name="email[]" value="" class="form-control" required></td>
                                <td><input type="text" id="remarks" name="remarks[]" value="" class="form-control" required>
                            </td>
                            <td><span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span></td>
                            </tr> -->
                        <?php    
                        }
                        ?>
                    </table>
                </div>
                
                <!--Other Tasks -->
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-12" style="text-align:left"><h5><b>Other Tasks</b></h5></div>
                        </div>
                    </div>
                    <table class="table table-bordered" id="item_tbl" style="text-align:left">
                        <tr style="background-color:#ddd">
                            <th>Particulars</th>
                            <th><span class="glyphicon glyphicon-plus" style="font-size:15px;color:green;" onclick="addrow();"></span></th>
                        </tr>
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

/*$( function() {
    $("#frm_tim1").datetimepicker({
        format: "LT"
        });
    } );

$( function() {
    $("#to_tim").datetimepicker({
        format: "LT"
        });
    } );

$('input').on('keyup change', function(){
    differenceHours.diff_hours('frm_tim','to_tim','total_hrs')
});
*/
function calculate(a)
  {
    var time1 = $("#frm_tim"+a).val();
    var time2 = $("#to_tim"+a).val();
    var time1 = time1.split(':');
    var time2 = time2.split(':');
    var hours1 = parseInt(time1[0], 10), 
    hours2 = parseInt(time2[0], 10),
    mins1 = parseInt(time1[1], 10),
    mins2 = parseInt(time2[1], 10);
    var hours = hours2 - hours1, mins = 0;
    if(hours < 0) hours = 24 + hours;
    if(mins2 >= mins1) {
        mins = mins2 - mins1;
    }
    else {
      mins = (mins2 + 60) - mins1;
      hours--;
    }
    if(mins < 9)
    {
      mins = '0'+mins;
    }
    if(hours < 9)
    {
      hours = '0'+hours;
    }
    $("#total_hrs"+a).val(hours+':'+mins);
  }



$(function() {
    $('#frm_tim1').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        minTime: '10',
        maxTime: '6:00pm',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});

$(function() {
    $('#to_tim1').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        minTime: '10',
        maxTime: '6:00pm',
        defaultTime: '11',
        startTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });
});

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
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;"  onclick="deleterow()"></span>';
}
</script>
<script>

function addrow1(){
	
	var table = document.getElementById('item_tbl1');
	
	var a =  document.getElementById('item_tbl1').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<select id="sales_pr_nm" name="sales_pr_nm[]" class="form-control"><?php echo dr_lead_name(); ?></select>'
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="leads_no" name="leads_no[]" value="" class="form-control" >';
	
	var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;"  onclick="deleterow1()"></span>';
}
</script>
<script>
  function addrow2(){
	
	var table = document.getElementById('item_tbl2');
	
	var a =  document.getElementById('item_tbl2').rows.length;
	var rowCount = a;
	
	var row = table.insertRow(a);
	
	 var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<input type="text" id="meet_name'+rowCount+'" name="meet_name[]" value="" class="form-control">';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="frm_tim'+rowCount+'" name="frm_tim[]" value="" class="form-control from_time" onclick="calculate('+rowCount+');">';
    var newCell1 = row.insertCell(2);
    newCell1.innerHTML = '<input type="text" id="to_tim'+rowCount+'" name="to_tim[]" value="" class="form-control to_time" onclick="calculate('+rowCount+');">';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="agenda'+rowCount+'" name="agenda[]" value="" class="form-control">';
    var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<input type="text" id="total_hrs'+rowCount+'" name="total_hrs[]" value="" class="form-control total_hrs" onclick="calculate('+rowCount+');">';
	var newCell1 = row.insertCell(5); 
    newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;"  onclick="deleterow2()"></span>';
    

        $(function() {
            $('.from_time').timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                minTime: '10',
                maxTime: '6:00pm',
                defaultTime: '11',
                startTime: '10:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        });

        $(function() {
            $('.to_time').timepicker({
                timeFormat: 'HH:mm',
                interval: 60,
                minTime: '10',
                maxTime: '6:00pm',
                defaultTime: '11',
                startTime: '10:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true

            });
        });
  
  //time difference by charu
   calculate(rowCount);
  }

</script>
<script>

function addrow3(){
	
	var table = document.getElementById('item_tbl3');
	
	var a =  document.getElementById('item_tbl3').rows.length;
	var rowCount = a-1;
	
	var row = table.insertRow(a);
	
	var newCell1 = row.insertCell(0);
    newCell1.innerHTML = '<input type="text" id="party_nm" name="party_nm[]" value="" class="form-control">';
    var newCell1 = row.insertCell(1);
	newCell1.innerHTML = '<input type="text" id="cont_per" name="cont_per[]" value="" class="form-control">';
    var newCell1 = row.insertCell(2);
	newCell1.innerHTML = '<input type="text" id="cont_no" name="cont_no[]" value="" onkeypress="return isNumberKey(event);" class="form-control" >';
    var newCell1 = row.insertCell(3);
	newCell1.innerHTML = '<input type="text" id="email" name="email[]" value="" class="form-control">';
    var newCell1 = row.insertCell(4);
	newCell1.innerHTML = '<input type="text" id="remarks" name="remarks[]" value="" class="form-control">';
	var newCell1 = row.insertCell(5);
	newCell1.innerHTML = '<span class="glyphicon glyphicon-remove" style="font-size:15px;color:red;" onclick="deleterow3()"></span>';
}
</script>
<script>

function deleterow(){
	
	var table = document.getElementById('item_tbl');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

function deleterow1(){	
	var table = document.getElementById('item_tbl1');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

function deleterow2(){
	var table = document.getElementById('item_tbl2');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

function deleterow3(){
	var table = document.getElementById('item_tbl3');
	var rowCount = table.rows.length;
	table.deleteRow(rowCount -1);
}

$(function() {
$('.datepicker').datepicker({ format : 'dd-mm-yyyy', weekStart: 1 });
});
</script>