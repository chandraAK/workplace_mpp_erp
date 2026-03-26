<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />

<style>
div.container { max-width : 1200px; }
@page { size: auto;  margin: 0mm; }
</style>

<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Payment Tracker Summary</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="col-lg-1"><b>From Date:<b></div>
        <div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control"></div>
        <div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control"></div>
        <div class="col-lg-1"><b>Sales Person:</b></div>
        <div class="col-lg-2">
            <select id="sales_person_nm" name="sales_person_nm" class="form-control">
                <option value="All">All</option>
                <?php
                    $sql_sales_pr = "select name from `tabSales Person` where name not in('All Sales Person')";
                    $qry_sales_pr = $db2->query($sql_sales_pr);
        
                    foreach($qry_sales_pr->result() as $row){
                        $sales_pr_nm = $row->name;
                ?>
                <option value="<?=$sales_pr_nm;?>"><?=$sales_pr_nm;?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-lg-2"><input type="button" id="filter" name="filter" value="Filter" class="form-control" onClick="filter()"></div>
        <div class="col-lg-1"></div>
    </div><br><br>
    
    <!-- Ajax Response Div -->
    <div id="detail"></div>
    
  </section>
</section>

<!-- DATA TABES SCRIPT -->
<?php /*
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">  
    $(document).ready(function() {
        var table = $('#example1').DataTable( {
            responsive: true,
            paging: true
        } );
    
        new $.fn.dataTable.FixedHeader( table );
    } );
</script>

<!-- Print Commands -->
<script  type="text/javascript">
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

*/ ?>

<script type="text/javascript">
    //Date Pickers
    $( function() {
        $( "#from_dt" ).datepicker({
            "dateFormat" : "yy-mm-dd"
        });
    } );

    $( function() {
        $( "#to_dt" ).datepicker({
            "dateFormat" : "yy-mm-dd"
        });
    } );

    //Filter Ajax
    //Ajax Function Filter Records
    function filter(){
        var from_dt = document.getElementById("from_dt").value;
        var to_dt = document.getElementById("to_dt").value;
        var sales_person_nm = document.getElementById("sales_person_nm").value;
        
        if(from_dt == ""){
            alert("Please select from date.");
            document.getElementById("from_dt").focus();
            return false;
        }

        if(to_dt == ""){
            alert("Please select To date.");
            document.getElementById("to_dt").focus();
            return false;
        }

        if(sales_person_nm == ""){
            alert("Please Select Sales Person Name");
            document.getElementById("sales_person_nm").focus();
            return false;
        }

        //alert(sales_person_nm);

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
            }
        }
        
        var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&sales_person_nm="+encodeURIComponent(sales_person_nm);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/salesc/pt_summary_ajax" + queryString,true);
        xmlhttp.send();
    }
</script>