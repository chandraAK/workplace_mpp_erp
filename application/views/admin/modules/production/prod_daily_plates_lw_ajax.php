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
                    <th></th>
                    <?php
                        $sql_labour = "select * from labour_mst where labour_active = 1";
                        $qry_labour = $this->db->query($sql_labour);
                        $labour_arr = array();
                        foreach($qry_labour->result() as $row){
                            $labour_name = $row->labour_name;
                            array_push($labour_arr, $labour_name);
                    ?>
                    <th colspan="7" style="text-align:center"><b><?=$labour_name; ?></b></th>
                    <?php } ?>
                    <?php
                        foreach($qry_labour->result() as $row){
                    ?>
                    <th></th>
                    <?php } ?>
                    <th></th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th><b>Date</b></th>
                    <?php
                        $sql_lab_cnt = "select count(*) as lab_cnt from labour_mst where labour_active = 1";
                        $qry_lab_cnt = $this->db->query($sql_lab_cnt)->row();
                        $lab_cnt = $qry_lab_cnt->lab_cnt;

                        for($m=0;$m<$lab_cnt;$m++){

                        $sql = "select * from plate_mst where plate_active = 1";
                        $qry = $this->db->query($sql);
                        $plate_arr = array();
                        foreach($qry->result() as $row){
                            $plate_name = $row->plate_name;
                            array_push($plate_arr, $plate_name);
                    ?>
                    <th><b><?php echo $plate_name; ?></b></th>
                    <?php } ?>
                    <?php } ?>
                    <?php
                        foreach($qry_labour->result() as $row){
                            $labour_name = $row->labour_name;
                    ?>
                    <th><b><?=$labour_name;?><br>Total Plates</b></th>
                    <?php } ?>
                    <th>Day Total Plates</th>
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
                        $labour_cnt = count($labour_arr);
                        for($n=0;$n<$labour_cnt;$n++){
                    ?>
                    <?php
                        for($j=0;$j<$plate_cnt;$j++){
                    ?>
                    <td><?php echo $tot_prod1 = daily_prod_plates_lw($plate_arr[$j],$date[$i],$labour_arr[$n]); ?></td>
                    <?php } ?>
                    <?php } ?>

                    <?php
                        foreach($qry_labour->result() as $row){
                    ?>
                    <td><?=daily_prod_lab_datewise($date[$i],$row->labour_name);?></td>
                    <?php } ?>
                    <td><?=daily_prod_datewise($date[$i]);?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>