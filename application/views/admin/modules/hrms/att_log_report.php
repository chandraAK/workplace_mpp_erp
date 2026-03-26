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
            <h3><i class="fa fa-laptop"></i>Attendence Log Report</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-1"><b>From Date:<b></div>
        <div class="col-lg-2"><input type="text" id="from_dt" name="from_dt" value="" class="form-control" required></div>
        <div class="col-lg-1"><b>To Date:</b></div>
        <div class="col-lg-2"><input type="text" id="to_dt" name="to_dt" value="" class="form-control" required></div>
        <div class="col-lg-1"><b>Card No:</b></div>
        <div class="col-lg-2"><select id="CardNo" name="CardNo" class="form-control" required><?php echo CardNo();?></select></div>
        <div class="col-lg-2"><input type="button" id="filter" name="filter" value="Filter" class="form-control" onClick="filter()"></div>
        <div class="col-lg-1"></div>
    </div><br><br>

    <div class="row">
        <div class="box-body table-responsive" id="detail">
            <table class="table table-bordered" id="example1" style="margin-top:60px">
                <thead>
                    <tr>
                        <th>Card No</th>
                        <th>Punch Time</th>
                        <th>Machine No</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

  </section>
</section>

<script type="text/javascript">
    //Select2
    $(function(){
        $("#CardNo").select2();
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

    //Filter Ajax
    //Ajax Function Filter Records
    function filter(){
        var from_dt = document.getElementById("from_dt").value;
        var to_dt = document.getElementById("to_dt").value;
        var CardNo = document.getElementById("CardNo").value;
        
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

        if(CardNo == ""){
            alert("Please Card Number.");
            document.getElementById("CardNo").focus();
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
        
        var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&CardNo="+encodeURIComponent(CardNo);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/att_log_report_ajax" + queryString,true);
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