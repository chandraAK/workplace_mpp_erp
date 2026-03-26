<div class="row">
    <div class="col-sm-12">
        <h3 style="text-align:center">Conversations</h3>
        <table class="table table-bordered" style="text-align:left">
                <tr>
                    <th>SNO.</th>
                    <th>Converstion</th>
                    <th>Date</th>
                </tr>
                <?php
                    $sql_conv = "select * from crm_inq_conv where inq_no = '".$inq_no."'";
                    $qry_conv = $this->db->query($sql_conv);

                    $sno=0;
                    foreach($qry_conv->result() as $row){
                        $sno++;
                        $inq_conv = $row->inq_conv;
                        $inq_conv_date = $row->inq_conv_date;
                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$inq_conv;?></td>
                    <td><?=substr($inq_conv_date,0,11);?></td>
                </tr>
                <?php } ?>
        </table>
    </div>
</div>