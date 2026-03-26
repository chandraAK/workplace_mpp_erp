<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php
$from_dt = $_REQUEST['from_dt'];
$to_dt = $_REQUEST['to_dt'];
$sales_person_nm = $_REQUEST['sales_person_nm'];

 if($sales_person_nm == "All"){
    $where_str = "";
} else {
    $where_str = " and sales_person_name = '".$sales_person_nm."'";
} 
?>

<div class="row">
    <div class="col-lg-6"></div>
    <div class="col-lg-2">
        <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
        </button>
    </div>
    <div class="col-lg-2">
        <button onclick="printDiv('printableArea')" class="form-control">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF
        </button>
    </div>
    <div class="col-lg-2">
        <button onclick="printDiv('printableArea')" class="form-control">
            <i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </div>
</div>

<div class="box-body table-responsive">
        <div id="printableArea">
            <table class="table table-bordered" id="example1" style="margin-top:60px">
                <thead>
                        <th>SNO</th>
                        <th>Invoice Number</th>
                        <th>Invoice Amount</th>
                        <th>Sales Person Name</th>
                        <th>Due Date</th>
                        <th>Commitment Date</th>
                        <th>Commitment Amount</th>
                        <th>Received Amount</th>
                        <th>Pending Amount</th>
                        <th>Remarks</th>
                </thead>
                <tbody>
                    <?php
                        $sql_sales_inv = "select * from `tabSales Invoice` where due_date between '".$from_dt."' and '".$to_dt."'".$where_str;
                        //echo $sql_sales_inv; die;
                        $qry_sales_inv = $db2->query($sql_sales_inv);

                        $sno = 0;
                        foreach($qry_sales_inv->result() as $row){
                            $sno++;
                            $inv_no = $row->name;
                            $inv_tot_amt = $row->rounded_total;
                            $sales_person_name = $row->sales_person_name;
                            $due_date = $row->due_date;
                            $commitment_date = $row->commitment_date;
                            $commitment_amt = $row->commitment_amt;

                            $sql_rec_amt = "select sum(allocated_amount) as tot_rec_amt from `tabPayment Entry Reference` 
                            where reference_name = '".$inv_no."'";
                            $qry_rec_amt = $db2->query($sql_rec_amt)->row();
                            $tot_rec_amt = $qry_rec_amt->tot_rec_amt;
                            if($total_rec_amt == 0){
                                $tot_rec_amt = 0;
                            }

                            $tot_pending_amt = $inv_tot_amt - $tot_rec_amt;
                    ?>
                    <tr>
                        <td><?=$sno;?></td>
                        <td><?=$inv_no;?></td>
                        <td><?=number_format($inv_tot_amt,2);?></td>
                        <td><?=$sales_person_name;?></td>
                        <td><?=$due_date;?></td>
                        <td><?=$commitment_date;?></td>
                        <td><?=number_format($commitment_amt,2);?></td>
                        <td><?=number_format($tot_rec_amt,2);?></td>
                        <td><?=number_format($tot_pending_amt,2);?></td>
                        <td></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>