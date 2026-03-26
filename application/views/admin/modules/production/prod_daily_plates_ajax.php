<?php $this->load->helper("production"); ?>

<?php
$from_dt = $_REQUEST['from_dt'];
$to_dt = $_REQUEST['to_dt'];
?>

<div class="row">
    <div class="col-lg-10"><h3>Production  (<?php echo $to_dt." - ".$from_dt;?>)</h3></div>
    <div class="col-lg-2">
        <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="testTable">
            <thead>
                <tr>
                    <th><b>Date</b></th>
                    <?php
                        $sql = "select * from plate_mst where plate_active = 1";
                        $qry = $this->db->query($sql);
                        $plate_arr = array();
                        foreach($qry->result() as $row){
                            $plate_name = $row->plate_name;
                            array_push($plate_arr, $plate_name);
                    ?>
                    <th><b><?php echo $plate_name; ?></b></th>
                    <?php } ?>
                    <th><b>Total</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $date = getDatesFromRange($from_dt, $to_dt); 
                    $arr_cnt = count($date);
                    $plate_cnt = count($plate_arr);
                    for($i=0; $i<$arr_cnt;$i++){
                ?>
                <tr>
                    <td><?php echo $date[$i]; ?></td>
                    <?php
                        $tot_prod = 0;
                        for($j=0;$j<$plate_cnt;$j++){
                    ?>
                    <td><?php echo $tot_prod1 = daily_prod_plates($plate_arr[$j],$date[$i]); ?></td>
                    <?php 
                        $tot_prod = $tot_prod+$tot_prod1;
                        } 
                    ?>
                    <td style="background-color:#33e6ff"><?php echo $tot_prod; ?></td>
                </tr>
                <?php } ?>
                <!-- Plate Wise total -->
                <tr style="background-color:#33e6ff">
                    <td><b>Total</b></td>
                    <?php
                        for($j=0;$j<$plate_cnt;$j++){
                    ?>
                    <td><?php echo prod_plates_wise_dr($plate_arr[$j], $from_dt, $to_dt); ?></td>
                    <?php } ?>
                    <td><?php echo prod_plates_dr($from_dt, $to_dt); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>