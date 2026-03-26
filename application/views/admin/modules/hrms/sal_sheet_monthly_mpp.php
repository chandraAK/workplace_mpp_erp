<?php die; ?>
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
            <h3><i class="fa fa-laptop"></i>Salary Sheet Daily Wages MPP</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row" style="text-align:center">
    	<div class="col-lg-1"><b>Month:</b></div>
    	<div class="col-lg-2"><select id="att_month" name="att_month" class="form-control"><?php echo month();?></select></div>
    	<div class="col-lg-1"><b>Year:</b></div>
        <div class="col-lg-2"><select id="att_year" name="att_year" class="form-control"><?php echo year();?></select></div>
        <div class="col-lg-1"><input type="button" id="submit" name="submit" value="Submit" class="form-control" onClick="filter()"></div>
        <div class="col-lg-2"></div>
    </div><br><br>

    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
            </button>
        </div>
    </div>

    <div id="detail">
        <table class="table table-bordered" id="example1">
            <thead>
                <tr>
                    <th><b>Card No</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Salary Mode</b></th>
                    <th><b>WeekOFFAlloted</b></th>
                    <th><b>DutyHours</b></th>
                    <th><b>Per Day Salary</b></th>
                    <th><b>Per Hour Salary</b></th>
                    <th><b>Total Hours</b></th>
                    <th><b>Penalties</b></th>
                    <th><b>Net Salary</b></th>
                    <th><b>Salary Advance</b></th>
                    <th><b>Loan</b></th>
                    <th><b>Payable Salary</b></th>
                </tr>
            </thead>
        </table>
    </div>

  </section>
</section>

<script>
//Ajax Filter
function filter(){
    var att_month = document.getElementById("att_month").value;
	var att_year = document.getElementById("att_year").value;
    
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
                responsive: true,
                paging: false
            } );
        
            new $.fn.dataTable.FixedHeader( table );
        } );
    }

    }
    
    var queryString="?att_month="+encodeURIComponent(att_month)+"&att_year="+encodeURIComponent(att_year);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/sal_sheet_monthly_ajax_mpp" + queryString,true);
    xmlhttp.send();
}

</script>

<!-- DATA TABES SCRIPT -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">  
    $(document).ready(function() {
        var table = $('#example1').DataTable( {
            responsive: true,
            paging: false
        } );
    
        new $.fn.dataTable.FixedHeader( table );
    } );
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