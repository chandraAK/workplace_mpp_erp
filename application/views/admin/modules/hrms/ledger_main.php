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
            <h3><i class="fa fa-laptop"></i>Cash Ledger</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row" style="text-align:center">
        <div class="col-lg-1"><b>From Date:<b></div>
        <div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control"></div>
        <div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control"></div>
        <div class="col-lg-1"><b>Card No:</b></div>
        <div class="col-lg-2"><select id="card_no" name="card_no" class="form-control"><?php echo CardNo();?></select></div>
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
                            <th><b>Payment Date</b></th>
                            <th><b>Particulars</b></th>
                            <th><b>Credit Amount</b></th>
                            <th><b>Debit Amount</b></th>
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

<script>
//Select2
$(function(){
    $("#card_no").select2();
});

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

//Ajax Filter
function filter(){
    var from_dt = document.getElementById("from_dt").value;
    var to_dt = document.getElementById("to_dt").value;
	var card_no = document.getElementById("card_no").value;

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

    if(card_no == ""){
        alert("Please select CardNo.");
        document.getElementById("card_no").focus();
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
    
    var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&card_no="+encodeURIComponent(card_no);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/ledger_ajax" + queryString,true);
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