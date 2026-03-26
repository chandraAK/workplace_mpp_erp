<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php 
    $username = $_SESSION['username'];
    $sql_user_det = "select role from login where username = '".$username."'";
    $qry_user_det = $this->db->query($sql_user_det)->row();
    $role = $qry_user_det->role;
?>

<?php
    $emp_id = $_REQUEST['emp_id'];
    $from_dt = date("Y-m")."-01";
    $to_dt = date("Y-m")."-20";

    //$from_dt = "2021-07-01";
    //$to_dt = "2021-07-20";
    
    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$from_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;

    $end_dt1 = strtotime($end_dt);
    $start_dt1 = strtotime($from_dt);

    $datediff = $end_dt1 - $start_dt1;
    $datediff1 = round($datediff / (60 * 60 * 24));
    $datediff1 = $datediff1+1;

    $sql_emp_det = "select card_no, is_labour from `tabEmployee` where name = '".$emp_id."'  and status = 'Active'";
    $qry_emp_det = $db2->query($sql_emp_det)->row();
    $CardNo = $qry_emp_det->card_no;
    $is_labour = $qry_emp_det->is_labour;
?>
<?php 
    
    $query_alert="select count(*) as cnt from salary_adv_pb 
    where year(created_date) ='". date('Y')."'and month(created_date) = '".date('m')."' and emp_id='".$emp_id."'";

    $sql_alert=$this->db->query($query_alert)->row();
    $count=$sql_alert->cnt; 
 ?>

<table class="table table-bordered" width="100%">
    <thead>
        <tr style="font-weight:bold">
            <td>Total Production Amount</td>
            <td>Total Advance Amount</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php
                //Production Salary
                $sql_prod_sal = "select sum(paying_amount) as prod_sal from `tabPacking`
                inner join `tabPacking Table` on `tabPacking Table`.parent = `tabPacking`.name 
                where `tabPacking`.date between '".$from_dt."' and '".$to_dt."'
                and `tabPacking Table`.employee = '".$emp_id."'
                and `tabPacking Table`.docstatus = 1";

                $qry_prod_sal = $db2->query($sql_prod_sal)->row();

                $prod_sal = $qry_prod_sal->prod_sal;

                $NetSalary = $prod_sal;

                echo number_format($NetSalary,2,".","");

                $tot_adv_amt = $NetSalary*0.6;
                ?>
            </td>
            <td>
            <?=number_format($tot_adv_amt,2,".","");?>
            <input type="hidden" id="sys_cal_advamt" name="sys_cal_advamt" value="<?php if($count > 0){ echo 0; } else { echo $tot_adv_amt; } ?>" readonly>
            </td>
        </tr>
    </tbody>
</table>
<?php
if($count > 0){
    echo '<input type="hidden" id="sys_cal_advamt" name="sys_cal_advamt" value="0" readonly>';
    echo "<h2 style='color:red'>Advance already applied for this month.</h2>"; die;
}
?>