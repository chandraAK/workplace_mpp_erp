<?php 
    $this->load-> helper('sales');
    $db2 = $this->load->database('db2', TRUE);  
?>
    
<style>
    div.container { max-width : 1200px; }
    @page { size: auto;  margin: 0mm; }
</style>


<section id="main-content">
    <section class="wrapper"> 
        <div class="row">
            <div class="col-lg-12">
                <h4><i class="fa fa-laptop"></i> Pending Payment Reports</h4>
                <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
            </div> 
        </div>
        
        <div class="row">
            <div class="col-lg-1"><h5>From Date:</h5><b></div>
            <div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control"></div>
            <div class="col-lg-1"><h5>To Date:</h5></div>
            <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control"></div>
            <div class="col-lg-2"><input type="button" id="filter" name="today" value="Today" class="form-control" onclick="today_date()"></div>
            <div class="col-lg-2"><input type="button" id="filter" name="tomorrow" value="Tomorrow" class="form-control" onclick="tom_date()"></div>
            <div class="col-lg-2"><input type="button" id="filter" name="yesterday" value="Yesterday" class="form-control" onclick="yes_date()"></div>
        </div><br><br>
        <div class ="row">
            <div class="col-lg-1"><h5>Product Category:</h5></div>
            <div class="col-lg-2">
                <select id="prod_cat" name="prod_cat" value="" class="form-control">
                    <option value="a">Select</option><?php echo prod_cat();?>
                </select>
            </div>
            <div class="col-lg-1"><h5>Product:<h5></div>
            <div class="col-lg-2">
                <select id="prod" name="prod" value="" class="form-control">
                    <option value="a">Select</option><?php echo prod_name();?>
                </select>
            </div>
            <div class="col-lg-1"><h5>SO:</h5></div>
            <div class="col-lg-2">
                <select id="so" name="so" value="" class="form-control">
                <option value="a">Select</option><?php echo sales_order();?>
                </select>
            </div>
            <div class="col-lg-1"><h5>Amount:<h5></div>
            <div class="col-lg-1"><input type="text" id="amt1" name="amt1" value="" class="form-control" placeholder="Below"></div>
            <div class="col-lg-1"><input type="text" id="amt2" name="amt2" value="" class="form-control" placeholder="Above" ></div>
        </div><br><br>

        <div class ="row">
            <div  style="text-align: center;" class="col-lg-1">
                <input style="align:center;" type="button" id="filter" name="filter" value="Filter" class="form-control" onClick="filter()">
            </div>
        </div>       
        
        
        <?php  ?>

        <div class="row">
            <div class="col-lg-6"></div>
            <div class="col-lg-2">
                <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> 
                </button>
            </div>
            <div class="col-lg-2">
                <button onclick="printDiv('printableArea')" class="form-control">
                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> 
                </button>
            </div>
            <div class="col-lg-2">
                <button onclick="printDiv('printableArea')" class="form-control">
                    <i class="fa fa-print" aria-hidden="true"></i> 
                </button>
            </div>
        </div>

        <div class="row">
             <div class="col-lg-12"></div>
         </div><br><br>
         <!-- Ajax Response Div -->
        <div id="detail"></div>

        <!-- <div class="box-body table-responsive">
            <div id="printableArea">
           <?php //echo get_pending_payment(); ?>
                </table>
            </div>
        </div> -->
    
    </section>
</section>

<script type="text/javascript">
    function today_date(){
        var curr_date = new Date();
        curr_date = formatDate(curr_date);
        //alert(curr_date);
        document.getElementById("from_dt").value = curr_date;
        document.getElementById("to_dt").value = curr_date;
    }

    function yes_date(){
        var curr_date = new Date();
        var yes_date = new Date(curr_date);
        yes_date.setDate(curr_date.getDate() - 1);
        yes_date = formatDate(yes_date);
        document.getElementById("from_dt").value = yes_date;
        document.getElementById("to_dt").value = yes_date;
    }

    function tom_date(){
        var curr_date = new Date();
        var tom_date = new Date(curr_date);
        tom_date.setDate(curr_date.getDate() + 1);
        tom_date = formatDate(tom_date);
        document.getElementById("from_dt").value = tom_date;
        document.getElementById("to_dt").value = tom_date;
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [year, month, day].join('-');
    }
</script>

 <script type="text/javascript">
//Date Pickers
$( function() {
    $('#from_dt').datepicker({
        "dateFormat" : "yy-mm-dd" 
    });
});

$( function() {
    $('#to_dt').datepicker({
        "dateFormat" : "yy-mm-dd"       
    });
});
</script>

<script>
//Filter Ajax
//Ajax Function Filter Records
function filter(){
    var from_dt = document.getElementById("from_dt").value;
    var to_dt = document.getElementById("to_dt").value;
    var so = document.getElementById("so").value;
    var prod = document.getElementById("prod").value;
    var prod_cat = document.getElementById("prod_cat").value;
    var amtb = document.getElementById("amt1").value;
    var amta = document.getElementById("amt2").value;

    /* if(from_dt == ""){
        alert("Please select from date.");
        document.getElementById("from_dt").focus();
        return false;
    }

    if(to_dt == ""){
        alert("Please select To date.");
        document.getElementById("to_dt").focus();
        return false;
    }

    if(so == ""){
        alert("Please Select Sales Order");
        document.getElementById("so").focus();
        return false;
    }

    if(prod_cat == ""){
        alert("Please Select Product Category");
        document.getElementById("prod_cat").focus();
        return false;
    }
    if(prod == ""){
        alert("Please Select product");
        document.getElementById("prod").focus();
        return false;
    }

     *///alert(sales_person_nm);

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

    var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&prod_cat="+encodeURIComponent(prod_cat)+"&prod="+encodeURIComponent(prod)+"&so="+encodeURIComponent(so)+"&amtb="+encodeURIComponent(amtb)+"&amta="+encodeURIComponent(amta);

    xmlhttp.open("GET","<?php echo base_url(); ?>index.php/salesc/dr_pend_pay_filter_ajax" + queryString,true);
    xmlhttp.send();
}
</script> 
<!-- DATA TABES SCRIPT -->
<script>
function getDatesFromRange($start, $end, $format = 'Y-m-d'){     
        // Declare an empty array 
        $array = array(); 
          
        // Variable that store the date interval 
        // of period 1 day 
        $interval = new DateInterval('P1D'); 
      
        $realEnd = new DateTime($end); 
        $realEnd->add($interval); 
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
      
        // Use loop to store date into array 
        foreach($period as $date) {                  
            $array[] = $date->format($format);  
        } 
      
        // Return the array elements 
        return array_reverse($array); 
    }
</script>
  
