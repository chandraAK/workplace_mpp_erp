<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_year = $_REQUEST['att_year'];
    $from_date = $att_year."-01-01";
    $to_date = $att_year."-12-31";
?>

<table class="table table-bordered" id="example1"  style="margin-top:60px">
    <thead>
        <tr>
            <th><b>SNO</b></th>
            <th><b>Employee ID</b></th>
            <th><b>Employee Name</b></th>
            <th><b>Department</b></th>
            <th><b>Casual Leave Allocated</b></th>
            <th><b>Sick Leave Allocated</b></th>
            <th><b>Total Leaves Allocated</b></th>
            <th><b>Casual Leave Availed</b></th>
            <th><b>Sick Leave Availed</b></th>
            <th><b>Total Leaves Availed</b></th>
            <th><b>Casual Leaves Balance</b></th>
            <th><b>Sick Leaves Balance</b></th>
            <th><b>Total Leaves Balance</b></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql_emp = "select distinct employee, employee_name, department from `tabLeave Allocation` 
            where from_date between '".$from_date."' and '".$to_date."'
            and to_date between '".$from_date."' and '".$to_date."'
            and employee not like 'EMP-MPP%'
            order by employee";
            $qry_emp = $db2->query($sql_emp);

            $sno = 0;
            foreach($qry_emp->result() as $row){
                $sno++;
                $employee = $row->employee;
                $employee_name = $row->employee_name;
                $department = $row->department;
        ?>
        <tr>
            <td><?=$sno;?></td>
            <td><?=$employee;?></td>
            <td><?=$employee_name;?></td>
            <td><?=$department;?></td>
            <td><?php echo $cl_alloc = number_format(lv_allocated($employee, "Casual_Leave", $from_date, $to_date),2,".",""); ?></td>
            <td><?php echo $sl_alloc = number_format(lv_allocated($employee, "Sick_Leave", $from_date, $to_date),2,".",""); ?></td>
            <td><?php echo $tot_alloc = number_format($cl_alloc+$sl_alloc,2,".",""); ?></td>
            <td><?php echo $cl_avail = number_format(lv_availed($employee, "Casual_Leave", $from_date, $to_date),2,".",""); ?></td>
            <td><?php echo $sl_avail = number_format(lv_availed($employee, "Sick_Leave", $from_date, $to_date),2,".",""); ?></td>
            <td><?php echo $tot_avail = number_format($cl_avail+$sl_avail,2,".",""); ?></td>
            <td><?php echo $cl_bal = number_format($cl_alloc-$cl_avail,2,".",""); ?></td>
            <td><?php echo $sl_bal = number_format($sl_alloc-$sl_avail,2,".",""); ?></td>
            <td><?php echo $tot_bal = number_format($tot_alloc-$tot_avail,2,".",""); ?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>