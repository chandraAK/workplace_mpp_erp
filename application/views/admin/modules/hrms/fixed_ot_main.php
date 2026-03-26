<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
    div.container { max-width : 1200px; }
</style>

<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Fixed Overtime Employees</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row" style="text-align:center">
    	<div class="col-lg-1"><b>Month:</b></div>
    	<div class="col-lg-2"><select id="att_month" name="att_month" class="form-control"><?php echo month();?></select></div>
    	<div class="col-lg-1"><b>Year:</b></div>
        <div class="col-lg-2"><select id="att_year" name="att_year" class="form-control"><?php echo year();?></select></div>
        <div class="col-lg-1"><b>Employee Type:</b></div>
    	<div class="col-lg-2">
            <select id="emp_type" name="emp_type" class="form-control">
                <option value="All">All</option>
                <option value="On Roll">On Roll</option>
                <option value="Off Roll">Off Roll</option>
            </select>
        </div>
    	<div class="col-lg-1"><b>Salary Type:</b></div>
        <div class="col-lg-2">
            <select id="sal_type" name="sal_type" class="form-control">
                <option value="All">All</option>
                <option value="Cash">Cash</option>
                <option value="Bank">Bank</option>
            </select>
        </div>
    </div><br>

    <div class="row" style="text-align:center">
        <div class="col-lg-1"><b>Status:</b></div>
        <div class="col-lg-2">
            <select id="status" name="status" class="form-control" required>
                <option value="All" selected disabled>ALL</option>
                <?php
                    $sql_status = "
                    select distinct status from fixed_overtime";

                    $qry_status = $this->db->query($sql_status);

                    foreach($qry_status->result() as $row){
                        $status = $row->status;
                ?>
                <option value="<?=$status;?>"><?=$status;?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-lg-1"><input type="button" id="submit" name="submit" value="Submit" class="form-control" onClick="filter()"></div>
        <div class="col-lg-2"></div>
    </div><br><br>

    <div class="row">
        <div class="col-lg-8"></div>
        <div class="col-lg-2">
            <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
            </button>
        </div>
        <div class="col-lg-2">
            <button onclick="printDiv('printableArea')" class="form-control">
                <i class="fa fa-print" aria-hidden="true"></i> Print
            </button>
        </div>
    </div>
    
    <!-- Ajax Response Div -->
    <div id="printableArea">
    <div id="detail">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-bordered" id="example1" style="margin-top:60px">
                    <thead>
                        <tr>
                            <th><b>Select</b> <input type="checkbox" id="all_checkbox" name="all_checkbox" onchange="checkAll(this)"></th>
                            <th>Card No</th>
                            <th>Employee</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Reports To</th>
                            <th>Employee Type</th>
                            <th>Salary Mode</th>
                            <th>OT Calculate</th>
                            <th>Mandatory OT Hours</th>
                            <th>Duty Hours</th>
                            <th>Monthly Salary</th>
                            <th>Total OT Hours</th>
                            <th>Per Hour Salary</th>
                            <th>Total OT Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

  </section>
</section>

<!-- DATA TABES SCRIPT -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">    
    $(document).ready(function() {
        var table = $('#example1').DataTable( {
            responsive: false,
            paging: false
        } );
    
        new $.fn.dataTable.FixedHeader( table );
    } );
</script>

<script type="text/javascript">

    //Filter Ajax
    //Ajax Function Filter Records
    function filter(){
        var att_month = document.getElementById("att_month").value;
        var att_year = document.getElementById("att_year").value;
        var emp_type = document.getElementById("emp_type").value;
	    var sal_type = document.getElementById("sal_type").value;
        var status = document.getElementById("status").value;
        
        if(att_month == ""){
            alert("Please select Month.");
            document.getElementById("att_month").focus();
            return false;
        }

        if(att_year == ""){
            alert("Please select Year.");
            document.getElementById("att_year").focus();
            return false;
        }

        if(emp_type == ""){
            alert("Please select Employee Type.");
            document.getElementById("emp_type").focus();
            return false;
        }

        if(sal_type == ""){
            alert("Please select Salary Type.");
            document.getElementById("sal_type").focus();
            return false;
        }

        if(status == ""){
            alert("Please select Employee Type.");
            document.getElementById("status").focus();
            return false;
        }

        //Ajax
        $("#detail").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
        
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        } 

        xmlhttp.onreadystatechange=function(){
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById('detail').innerHTML=xmlhttp.responseText;

                $(document).ready(function() {
                    var table = $('#example1').DataTable( {
                        responsive: false,
                        paging: false
                    } );
                
                    new $.fn.dataTable.FixedHeader( table );
                } );
            }
        }
        
        var queryString="?att_month="+encodeURIComponent(att_month)+"&att_year="+encodeURIComponent(att_year)+"&emp_type="+encodeURIComponent(emp_type)+"&sal_type="+encodeURIComponent(sal_type)+"&status="+encodeURIComponent(status);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/fixed_ot_ajax" + queryString,true);
        xmlhttp.send();
    }
</script>

<!-- Print Commands -->
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<script type="text/javascript">
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})();
</script>

<script>

function checkAll(ele) {
    var checkboxes = document.getElementsByTagName('input');
    if (ele.checked) {
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = true;
            }
        }
    } else {
        for (var i = 0; i < checkboxes.length; i++) {
            console.log(i)
            if (checkboxes[i].type == 'checkbox') {
                checkboxes[i].checked = false;
            }
        }
    }
}
</script>