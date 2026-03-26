<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" rel="stylesheet" type="text/css" />
<style>
    div.container { max-width : 1200px; }
</style>

<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php
$col_name = $_REQUEST['col_name'];
$tbl_name = $_REQUEST['tbl_name'];
$start_dt = $_REQUEST['start_dt'];
$end_dt = $_REQUEST['end_dt'];
$employee_type = $_REQUEST['employee_type'];
$is_labour = $_REQUEST['is_labour'];
$comp_type = $_REQUEST['comp_type'];
$pay_status = $_REQUEST['pay_status'];
$cond = $_REQUEST['cond'];

$where_str = "";
if($employee_type == ""){
    $where_str .= " ";
} else {
    $where_str .= " and employee_type='".$employee_type."'";
}

if($is_labour == ""){
    $where_str .= " ";
} else {
    $where_str .= " and is_labour='".$is_labour."'";
}

if($comp_type == 'MDPL'){
    $where_str .= "and EmpId like '%EMP-MDPL%'";
} else if($comp_type == 'MPP'){
    $where_str .= "and EmpId like '%EMP-MPP%'";
} else {
    $where_str .= "and EmpId not like '%EMP-MDPL%'";
    $where_str .= "and EmpId not like '%EMP-MPP%'";
}

if($pay_status == "All"){
    $where_str .= " ";
} else {
    $where_str .= " and status = '".$pay_status."'";
}

if($cond == ""){
    $where_str .= " ";
} else {
    $where_str .= " and ".$cond;
}
?>

