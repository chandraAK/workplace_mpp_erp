<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />

<style>
div.container { max-width : 1200px; }
@page { size: auto;  margin: 0mm; }
</style>

<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Salary Advance List</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <?php 
    $username = $_SESSION['username'];
    if($username == ""){
        $url = base_url()."index.php/logout";
        redirect($url);
    }

    $sql_user_det = "select * from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $email = $qry_user_det->email;
    $name = $qry_user_det->name;
    $emp_id1 = $qry_user_det->emp_id;
    //echo $emp_id;
    $role = $qry_user_det->role;
    ?>

    <div class="row">
        <div class="col-lg-9"><h4><?php echo $list_title; ?></h4></div>
        <div class="col-lg-1">
            <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> 
            </button>
        </div>
        <div class="col-lg-1">
            <button onclick="printDiv('printableArea')" class="form-control">
                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> 
            </button>
        </div>
        <div class="col-lg-1">
            <button onclick="printDiv('printableArea')" class="form-control">
                <i class="fa fa-print" aria-hidden="true"></i> 
            </button>
        </div>
    </div>
    

    <div class="row">
        <div class="box-body table-responsive">
        <div id="printableArea">
            <table class="table table-bordered" id="example1" style="margin-top:60px">
                <thead>
                    <tr style="background-color:#b3e6ff;">
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>pay_days</th>
                        <th>total_hrs</th>
                        <th>monthly_sal_type1</th>
                        <th>per_day_sal_type1</th>
                        <th>per_day_sal_type2</th>
                        <th>per_hour_salary_type2</th>
                        <th>advance_amt_type1</th>
                        <th>advance_amt_type2</th>
                        <th>Advance Payable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from advance_list";
                    $qry = $this->db->query($sql);

                    $tot_adv_amt_type1 = 0;
                    $tot_adv_amt_type2 = 0;
                    $tot_adv_payble = 0;
                    foreach($qry->result() as $row){
                        $emp_id = $row->emp_id;
                        $emp_name = $row->emp_name;
                        $adv_req = $row->adv_req;
                        $pay_days = $row->pay_days;
                        $total_hrs = $row->total_hrs;
                        $monthly_sal_type1 = $row->monthly_sal_type1;
                        $per_day_sal_type1 = $row->per_day_sal_type1;
                        $per_day_sal_type2 = $row->per_day_sal_type2;
                        $per_hour_salary_type2 = $row->per_hour_salary_type2;
                        $advance_amt_type1 = $row->advance_amt_type1;
                        $advance_amt_type2 = $row->advance_amt_type2;

                        $tot_adv_amt_type1 = $tot_adv_amt_type1+$advance_amt_type1;
                        $tot_adv_amt_type2 = $tot_adv_amt_type2+$advance_amt_type2;
                    ?>

                    <tr>
                        <td><?=$emp_id;?></td>
                        <td><?=$emp_name;?></td>
                        <td><?=$pay_days;?></td>
                        <td><?=$total_hrs;?></td>
                        <td><?=$monthly_sal_type1;?></td>
                        <td><?=$per_day_sal_type1;?></td>
                        <td><?=$per_day_sal_type2;?></td>
                        <td><?=$per_hour_salary_type2;?></td>
                        <td><?=$advance_amt_type1;?></td>
                        <td><?=$advance_amt_type2;?></td>
                        <td>
                        <?php
                            if($advance_amt_type1 > 0){
                                if($advance_amt_type1 > $adv_req){
                                    echo $adv_payable = $adv_req;
                                    $tot_adv_payble = $tot_adv_payble+$adv_payable;
                                } else if($advance_amt_type1 < $adv_req){
                                    echo $adv_payable = $advance_amt_type1;
                                    $tot_adv_payble = $tot_adv_payble+$adv_payable;
                                }
                            }

                            if($advance_amt_type2 > 0){
                                if($advance_amt_type2 > $adv_req){
                                    echo $adv_payable = $adv_req;
                                    $tot_adv_payble = $tot_adv_payble+$adv_payable;
                                } else if($advance_amt_type2 < $adv_req){
                                    echo $adv_payable = $advance_amt_type2;
                                    $tot_adv_payble = $tot_adv_payble+$adv_payable;
                                }
                            }
                        ?>
                        </td>
                    </tr>

                    <?php
                    }
                    ?>
                    
                    <tr>
                        <td colspan="10"></td>
                        <td><b><?=$tot_adv_payble;?></b></td>
                    </tr>
                </tbody>
            </table>
        </div> 
        </div> 
    </div><br /><br />

  </section>
</section>

<!-- DATA TABES SCRIPT -->
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