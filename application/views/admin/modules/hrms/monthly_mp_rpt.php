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
            <h3><i class="fa fa-laptop"></i>Monthwise Mispunch Report</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-2">
            <b>From Date:<b>
            <input type="text" id="from_dt" name="from_dt" value="<?=date("Y-m-d",strtotime("-1 days")); ?>" class="form-control">
        </div>

        <div class="col-lg-2">
            <b>To Date:</b>
            <input type="text" id="to_dt" name="to_dt" value="<?=date("Y-m-d",strtotime("-1 days")); ?>" class="form-control">
        </div>

        <div class="col-lg-2">
            <b>Department:</b>
            <select id="dept" name="dept[]" class="form-control dept_arr" multiple>
                <option value="All" selected>All</option>
                <?php echo dept_list(); ?>
            </select>
        </div>

        <div class="col-lg-2">
            <b>HOD:</b>
            <select id="hod" name="hod[]" class="form-control hod_arr" multiple>
                <option value="All" selected>All</option>
                <?php echo hod_list(); ?>
            </select>
        </div>

        <div class="col-lg-2">
            <b>Attendence Mode:</b>
            <select id="att_type" name="att_type[]" class="form-control att_type_arr" multiple>
                <option value="All" selected>All</option>
                <?php echo att_type_list(); ?>
            </select>
        </div>

        <div class="col-lg-1">
            <br/>
            <input type="button" id="filter" name="filter" value="Filter" class="form-control" onClick="filter()">
        </div>
    </div><br><br>
    
    <!-- Ajax Response Div -->
    <?php
    $MonthStartDate = date("Y-m-")."01";
    $CurrDate = date("Y-m-d");

    $from_dt = $MonthStartDate;
    $to_dt = $CurrDate;

    ?>

    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
            </button>
        </div>
    </div>

    <div class="row">
        <div class="box-body table-responsive" id="detail">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Card No</th>
                    <th>Employee</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>HOD</th>
                    <th>Pay Days</th>
                    <th>Late Coming</th>
                    <th>Early Exit</th>
                    <th>Overtime</th>          
                </tr>
            </thead>
        </table>
        </div>
    </div>

  </section>
</section>

<script type="text/javascript">
    //Date Pickers
    $(function(){
        $("#from_dt").datepicker({
            "dateFormat" : "yy-mm-dd"
        });
    });

    $(function(){
        $("#to_dt").datepicker({
            "dateFormat" : "yy-mm-dd"
        });
    });

    $(function(){
        $("#dept").select2({
            placeholder: "Choose elements",
            width: "100%"
        });
    });

    $(function(){
        $("#hod").select2({
            placeholder: "Choose elements",
            width: "100%"
        });
    });

    $(function(){
        $("#att_type").select2({
            placeholder: "Choose elements",
            width: "100%"
        });
    });

    //Filter Ajax
    //Ajax Function Filter Records
    function filter(){
        var from_dt = document.getElementById("from_dt").value;
        var to_dt = document.getElementById("to_dt").value;
        var dept = document.getElementById("dept").value;
        var hod = document.getElementById("hod").value;
        var att_type = document.getElementById("att_type").value;
        
        //NULL Checking
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

        if(dept == ""){
            alert("Please select Department");
            document.getElementById("dept").focus();
            return false;
        }

        if(hod == ""){
            alert("Please Select HOD");
            document.getElementById("hod").focus();
            return false;
        }

        if(att_type == ""){
            alert("Please select To date.");
            document.getElementById("att_type").focus();
            return false;
        }

        //Selecting Multiple Values
        //Dept
        var type_dept = [];
        $.each($(".dept_arr option:selected"), function(){            
            type_dept.push($(this).val());
        });
            
        var dept1 = JSON.stringify(type_dept);
        
        //Hod
        var type_hod = [];
        $.each($(".hod_arr option:selected"), function(){            
            type_hod.push($(this).val());
        });
            
        var hod1 = JSON.stringify(type_hod);
        
        //Attendence Type
        var type_att = [];
        $.each($(".att_type_arr option:selected"), function(){            
            type_att.push($(this).val());
        });
            
        var att_type1 = JSON.stringify(type_att);

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
        
        var queryString="?from_dt="+encodeURIComponent(from_dt)+"&to_dt="+encodeURIComponent(to_dt)+"&dept="+encodeURIComponent(dept1)+"&hod="+encodeURIComponent(hod1)+"&att_type="+encodeURIComponent(att_type1);
        
        xmlhttp.open("GET","<?php echo base_url(); ?>index.php/hrmsc/monthly_mp_rpt_ajax" + queryString,true);
        xmlhttp.send();
    }
</script>

<!-- DATA TABES SCRIPT -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

<script type="text/javascript">
    /*
    $(function() {
        $('#example1').dataTable({
            fixedHeader: true
        });
        
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
        
    });
    */
    
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