<section id="main-content">
  <section class="wrapper"> 
    <div class="row">
        <div class="col-lg-12">
            <h3><i class="fa fa-laptop"></i>Counter Sheet Details</h3>
            <?php require_once(APPPATH."views/admin/breadcrumb.php"); ?>
        </div> 
    </div>

    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
            </button>
        </div>
    </div>

    <div id="detail">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Card No</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Department</b></th>
                    <th><b>Reports To</b></th>
                    <th><b>Duty Hours</b></th>
                    <th><b>Emp Type</b></th>
                    <th><b>Salary Mode</b></th>
                    <th><b>Earned Salary</b></th>
                    <th><b>Gross Salary</b></th>
                    <th><b>Basic Salary</b></th>
                    <th><b>PF No.</b></th>
                    <th><b>PF Amount</b></th>
                    <th><b>ESIC No.</b></th>
                    <th><b>ESIC Amount</b></th>
                    <th><b>Salary Advance</b></th>
                    <th><b>Spcl Salary Advance</b></th>
                    <th><b>Loan</b></th>
                    <th><b>Previous Deduction</b></th>
                    <th><b>Negative Salary</b></th>
                    <th><b>Welfare</b></th>
                    <th><b>Arear</b></th>
                    <th><b>Deduction</b></th>
                    <th><b>Payable Salary</b></th>
                    <th><b>Bank Account No</b></th>
                    <th><b>Bank IFSC</b></th>
                    <th><b>Bank Name</b></th>
                    <th><b>Status</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="select * from $tbl_name 
                where date(month_start_date) = '".$start_dt."' 
                and date(month_end_date) = '".$end_dt."'
                $where_str";

                $qry = $this->db->query($sql);

                $NetSalaryTot = 0;
                $GrossSalTot = 0;
                $BasicSalTot = 0;
                $PF_Amt_Tot = 0;
                $esi_amt_Tot = 0;
                $tot_advance_amount_Tot = 0;
                $tot_spcl_advance_amount_Tot = 0;
                $tot_loan_amount_Tot = 0;
                $net_paybl_sal = 0;
                foreach($qry->result() as $row)
                {
                    $payroll_id = $row->payroll_id;
                    $CardNo = $row->CardNo;
                    $EmpId = $row->EmpId;
                    $EmpName = $row->EmpName;
                    $department = $row->department;
                    $reporte_name = $row->reporte_name;
                    $is_labour = $row->is_labour;
                    $duty_hours = $row->duty_hours;
                    $employee_type = $row->employee_type;
                    $salary_mode = $row->salary_mode;

                    /*if($is_labour == 1){
                        $NetSalary = $row->EmpTotSal;
                    } else {
                        $NetSalary = $row->NetSalary;
                    }*/

                    if($tbl_name == 'payroll_mst_type2'){
                        $NetSalary = $row->EmpTotSal;
                    } else {
                        $NetSalary = $row->NetSalary;
                    }

                    $GrossSal = $row->GrossSal;
                    $BasicSal = $row->BasicSal;
                    $uan_no = $row->uan_no;
                    $PF_Amt = $row->PF_Amt;
                    $esi_no = $row->esi_no;
                    $esi_amt = $row->esi_amt;
                    $tot_advance_amount = $row->tot_advance_amount;
                    $tot_spcl_advance_amount = $row->tot_spcl_advance_amount;
                    $tot_loan_amount = $row->tot_loan_amount;
                    
                    $prev_ded = $row->prev_ded;
                    $negitive_sal = $row->net_paybl_sal;
                    $welfare = $row->welfare;
                    $arrear = $row->arrear;
                    $deduction = $row->deduction;


                    $net_paybl_sal = $row->net_paybl_sal;
                    $bank_ac_no = $row->bank_ac_no;
                    $ifsc_code = $row->ifsc_code;
                    $bank_name = $row->bank_name;
                    $status = $row->status;
                ?>
                <tr>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$department;?></td>
                    <td><?=$reporte_name;?></td>
                    <td><?=$duty_hours;?></td>
                    <td><?=$employee_type;?></td>
                    <td><?=$salary_mode;?></td>
                    <td <?php if($col_name == 'NetSalary'){ echo 'style="background-color:yellow"'; } ?>><?=$NetSalary;?></td>
                    <td <?php if($col_name == 'GrossSal'){ echo 'style="background-color:yellow"'; } ?>><?=$GrossSal;?></td>
                    <td <?php if($col_name == 'BasicSal'){ echo 'style="background-color:yellow"'; } ?>><?=$BasicSal;?></td>
                    <td><?=$uan_no;?></td>
                    <td <?php if($col_name == 'PF_Amt'){ echo 'style="background-color:yellow"'; } ?>><?=$PF_Amt;?></td>
                    <td><?=$esi_no;?></td>
                    <td <?php if($col_name == 'esi_amt'){ echo 'style="background-color:yellow"'; } ?>><?=$esi_amt;?></td>
                    <td <?php if($col_name == 'tot_advance_amount'){ echo 'style="background-color:yellow"'; } ?>><?=$tot_advance_amount;?></td>
                    <td <?php if($col_name == 'tot_spcl_advance_amount'){ echo 'style="background-color:yellow"'; } ?>><?=$tot_spcl_advance_amount;?></td>
                    <td <?php if($col_name == 'tot_loan_amount'){ echo 'style="background-color:yellow"'; } ?>><?=$tot_loan_amount;?></td>

                    <td <?php if($col_name == 'prev_ded'){ echo 'style="background-color:yellow"'; } ?>><?=$prev_ded;?></td>
                    <td <?php if($cond != "" && $col_name == 'net_paybl_sal'){ echo 'style="background-color:yellow"'; } ?>><?=$negitive_sal;?></td>
                    <td <?php if($col_name == 'welfare'){ echo 'style="background-color:yellow"'; } ?>><?=$welfare;?></td>
                    <td <?php if($col_name == 'arrear'){ echo 'style="background-color:yellow"'; } ?>><?=$arrear;?></td>
                    <td <?php if($deduction == 'tot_loan_amount'){ echo 'style="background-color:yellow"'; } ?>><?=$deduction;?></td>

                    <td <?php if($cond == "" && $col_name == 'net_paybl_sal'){ echo 'style="background-color:yellow"'; } ?>><?=$net_paybl_sal;?></td>
                    <td><?=$bank_ac_no;?></td>
                    <td><?=$ifsc_code;?></td>
                    <td><?=$bank_name;?></td>
                    <td><?=$status;?></td>
                </tr>
                <?php
                    $NetSalaryTot = $NetSalaryTot+$NetSalary;
                    $GrossSalTot = $GrossSalTot+$GrossSal;
                    $BasicSalTot = $BasicSalTot+$BasicSal;
                    $PF_Amt_Tot = $PF_Amt_Tot+$PF_Amt;
                    $esi_amt_Tot = $esi_amt_Tot+$esi_amt;
                    $tot_advance_amount_Tot = $tot_advance_amount_Tot+$tot_advance_amount;
                    $tot_spcl_advance_amount_Tot = $tot_spcl_advance_amount_Tot+$tot_spcl_advance_amount;
                    $tot_loan_amount_Tot = $tot_loan_amount_Tot+$tot_loan_amount;
                    
                    $prev_ded_Tot = $prev_ded_Tot+$prev_ded;
                    $negitive_sal_Tot = $negitive_sal_Tot+$negitive_sal;
                    $welfare_Tot = $welfare_Tot+$welfare;
                    $arrear_Tot = $arrear_Tot+$arrear;
                    $deduction_Tot = $deduction_Tot+$deduction;

                    $net_paybl_sal_Tot = $net_paybl_sal_Tot+$net_paybl_sal;
                }
                ?>
                <tr style="font-weight:bold; background-color:#b3d9ff">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?=number_format($NetSalaryTot,2,".","");?></td>
                    <td><?=number_format($GrossSalTot,2,".","");?></td>
                    <td><?=number_format($BasicSalTot,2,".","");?></td>
                    <td></td>
                    <td><?=number_format($PF_Amt_Tot,2,".","");?></td>
                    <td></td>
                    <td><?=number_format($esi_amt_Tot,2,".","");?></td>
                    <td><?=number_format($tot_advance_amount_Tot,2,".","");?></td>
                    <td><?=number_format($tot_spcl_advance_amount_Tot,2,".","");?></td>
                    <td><?=number_format($tot_loan_amount_Tot,2,".","");?></td>

                    <td><?=number_format($prev_ded_Tot,2,".","");?></td>
                    <td><?=number_format($negitive_sal_Tot,2,".","");?></td>
                    <td><?=number_format($welfare_Tot,2,".","");?></td>
                    <td><?=number_format($arrear_Tot,2,".","");?></td>
                    <td><?=number_format($deduction_Tot,2,".","");?></td>

                    <td><?=number_format($net_paybl_sal_Tot,2,".","");?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
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