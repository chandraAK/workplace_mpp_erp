<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php 
$username = $_SESSION['username'];
if($username == ""){
    $url = base_url()."index.php/logout";
    redirect($url);
}

$sql_user_det = "select * from login where username = '".$username."'";
$qry_user_det = $this->db->query($sql_user_det)->row();
$email = $qry_user_det->email;
$name = $qry_user_det->name;
$emp_id1 = $qry_user_det->emp_id;
$role = $qry_user_det->role;
?>

<?php
    $type = $_REQUEST['type'];

    $where_str = "";
    if($type == 'All'){
        $where_str .= "";
    } else {
        $where_str .= " where type = '".$type."'";
    }
?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Type</b></th>
                    <th><b>Created By</b></th>
                    <th><b>Created Date</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql_emp = "select * from mpp_prod_oth_emp_mst  $where_str";

                    $qry_emp = $this->db->query($sql_emp);

                    $sno = 0;
                    $sal_adv_req_Tot = 0;
                    foreach($qry_emp->result() as $row){
                        $sno++;
                        $emp_id = $row->emp_id;
                        $emp_name = $row->emp_name;
                        $type = $row->type;
                        $created_by = $row->created_by;
                        $created_date = $row->created_date;
                ?>

                <tr>
                    <td><?=$emp_id;?></td>
                    <td><?=$emp_name;?></td>
                    <td><?=$type;?></td>
                    <td><?=$created_by;?></td>
                    <td><?=$created_date;?></td>
                </tr>

                <?php
                    }
                ?>
            </tbody>
        </table>
    </div>
</div><br><br>