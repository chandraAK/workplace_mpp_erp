<?php $this->load->helper("finance"); ?>
<style>
@page { size: auto;  margin: 0mm; }
</style>

<?php
    $from_dt = date("Y-m-")."01";
    $to_dt = date("Y-m-d");
?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Cash Dinomination</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-1"><b>Report Type:</b></div>
        <div class="col-lg-2">
            <select id="rpt_type" name="rpt_type" class="form-control" onChange="RptSel(this.value);">
                <option value="">--Select--</option>
                <option value="Daily">Daily Report</option>
                <option value="DateRange">Date Range</option>
            </select>
        </div>
    </div><br><br>

    <!-- Ajax Div -->
    <div id="detail_main"></div><br><br>

  </section>
</section>

<script type="text/javascript">
//Report Select
function RptSel(rpt_type){

    //Ajax
    $("#detail_main").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
    
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById('detail_main').innerHTML=xmlhttp.responseText;
            //Select 2
            $("#comp_id").select2();
            //From Date
            $("#from_dt").datepicker({
                "dateFormat" : "yy-mm-dd"
            });
            //To Date
            $("#to_dt").datepicker({
                "dateFormat" : "yy-mm-dd"
            });
        }

    }

    if(rpt_type == 'Daily'){
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/financec/cd_currdate_rpt");
    } else {
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/financec/cd_daterange_rpt");
    }

    xmlhttp.send();
}

//Ajax Function
function filter(){
    var from_dt = document.getElementById("from_dt").value;
	var to_dt = document.getElementById("to_dt").value;
	var comp_id = document.getElementById("comp_id").value;
    
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
    
    var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&comp_id="+encodeURIComponent(comp_id);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/financec/cash_dino_rpt_ajax" + queryString,true);
    xmlhttp.send();
}

//Cd Filter
function cd_filter(){
    var from_dt = document.getElementById("from_dt").value;
	var comp_id = document.getElementById("comp_id").value;
    
    if(from_dt == ""){
        alert("Please select date.");
        document.getElementById("from_dt").focus();
        return false;
    }

    //Ajax
    $("#cd_detail").empty().html('<img src="<?php echo base_url(); ?>assets/images/wait.gif" />');
    
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    } 

    xmlhttp.onreadystatechange=function(){
        if(xmlhttp.readyState==4 && xmlhttp.status==200){
            document.getElementById('cd_detail').innerHTML=xmlhttp.responseText;
        }

    }
    
    var queryString="?from_dt="+encodeURIComponent(from_dt)+"&comp_id="+encodeURIComponent(comp_id);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/financec/cd_currdate_ajax" + queryString,true);
    xmlhttp.send();
}

//Print
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