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
                            <th></th>
                            <?php
                                $sql_labour = "select * from labour_mst where labour_active = 1";
                                $qry_labour = $this->db->query($sql_labour);
                                $labour_arr = array();
                                foreach($qry_labour->result() as $row){
                                    $labour_name = $row->labour_name;
                                    array_push($labour_arr, $labour_name);
                            ?>
                            <th colspan="7" style="text-align:center"><b><?=$labour_name; ?></b></th>
                            <?php } ?>
                            <?php
                                foreach($qry_labour->result() as $row){
                            ?>
                            <th></th>
                            <?php } ?>
                            <th></th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th><b>Date</b></th>
                            <?php
                                $sql_lab_cnt = "select count(*) as lab_cnt from labour_mst where labour_active = 1";
                                $qry_lab_cnt = $this->db->query($sql_lab_cnt)->row();
                                $lab_cnt = $qry_lab_cnt->lab_cnt;

                                for($m=0;$m<$lab_cnt;$m++){

                                $sql = "select * from plate_mst where plate_active = 1";
                                $qry = $this->db->query($sql);
                                $plate_arr = array();
                                foreach($qry->result() as $row){
                                    $plate_name = $row->plate_name;
                                    array_push($plate_arr, $plate_name);
                            ?>
                            <th><b><?php echo $plate_name; ?></b></th>
                            <?php } ?>
                            <?php } ?>
                            <?php
                                foreach($qry_labour->result() as $row){
                                    $labour_name = $row->labour_name;
                            ?>
                            <th><b><?=$labour_name;?><br>Total Plates</b></th>
                            <?php } ?>
                            <th>Day Total Plates</th>
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
                                $labour_cnt = count($labour_arr);
                                for($n=0;$n<$labour_cnt;$n++){
                            ?>
                            <?php
                                for($j=0;$j<$plate_cnt;$j++){
                            ?>
                            <td><?php echo $tot_prod1 = daily_prod_plates_lw($plate_arr[$j],$date[$i],$labour_arr[$n]); ?></td>
                            <?php } ?>
                            <?php } ?>

                            <?php
                                foreach($qry_labour->result() as $row){
                            ?>
                            <td><?=daily_prod_lab_datewise($date[$i],$row->labour_name);?></td>
                            <?php } ?>
                            <td><?=daily_prod_datewise($date[$i]);?></td>
                        </tr>
                        <?php } ?>
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
    
    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/productionc/prod_daily_plates_lw_ajax" + queryString,true);
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