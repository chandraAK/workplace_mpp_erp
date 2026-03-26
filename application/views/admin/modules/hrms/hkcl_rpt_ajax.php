<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$att_month = $_REQUEST['att_month'];
$att_year = $_REQUEST['att_year'];

//Month Start Date
$start_dt = $att_year."-".$att_month."-01";

//End Date
$sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
$qry_end_dt = $this->db->query($sql_end_dt)->row();
$end_dt = $qry_end_dt->end_dt;

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SNO</th>
                    <th>Date</th>
                    <th>Housekeeping Labours</th>
                    <th>Construction Labours</th>
                    <th>Housekeeping Labours Rate</th>
                    <th>Construction Labours Rate</th>
                    <th>Housekeeping Labours Amount</th>
                    <th>Construction Labours Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $dates = getDatesFromRange($start_dt, $end_dt);

                $sno=0;
                $hk_amt_tot = 0;
                $con_amt_tot = 0;
                foreach ($dates as $key => $value) {
                    $sno++;
                    $AttDate = $value;
                    $hk_rate = 330;
                    $con_rate = 0;
                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$AttDate;?></td>
                    <td><?=$hk_cnt = hkcl_dr_cnt($AttDate, "Housekeeping");?></td>
                    <td><?=$con_cnt = hkcl_dr_cnt($AttDate, "Construction");?></td>
                    <td><?=$hk_rate;?></td>
                    <td><?=$con_rate;?></td>
                    <td>
                    <?php
                        $hk_amt = $hk_cnt * $hk_rate;
                        echo number_format($hk_amt,2,".","");
                    ?>
                    </td>
                    <td>
                    <?php
                        $con_amt = $con_cnt * $con_rate;
                        echo number_format($con_amt,2,".","");
                    ?>
                    </td>
                </tr>
                <?php
                    $hk_amt_tot = $hk_amt_tot+$hk_amt;
                    $con_amt_tot = $con_amt_tot+$con_amt;
                }
                ?>
                <tr style="font-weight:bold; background-color:#99d6ff">
                    <td colspan="6">Total</td>
                    <td><?=number_format($hk_amt_tot,2,".","");?></td>
                    <td><?=number_format($con_amt_tot,2,".","");?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>