<?php
    //Request Values
    $from_dt = $_REQUEST['from_dt'];
    $to_dt = $_REQUEST['to_dt'];
    $status = $_REQUEST['status'];

    $where_str = "";

    if($from_dt == "" || $to_dt == ""){

        if($status != ""){
            $where_str .= " where inq_status = '".$status."'";
        }

    } else {
        if($status != ""){
            $where_str .= " where inq_rec_on between '".$from_dt."' and '".$to_dt."' and inq_status = '".$status."'";
        } else {
            $where_str .= " where inq_rec_on between '".$from_dt."' and '".$to_dt."'";
        }
    }
?>

<table class="table table-bordered" id="example1">
    <thead>
        <tr style="background-color:#33f9ff">
            <th>S.No.</th>
            <th>Inquiry No.</th>
            <th>Received Date</th>
            <th>Source</th>
            <th>Contact Person</th>
            <th>Address</th>
            <th>Follow Up Date</th>
            <th>Status</th>
            <th>Email</th>
            <th>Mobile No.</th>
            <th>Edit</th>
    </thead>
    <tbody>
        <?php
            $sql_inq = "select * from crm_inq_mst ".$where_str." order by inq_no desc";
            $qry_inq = $this->db->query($sql_inq);
            $sno=0;
            foreach($qry_inq->result() as $row){
                $sno++;
        ?>
        <tr>
            <td><?php echo $sno; ?></td>
            <td>
                <a href="<?php echo base_url();?>index.php/crmc/inquiry_form?id=<?php echo $row->inq_no; ?>">
                    <?php echo $row->inq_no; ?>
                </a>
            </td>
            <td><?php echo $row->inq_rec_on; ?></td>
            <td><?php echo $row->inq_source; ?></td>
            <td><?php echo $row->inq_contact_person; ?></td>
            <td><?php echo $row->inq_add." ".$row->inq_add_dist." ".$row->inq_add_state; ?></td>
            <td><?php echo $row->inq_folup_date; ?></td>
            <td><?php echo $row->inq_status; ?></td>
            <td><?php echo $row->inq_email1; ?></td>
            <td><?php echo $row->inq_mob1; ?></td>
            <td>
                <a href="<?php echo base_url();?>index.php/crmc/inquiry_form?id=<?php echo $row->inq_no; ?>">
                    <i class="fa fa-pencil">Edit</i>
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>