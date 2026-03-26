<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;
?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="example1" style="margin-top:60px">
            <thead>
                <tr>
                    <th><b>Card No</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Salary Mode</b></th>
                    <th><b>WeekOFFAlloted</b></th>
                    <th><b>DutyHours</b></th>
                    <th><b>Monthly Salary</b></th>
                    <th><b>Per Day Salary</b></th>
                    <th><b>PayDays</b></th>
                    <th><b>Penalties</b></th>
                    <th><b>Net Salary</b></th>
                    <th><b>Salary Advance</b></th>
                    <th><b>Loan</b></th>
                    <th><b>Payable Salary</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $end_dt1 = strtotime($end_dt);
                    $start_dt1 = strtotime($start_dt);

                    $datediff = $end_dt1 - $start_dt1;
                    $datediff1 = round($datediff / (60 * 60 * 24));
                    $datediff1 = $datediff1+1;

                    $sql_emp = "select distinct CardNo, EmpId, EmpName from mpp_tran_attendence 
                    where CalDate between '".$start_dt."' and '".$end_dt."'";

                    $qry_emp = $this->db->query($sql_emp);

                    foreach($qry_emp->result() as $row){
                        $CardNo = $row->CardNo;
                        $EmpId = $row->EmpId;
                        $EmpName = $row->EmpName;
                        
                        $sql_sel = "select * from mpp_emp_mst where SalaryType = 'Monthly' and CardNo = '".$CardNo."'";
                        $qry_sel = $this->db->query($sql_sel)->row();

                        $Salary = $qry_sel->Salary;
                        $PerDaySal = $Salary/$datediff1;
                        $SalaryType = $qry_sel->SalaryType;
                        $DutyHours = $qry_sel->DutyHours;
                        $PayMode = $qry_sel->PayMode;
                        $WeekOFFAlloted = $qry_sel->WeekOFFAlloted;
                        $DutyHours = $qry_sel->DutyHours;

                        $sql_tot_hrs = "SELECT sum(PaidDay) as PaidDay FROM `mpp_tran_attendence` 
                        where CardNo = '".$CardNo."' and CalDate between '".$start_dt."' and '".$end_dt."'";

                        $qry_tot_hrs = $this->db->query($sql_tot_hrs)->row();

                        $PaidDay = $qry_tot_hrs->PaidDay;

                        if($SalaryType == 'Monthly'){
                            $NetSalary = $PaidDay*$PerDaySal;
                            $NetSalary = number_format($NetSalary,2,".","");

                ?>
                <tr>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$PayMode;?></td>
                    <td><?=$WeekOFFAlloted;?></td>
                    <td><?=$DutyHours;?></td>
                    <td><?=$Salary;?></td>
                    <td><?=number_format($PerDaySal,2,".","");?></td>
                    <td><?=$PaidDay;?></td>
                    <td></td>
                    <td><?=$NetSalary;?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>