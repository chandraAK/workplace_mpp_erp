<?php $this->load->helper("finance"); ?>

<?php
    $from_dt = $_REQUEST['from_dt'];
    $to_dt = $_REQUEST['from_dt'];
    $comp_id = $_REQUEST['comp_id'];
?>

<div class="row">
    <div class="col-lg-9"><h4>Dinominations (<?php echo $from_dt; ?>)</h4></div>
    <div class="col-lg-1">
        <button onclick="tableToExcel('example1', 'W3C Example Table')" class="form-control">
            <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel
        </button>
    </div>
    <div class="col-lg-1">
        <button onclick="printDiv('printableArea')" class="form-control">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF
        </button>
    </div>
    <div class="col-lg-1">
        <button onclick="printDiv('printableArea')" class="form-control">
            <i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </div>
</div><br><br>

<div id="printableArea">
    <div class="row">
        <div class="col-lg-12">
            <table cellspadding="0" cellspacing="0" width="100%" style="font-size:14px; font-weight:bold; text-align:left">
                <tr>
                    <td>
                        <img src="<?php echo base_url(); ?>assets/admin/img/logo_choyal_main.png" width="20%" height="auto" />
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Choyal Cash Memo</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Vishvakarma Nagar, P.O. Saradhana - 305206</b></td>
                    <td></td>
                    <td>
                        <?php
                            $sql_comp_code = "select company_code from company_mst where company_id = '".$comp_id."'";
                            $qry_comp_code = $this->db->query($sql_comp_code)->row();
                            $comp_code = $qry_comp_code->company_code;
                            echo "<b>".$comp_code."</b>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><i class="fa fa-phone"></i> 0145-2782228, 0145-2782231</td>
                    <td></td>
                    <td>Date : <?=$from_dt;?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered" id="testTable">
                <thead>
                    <tr>
                        <th><b>Rupees</b></th>
                        <th><b>Count</b></th>
                        <th><b>Amount</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "select * from curr_unit_mst where curr_active = 1";
                        $qry = $this->db->query($sql);

                        $tot = 0;
                        foreach($qry->result() as $row){
                            $curr_name = $row->curr_name;
                            $tot = $curr_name*cash_dino_det($curr_name,$from_dt,$comp_id);
                    ?>
                    <tr>
                        <td><?php echo $curr_name; ?></td>
                        <td><?php echo cash_dino_det($curr_name,$from_dt,$comp_id); ?></td>
                        <td><?php echo $tot; ?></td>
                    </tr>
                    <?php } ?>
                    <tr style="background-color:#33e6ff">
                        <td></td>
                        <td><b>Total</b></td>
                        <td><b><?php echo $tot_amt = cash_dino_tot($from_dt,$comp_id); ?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div><br><br>

    <div class="row" style="text-align:center">
        <div class="col-lg-12">
            <table cellspadding="0" cellspacing="0" width="100%" style="font-size:14px; font-weight:bold; text-align:left">
                <tr>
                    <td>Cashier Sign.</td>
                    <td>Accountant Sign.</td>
                    <td>M. D. Sign</td>
                </tr>
            </table>
        </div>
    </div>
</div>