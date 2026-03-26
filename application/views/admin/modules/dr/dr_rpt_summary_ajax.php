<?php $this->load->helper("sales"); ?>
<?php 
    $dr_created_by = $_REQUEST['dr_created_by'];
    $dept = $_REQUEST['dept'];
    $from_dt = $_REQUEST['from_dt'];
    $to_dt = $_REQUEST['to_dt'];

    $where_cls = " where dr_date between '".$from_dt."' and '".$to_dt."'";

    if($dr_created_by == "All"){
        $where_cls .= "";
    } else {
        $where_cls .= " and dr_created_by = '".$dr_created_by."'";
    }

    if($dept == "All"){
        $where_cls .= "";
    } else {
        $where_cls .= " and dept ='".$dept."'";
    }

    $where_cls .= " order by dr_id";
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
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Dept</th>
                    <?php
                        $date = getDatesFromRange($from_dt, $to_dt); 
                        $arr_cnt = count($date);
                        for($i=0; $i<$arr_cnt;$i++){
                    ?>
                    <th><?php echo $date[$i]; ?></th>
                    <?php } ?>       
                </thead>
                <tbody>
                    <?php
                        $sql_dr = "select distinct dr_created_by, dept  from dr_mst ".$where_cls;
                        $qry_dr = $this->db->query($sql_dr);

                        //echo $sql_dr; die;

                        $sno = 0;
                        foreach($qry_dr->result() as $row){
                            $sno++;
                            $dr_created_by = $row->dr_created_by;
                            $dept = $row->dept;
                            
                    ?>
                    <tr>
                        <td><?=$sno;?></td>
                        <td><?=$dr_created_by;?></td>
                        <td><?=$dept;?></td>
                        <?php
                            $date = getDatesFromRange($from_dt, $to_dt); 
                            $arr_cnt = count($date);
                            for($j=0; $j<$arr_cnt;$j++){
                        ?>
                        <td><?php echo dr_date_wise($dr_created_by, $date[$j]); ?></td>
                        <?php } ?> 

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
