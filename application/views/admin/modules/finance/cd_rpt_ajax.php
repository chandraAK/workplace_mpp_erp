<?php $this->load->helper("finance"); ?>

<?php
    $from_dt = $_REQUEST['from_dt'];
    $to_dt = $_REQUEST['to_dt'];
    $comp_id = $_REQUEST['comp_id'];
?>

<div class="row">
    <div class="col-lg-9"><h4>Dinominations Report (<?php echo $to_dt." - ".$from_dt;?>)</h4></div>
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
</div>

<div id="printableArea">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered" id="testTable">
                <thead>
                    <tr>
                        <th><b>Date</b></th>
                        <?php
                            $sql = "select * from curr_unit_mst where curr_active = 1";
                            $qry = $this->db->query($sql);
                            $curr_arr = array();
                            foreach($qry->result() as $row){
                                $curr_name = $row->curr_name;
                                array_push($curr_arr, $curr_name);
                        ?>
                        <th><b><?php echo $curr_name; ?></b></th>
                        <?php } ?>
                        <th><b>Total</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $date = getDatesFromRange($from_dt, $to_dt); 
                        $arr_cnt = count($date);
                        $curr_cnt = count($curr_arr);
                        $tot_amt1 = 0;
                        for($i=0; $i<$arr_cnt;$i++){
                    ?>
                    <tr>
                        <td><?php echo $date[$i]; ?></td>
                        <?php
                            for($j=0;$j<$curr_cnt;$j++){
                        ?>
                        <td><?php echo cash_dino_det($curr_arr[$j],$date[$i],$comp_id); ?></td>
                        <?php
                            } 
                        ?>
                        <td style="background-color:#33e6ff"><?php echo $tot_amt = cash_dino_tot($date[$i],$comp_id); ?></td>
                    </tr>
                    <?php
                        $tot_amt1 = $tot_amt1+$tot_amt; 
                    } 
                    ?>
                    <!-- Dinominations total -->
                    <tr style="background-color:#33e6ff">
                        <td><b>Total</b></td>
                        <?php
                            for($k=0;$k<$curr_cnt;$k++){
                        ?>
                        <td><?php echo cash_dino_det_tot($curr_arr[$k], $from_dt, $to_dt, $comp_id); ?></td>
                        <?php
                            } 
                        ?>
                        <td><?=$tot_amt1;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>