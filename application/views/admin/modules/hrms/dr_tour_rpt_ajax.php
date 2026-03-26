<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$card_no = $_REQUEST['card_no']; 
$from_date = $_REQUEST['from_date']; 
$to_date = $_REQUEST['to_date']; 
?>
<?php
//Get Employee ID
$sql_get_empid = "select name from `tabEmployee` where card_no = '".$card_no."'";
$qry_get_empid = $db2->query($sql_get_empid)->row();
$emp_id = $qry_get_empid->name;

//Get User Name
$sql_get_usernm = "select username from login where emp_id = '".$emp_id."'";
$qry_get_usernm = $this->db->query($sql_get_usernm)->row();
$username = $qry_get_usernm->username;
?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="testTable">
            <thead>
                <tr>
                    <th><b>S.No.</b></th>
                    <th><b>Date</b></th>
                    <th><b>DR Number</b></th>
                    <th><b>DR Status</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_dr_det = "select * from dr_hrms_mst 
                    where dr_emp_id = '".$emp_id."' 
                    and dr_date between '".$from_date."' and '".$to_date."'
                    order by dr_date
                    ";

                    $qry_dr_det = $this->db->query($sql_dr_det);
                    $sno = 0;
                    foreach($qry_dr_det->result() as $row){
                        $sno++;
                        $dr_id = $row->dr_id;
                        $dr_date = $row->dr_date;
                        $dr_status = $row->dr_status;
                ?>
                <tr>
                    <td><?=$sno;?></td>
                    <td><?=$dr_date;?></td>
                    <td>
                        <a href="<?php echo base_url();?>index.php/hrmsc/dr_form?id=<?=$dr_id;?>" target="_blank">
                            <?=$dr_id;?>
                        </a>
                    </td>
                    <td><?=$dr_status;?></td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>