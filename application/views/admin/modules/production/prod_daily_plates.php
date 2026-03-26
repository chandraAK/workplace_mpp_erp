<?php $this->load->helper("production"); ?>

<?php
    $from_dt = date("Y-m-")."01";
    $to_dt = date("Y-m-d");
?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Daily Plates</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row" style="text-align:center">
    	<div class="col-lg-1"><b>From Date:</b></div>
    	<div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control"></div>
    	<div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control"></div>
        <div class="col-lg-1"><input type="button" id="submit" name="submit" value="Submit" class="form-control" onClick="filter()"></div>
        <div class="col-lg-5"></div>
    </div><br><br>

    <div id="detail">
        <div class="row">
            <div class="col-lg-10"><h3>Current Month Production</h3></div>
            <div class="col-lg-2">
                <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" class="form-control">
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered" id="testTable">
                    <thead>
                        <tr>
                            <th><b>Date</b></th>
                            <?php
                                $sql = "select * from plate_mst where plate_active = 1";
                                $qry = $this->db->query($sql);
                                $plate_arr = array();
                                foreach($qry->result() as $row){
                                    $plate_name = $row->plate_name;
                                    array_push($plate_arr, $plate_name);
                            ?>
                            <th><b><?php echo $plate_name; ?></b></th>
                            <?php } ?>
                            <th><b>Total</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $date = getDatesFromRange($from_dt, $to_dt); 
                            $arr_cnt = count($date);
                            $plate_cnt = count($plate_arr);
                            for($i=0; $i<$arr_cnt;$i++){
                        ?>
                        <tr>
                            <td><?php echo $date[$i]; ?></td>
                            <?php
                                $tot_prod = 0;
                                for($j=0;$j<$plate_cnt;$j++){
                            ?>
                            <td><?php echo $tot_prod1 = daily_prod_plates($plate_arr[$j],$date[$i]); ?></td>
                            <?php 
                                $tot_prod = $tot_prod+$tot_prod1;
                                } 
                            ?>
                            <td style="background-color:#33e6ff"><?php echo $tot_prod; ?></td>
                        </tr>
                        <?php } ?>
                        <!-- Plate Wise total -->
                        <tr style="background-color:#33e6ff">
                            <td><b>Total</b></td>
                            <?php
                                for($j=0;$j<$plate_cnt;$j++){
                            ?>
                            <td><?php echo prod_plates_wise_dr($plate_arr[$j], $from_dt, $to_dt); ?></td>
                            <?php } ?>
                            <td><?php echo prod_plates_dr($from_dt, $to_dt); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div><br><br>

  </section>
</section>

<script type="text/javascript">
//Date Picker
$(function(){
    $( "#from_dt" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
});

$(function(){
    $( "#to_dt" ).datepicker({
        "dateFormat" : "yy-mm-dd"
    });
});

//Ajax Function
function filter(){
    var from_dt = document.getElementById("from_dt").value;
	var to_dt = document.getElementById("to_dt").value;
    
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
    
    var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt);
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/productionc/prod_daily_plates_ajax" + queryString,true);
    xmlhttp.send();
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