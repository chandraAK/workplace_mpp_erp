<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>

<?php
$card_no = $_REQUEST['card_no'];
?>

<?php
    $sql_emp_type = "select card_no, name, employee_name, department, is_labour, employee_type, salary_mode, is_on_contract 
    from `tabEmployee` where card_no = '".$card_no."' limit 1";

    $qry_emp_type = $db2->query($sql_emp_type)->row();

    $card_no = $qry_emp_type->card_no;
    $name = $qry_emp_type->name;
    $employee_name = $qry_emp_type->employee_name;
    $department = $qry_emp_type->department;
    $is_labour = $qry_emp_type->is_labour;
    $employee_type = $qry_emp_type->employee_type;
    $salary_mode = $qry_emp_type->salary_mode;
    $is_on_contract = $qry_emp_type->is_on_contract;
?>

<div class="row">
    <div class="col-lg-12">
        <h3>Employee Details</h3>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-3">
        <b>Card No.</b><br><?=$card_no;?>
    </div>
    <div class="col-lg-3">
        <b>Employee ID</b><br><?=$name;?>
    </div>
    <div class="col-lg-3">
        <b>Name</b><br><?=$employee_name;?>
    </div>
    <div class="col-lg-3">
        <b>Department</b><br><?=$department;?>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-3">
        <b>Type</b><br><?php if($is_labour == 0){ echo "Type-1"; } else { echo "Type-2"; }?>
    </div>
    <div class="col-lg-3">
        <b>Employee Type</b><br><?=$employee_type;?>
    </div>
    <div class="col-lg-3">
        <b>Salary Type</b><br><?=$salary_mode;?>
    </div>
    <div class="col-lg-3">
        <b>Contract Employee</b><br><?php if($is_on_contract == 0){ echo "No"; } else { echo "Yes"; }?>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-12">
        <h3>Payment Details</h3>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Outstanding</th>
                    <th>Paid</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=$outstanding_amt = TotPayment($name,"NetSalary","All");?></td>
                    <td><?=$paid_amt = TotPayment($name,"PF_Amt","Paid")+TotPayment($name,"esi_amt","Paid")+TotPayment($name,"tot_advance_amount","Paid")+TotPayment($name,"tot_spcl_advance_amount","Paid")+TotPayment($name,"tot_loan_amount","Paid")+TotPayment($name,"net_paybl_sal","Paid");?></td>
                    <td><?=number_format($outstanding_amt-$paid_amt,2,".","");?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-12">
        <h3>Leave Details</h3>
    </div>
</div><br>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Allocated</th>
                    <th>Availed</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                            $sql = "select sum(`tabLeave Allocation`.new_leaves_allocated) as tot_leaves_alloted from `tabLeave Allocation`
                            where `tabLeave Allocation`.employee = '".$name."'
                            and from_date in(select max(from_date) 
                            from `tabLeave Allocation` where employee = '".$name."' and year(from_date) = '".date("Y")."')";
            
                            $qry = $db2->query($sql)->row();

                            $tot_leaves_alloted = $qry->new_leaves_allocated;

                            echo number_format($tot_leaves_alloted,2,".","");
                        ?>
                    </td>
                    <td>
                        <?php
                            $sql_avail_lv = "select sum(leave_days) as tot_leaves_availed from leave_mst 
                            where leave_emp_id = '".$name."'
                            and leave_type in('Casual_Leave','Sick_Leave')
                            and year(leave_from_date) = '".date("Y")."'
                            and year(leave_to_date) = '".date("Y")."'
                            and leave_status = 'Approved'";

                            $qry_avail_lv = $this->db->query($sql_avail_lv)->row();

                            $tot_leaves_availed = $qry_avail_lv->tot_leaves_availed;

                            echo number_format($tot_leaves_availed,2,".","");
                        ?>
                    </td>
                    <td><?=number_format($tot_leaves_alloted-$tot_leaves_availed,2,".","");?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><br>