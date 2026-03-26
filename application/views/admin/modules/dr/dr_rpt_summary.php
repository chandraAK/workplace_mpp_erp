<?php
 $this->load->helper("dr"); ?>
<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />

<style>
div.container { max-width : 1200px; }
@page { size: auto;  margin: 0mm; }
</style>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>DR Report Summary</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>
    
    <div class="row">
        <div class="col-lg-1"><b>Name:<b></div>
        <div class="col-lg-1">
            <select id="dr_created_by" name="dr_created_by" class="form-control">
                <option value="All">All</option>
                <?php echo dr_sales_name();?>
            </select>
        </div>
        <div class="col-lg-1"><b>Dept:</b></div>
        <div class="col-lg-1">
            <select id="dept" name="dept" class="form-control">
                <option value="All">ALL</option>
                <?php echo dr_dept();?>
            </select>
        </div>
       
        <div class="col-lg-1"><b>From Date:<b></div>
        <div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control"></div>
        <div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control"></div>
        <div class="col-lg-1">
            <input type="button" id="filter" name="filter" value="Filter" class="form-control" onClick="filter()">
        </div>
        <div class="col-lg-1"></div>
    </div><br><br>
    
    <!-- Ajax Response Div -->
    <div id="detail"></div>
    
  </section>
</section>


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
        var dept = document.getElementById("dept").value;
        var dr_created_by = document.getElementById("dr_created_by").value;
        
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

        if(dr_created_by == ""){
            alert("Please Select Sales Person Name");
            document.getElementById("dr_created_by").focus();
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
        
        var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&dr_created_by="+encodeURIComponent(dr_created_by)+"&dept="+encodeURIComponent(dept);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/drc/dr_rpt_summary_ajax" + queryString,true);
        xmlhttp.send();
    }
</script>
