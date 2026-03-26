<?php $this->load->helper("hrms"); ?>

<?php
$sql_emp = "select distinct CardNo from mpp_emp_mst";
$qry_emp = $this->db->query($sql_emp);

foreach($qry_emp->result() as $row){
    $CardNo = $row->CardNo;
    $from_dt = date("Y-m")."-01";
    $to_dt = date("Y-m")."-20";
    
    $gross_sal = 0;
    $PerDaySal = 0;
    $tot_adv_amt_type1 = 0;
    $duty_hours = 0;
    $wages = 0;  
    $tot_adv_amt_type2 = 0;

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$from_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $end_dt1 = strtotime($end_dt);
    $start_dt1 = strtotime($from_dt);

    $datediff = $end_dt1 - $start_dt1;
    $datediff1 = round($datediff / (60 * 60 * 24));
    $datediff1 = $datediff1+1;

    $sql_emp_det = "select EmpID, EmpName, SalaryType, Salary, DutyHours, PayMode from mpp_emp_mst where CardNo = '".$CardNo."'";
    $qry_emp_det = $this->db->query($sql_emp_det)->row();
    $EmpID = $qry_emp_det->EmpID;
    $EmpName = $qry_emp_det->EmpName;
    $SalaryType = $qry_emp_det->SalaryType;
    $Salary = $qry_emp_det->Salary;
    $DutyHours = $qry_emp_det->DutyHours;
    $PayMode = $qry_emp_det->PayMode;

    $pay_days = tot_paid_days_mpp($from_dt, $to_dt, $CardNo);
    $total_hrs = tot_hrs_cal_mpp_dw($from_dt, $to_dt, $CardNo);

    if($SalaryType == "Monthly"){
        //Getting Monthly Salary
        $gross_sal = $Salary;
        $gross_sal = number_format($gross_sal,2,".","");
        $PerDaySal = $gross_sal / $datediff1;
        $PerDaySal = number_format($PerDaySal,2,".","");
        $tot_adv_amt_type1 = ($PerDaySal * $pay_days) * 0.6;
        $tot_adv_amt_type1 = number_format($tot_adv_amt_type1,2,".","");
        
    } else {
        $gross_sal = 0;
        $PerDaySal = 0;
        $tot_adv_amt_type1 = 0;
    }


    if($SalaryType == "Daily"){
        //Getting Duty Hours & Wages Employee
        if($Salary == NULL || $Salary == ""){
            $per_hr_sal = 0;
        } else {
            $per_hr_sal = number_format($Salary / $DutyHours,2,".","");
        }

        $tot_adv_amt_type2 = ($per_hr_sal * $total_hrs) * 0.6;
        $tot_adv_amt_type2 = number_format($tot_adv_amt_type2,2,".","");
    } else {
        $DutyHours = 0;
        $Salary = 0;  
        $tot_adv_amt_type2 = 0; 
    }

    $sql_cnt = "select count(*) as cnt from advance_list_mpp 
    where CardNo = '".$CardNo."' 
    and adv_from_date = '".$from_dt."'
    and adv_to_date = '".$to_dt."'";

    $qry_cnt = $this->db->query($sql_cnt)->row();

    $cnt = $qry_cnt->cnt;

    if($cnt > 0){
        //Deleting Previous Entries
        $this->db->query("delete from advance_list_mpp 
        where CardNo = '".$CardNo."' 
        and adv_from_date = '".$from_dt."'
        and adv_to_date = '".$to_dt."'");

        //Inserting Records
        $this->db->query("insert into advance_list_mpp(CardNo, emp_id, EmpName, PayMode, pay_days, 
        total_hrs, monthly_sal_type1, per_day_sal_type1, 
        per_day_sal_type2, per_hour_salary_type2, advance_amt_type1, 
        advance_amt_type2, adv_from_date, adv_to_date)
        values
        ('".$CardNo."', '".$EmpID."', '".$EmpName."', '".$PayMode."', '".$pay_days."', 
        '".$total_hrs."', '".$gross_sal."', '".$PerDaySal."', 
        '".$Salary."', '".$per_hr_sal."', '".$tot_adv_amt_type1."', 
        '".$tot_adv_amt_type2."','".$from_dt."','".$to_dt."')");

    } else {

        //Inserting Records
        $this->db->query("insert into advance_list_mpp(CardNo, emp_id, EmpName, PayMode, pay_days, 
        total_hrs, monthly_sal_type1, per_day_sal_type1, 
        per_day_sal_type2, per_hour_salary_type2, advance_amt_type1, 
        advance_amt_type2, adv_from_date, adv_to_date)
        values
        ('".$CardNo."', '".$EmpID."', '".$EmpName."', '".$PayMode."', '".$pay_days."', 
        '".$total_hrs."', '".$gross_sal."', '".$PerDaySal."', 
        '".$Salary."', '".$per_hr_sal."', '".$tot_adv_amt_type1."', 
        '".$tot_adv_amt_type2."','".$from_dt."','".$to_dt."')");
    }
}
?>

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
            <h3><i class="fa fa-laptop"></i>Salary Advance List MPP</h3>
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
                        <th>Card No</th>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Pay Mode</th>
                        <th>Pay Days</th>
                        <th>Total Hours</th>
                        <th>Monthly Salary (Type 1)</th>
                        <th>Per Day Sal (Type 1)</th>
                        <th>Per Day Sal (Type 2)</th>
                        <th>Per Hour Salary (Type 2)</th>
                        <th>System Advance (Type 1)</th>
                        <th>System Advance (Type 2)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "select * from advance_list_mpp where adv_from_date = '".$from_dt."'
                    and adv_to_date = '".$to_dt."'";

                    $qry = $this->db->query($sql);

                    $tot_adv_amt_type1 = 0;
                    $tot_adv_amt_type2 = 0;
                    $tot_adv_payble = 0;
                    foreach($qry->result() as $row){
                        $CardNo = $row->CardNo;
                        $emp_id = $row->emp_id;
                        $EmpName = $row->EmpName;
                        $PayMode = $row->PayMode;
                        $pay_days = $row->pay_days;
                        $total_hrs = $row->total_hrs;
                        $monthly_sal_type1 = $row->monthly_sal_type1;
                        $per_day_sal_type1 = $row->per_day_sal_type1;
                        $per_day_sal_type2 = $row->per_day_sal_type2;
                        $per_hour_salary_type2 = $row->per_hour_salary_type2;
                        $advance_amt_type1 = $row->advance_amt_type1;
                        $advance_amt_type2 = $row->advance_amt_type2;
                    ?>

                    <tr>
                        <td><?=$CardNo;?></td>
                        <td><?=$emp_id;?></td>
                        <td><?=$EmpName;?></td>
                        <td><?=$PayMode;?></td>
                        <td><?=$pay_days;?></td>
                        <td><?=$total_hrs;?></td>
                        <td><?=$monthly_sal_type1;?></td>
                        <td><?=$per_day_sal_type1;?></td>
                        <td><?=$per_day_sal_type2;?></td>
                        <td><?=$per_hour_salary_type2;?></td>
                        <td><?=$advance_amt_type1;?></td>
                        <td><?=$advance_amt_type2;?></td>
                    </tr>
                    <?php
                    }
                    ?>
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
            responsive: false,
            paging: false
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