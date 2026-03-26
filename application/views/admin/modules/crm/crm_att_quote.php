<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <h3 style="text-align:center">Attached Quotations</h3>
        <table class="table table-bordered" style="text-align:left">
            <thead>
                <tr>
                    <th>SNO.</th>
                    <th>Inquiry No.</th>
                    <th>Quotation Level</th>
                    <th>Quotation</th>
                    <th>Quotation By</th>
                    <th>Quotation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_conv = "select * from crm_inq_quote_att where inq_no = '".$inq_no."'";
                    $qry_conv = $this->db->query($sql_conv);

                    $sno=0;
                    foreach($qry_conv->result() as $row){
                        $sno++;
                        $inq_no = $row->inq_no;
                        $quote_lvl = $row->quote_lvl;
                        $file_name = $row->file_name;
                        $quote_by = $row->quote_by;
                        $quote_date = $row->quote_date;
                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$inq_no;?></td>
                    <td><?=$quote_lvl;?></td>
                    <td><a href="<?php echo base_url(); ?>uploads/<?=$file_name;?>"><?=$file_name;?></a></td>
                    <td><?=$quote_by;?></td>
                    <td><?=$quote_date;?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-sm-1"></div>
</div>