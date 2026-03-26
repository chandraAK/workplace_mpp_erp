<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<?php
    $att_month = $_REQUEST['att_month'];
    $att_year = $_REQUEST['att_year'];
    $card_no = $_REQUEST['card_no'];
    //Month Start Date
    $start_dt = $att_year."-".$att_month."-01";

    //End Date
    $sql_end_dt = "SELECT LAST_DAY('".$start_dt."') as end_dt";
    $qry_end_dt = $this->db->query($sql_end_dt)->row();
    $end_dt = $qry_end_dt->end_dt;
?>
<!--
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-2">
        <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" class="form-control">
    </div>
    <div class="col-lg-1"></div>
</div><br>
-->

<?php
    $sql_emp_type = "select custom__type_2 from `tabEmployee` where custom_card_no = '".$card_no."' limit 1";
    $qry_emp_type = $db2->query($sql_emp_type)->row();
    $emp_type = $qry_emp_type->custom__type_2;
?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="testTable">
            <thead>
                <tr>
                    <th><b>S.No.</b></th>
                    <th><b>Card No</b></th>
                    <th><b>Employee ID</b></th>
                    <th><b>Employee Name</b></th>
                    <th><b>Date</b></th>
                    <th><b>Day</b></th>
                    <th><b>OT App</b></th>
                    <th><b>Emp Type</b></th>
                    <th><b>Default Shift</b></th>
                    <th><b>Shift On Att Date</b></th>
                    <th><b>Shift Start Time</b></th>
                    <th><b>Shift End Time</b></th>
                    <th><b>Shift Working Hours</b></th>
                    <th><b>In Time</b></th>
                    <th><b>Out Time</b></th>
                    <th><b>Employee Working Hours</b></th>
                    <th><b>Pay Hours</b></th>
                    <?php if($emp_type == 0){ ?>
                        <th><b>Pay Day</b></th>
                    <?php } ?>
                    <th><b>Penalty Late Coming</b></th>
                    <th><b>Leaves / GatePass / Mispunch / OnDuty / DR / Adjustment / Penalty</b></th>
                    <th><b>Late Coming</b></th>
                    <th><b>Early Exit</b></th>
                    <th><b>Pre Extra Hours</b></th>
                    <th><b>Post Extra Hours</b></th>
                    <th><b>Adjustment</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $dates = getDatesFromRange($start_dt, $end_dt);
                    
                    $sno=0;
                    $tot_paid_days = 0;
                    $tot_all_hrs = 0;
                    $tot_pay_hrs = 0;
                    $tot_lc = 0;
                    $tot_ee = 0;
                    $tot_ot = 0;
                    $pre_tot_ot = 0;
                    $Tot_Penalty = 0;
                    foreach ($dates as $key => $value) { 
                        $sno++; 
                        $AttDate = $value; 
						
						$sql_get_att = "select * from tran_attendence where CardNo = '".$card_no."' 
                        and CalDate = '".$AttDate."'";

                        $qry_get_att = $this->db->query($sql_get_att)->row();
						
						$CardNo = $qry_get_att->CardNo;
						$EmpId = $qry_get_att->EmpId;
						$EmpName = $qry_get_att->EmpName;
						$CalDate = $qry_get_att->CalDate;
						$Day = $qry_get_att->Day;
						$is_overtime_calculate = $qry_get_att->is_overtime_calculate;
						$is_employee = $qry_get_att->is_employee;
						$DefaultShift = $qry_get_att->DefaultShift;
                        $ShiftOnAttDate = $qry_get_att->ShiftOnAttDate;
                        $Tot_Hrs = $qry_get_att->Tot_Hrs;
                        $Pay_Hrs = $qry_get_att->Pay_Hrs;
						$ShiftStartTime = $qry_get_att->ShiftStartTime;                        
                        $ShiftEndTime = $qry_get_att->ShiftEndTime;                        
						$ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;
						$InDateTime = $qry_get_att->InDateTime;
						$OutDateTime = $qry_get_att->OutDateTime;
						$PaidDay = $qry_get_att->PaidDay;
						$emp_leave = $qry_get_att->emp_leave;
						$emp_gatepass = $qry_get_att->emp_gatepass;
						$emp_mispunch = $qry_get_att->emp_mispunch;
						$emp_holiday = $qry_get_att->emp_holiday;
						$emp_ot = $qry_get_att->emp_ot;
						$emp_ot = $qry_get_att->emp_ot;
						$emp_adjustment = $qry_get_att->emp_adjustment;
						$emp_penalty = $qry_get_att->emp_penalty;
						$emp_dr = $qry_get_att->emp_dr;
                        $LateComing = $qry_get_att->LateComing;
                        $EarlyExit = $qry_get_att->EarlyExit;
						$PreOverTime = $qry_get_att->PreOverTime;
						$OverTime = $qry_get_att->OverTime;
						$pol_adj = $qry_get_att->pol_adj;
						$occ_rel_adj = $qry_get_att->occ_rel_adj;
						
						//Calculating Total Paid Days
						$tot_paid_days = $tot_paid_days+$PaidDay; 
                        $tot_all_hrs = $tot_all_hrs+$Tot_Hrs; 
                        $tot_pay_hrs = $tot_pay_hrs+$Pay_Hrs;    
						$tot_lc = $tot_lc+$LateComing;       
						$tot_ee = $tot_ee+$EarlyExit;       
                        $pre_tot_ot = $pre_tot_ot+$PreOverTime;     
                        $tot_ot = $tot_ot+$OverTime;     
                        
                        if($emp_holiday > 0){
                            $color = "#66ccff";
                        } else {
                            $color = "none";
                        }

                        //Overtime Applicable Or Not
                        /*
                        $sql_ot = "select is_overtime_calculate from `tabEmployee` where name = '".$EmpId."'";
                        $qry_ot = $db2->query($sql_ot)->row();
                        $is_overtime_calculate = $qry_ot->is_overtime_calculate
                        */

                ?>
                <tr style="background-color:<?=$color;?>">
                    <td><?=$sno;?></td>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$CalDate;?></td>
                    <td><?=$Day;?></td>
                    <td>
                    <?php
                        if($is_overtime_calculate == 1 && $EmpId != ""){
                            echo "Yes";
                        }
                        
                        if($is_overtime_calculate == 0 && $EmpId != "") {
                            echo "No";
                        }
                    ?>
                    </td>
                    <td>
                    <?php
                        if($is_employee == 1 && $EmpId != ""){
                            echo "TYPE-1";
                        }
                        
                        if($is_employee == 0 && $EmpId != "") {
                            echo "TYPE-2";
                        }
                    ?>
                    </td>
                    <td><?=$DefaultShift;?></td>
                    <td><?=$ShiftOnAttDate;?></td>
                    <td><?=$ShiftStartTime;?></td>
                    <td><?=$ShiftEndTime;?></td>
                    <td><?=$ShiftWorkingHrs;?></td>
                    <td>
                        <?php 
                            if($InDateTime == '0000-00-00 00:00:00' && $emp_holiday == 0){
                                echo '<i class="fa fa-ban" style="color:red; font-size:18px"></i>';
                            } else if($InDateTime == '0000-00-00 00:00:00' && $emp_holiday == 1){
                                echo '<b style="font-weight:bold">Holiday</b>';
                            } else {
                                echo $InDateTime;
                            }
                        ?>
                    </td>
                    <td>
                        <?php 
                            if($OutDateTime == '0000-00-00 00:00:00' && $emp_holiday == 0){
                                echo '<i class="fa fa-ban" style="color:red; font-size:18px"></i>';
                            } else if($OutDateTime == '0000-00-00 00:00:00' && $emp_holiday == 1){
                                echo '<b style="font-weight:bold">Holiday</b>';
                            } else {
                                echo $OutDateTime;
                            }
                        ?>
                    </td>
                    <td><?=$Tot_Hrs;?></td>
                    <td>
                    <?php
                        /* 
                        if($is_overtime_calculate == 0 && $Tot_Hrs >= $ShiftWorkingHrs){
                            echo $ShiftWorkingHrs;
                        } else { 
                            echo $Tot_Hrs;
                        }*/

                        echo $Pay_Hrs;
                    ?>
                    </td>
                    <?php if($emp_type == 0){ ?>
					    <td><?=$PaidDay;?></td>
                    <?php } ?>
					<td><?php echo $Penalty = Penalty($CardNo, $CalDate);?></td>
					<td><?=$emp_leave."<br/>".$emp_gatepass."<br/>".$emp_mispunch."<br/>".$emp_ot."<br/>".$emp_dr."<br/>".$emp_adjustment."<br/>".$emp_penalty;?></td>
					<td style="color:red"><?=$LateComing;?></td>
					<td style="color:red"><?=$EarlyExit;?></td>
					<td><?=$PreOverTime;?></td>
					<td><?=$OverTime;?></td>
					<td style="color:red;font-weight:bold;">
					    <?php
					    if($pol_adj > 0){
					        echo "Regular Adjustment";
					    } else if($occ_rel_adj > 0){
					        echo "Occassional Adjustment";
					    }
					    ?>
					</td>
                </tr>
                <?php
                    $Tot_Penalty = $Tot_Penalty+$Penalty; 
                } 
                ?>
                <tr style="background-color:#66ccff">
                    <td colspan="15" style="text-align:right;font-weight:bold">
                        <?php
                            if($emp_type == 0){
                                echo "Total Working Days";
                            } else {
                                echo "Total Working Hours";
                            }
                        ?>
                    </td>
                    <td style="text-align:right;font-weight:bold"><?=$tot_all_hrs;?></td>
                    <td style="text-align:right;font-weight:bold"><?=$tot_pay_hrs;?></td>
                    <?php if($emp_type == 0){ ?>
                        <td style="text-align:right;font-weight:bold"><?=$tot_paid_days;?></td>
                    <?php } ?>
                    <td style="text-align:right;font-weight:bold"><?=$Tot_Penalty;?></td>
                    <td></td>
                    <td style="text-align:right;font-weight:bold;color:red"><?=$tot_lc;?></td>
                    <td style="text-align:right;font-weight:bold;color:red"><?=$tot_ee;?></td>
                    <td style="text-align:right;font-weight:bold"><?=$pre_tot_ot;?></td>
                    <td style="text-align:right;font-weight:bold"><?=$tot_ot;?></td>
                    <td style="text-align:right;font-weight:bold"></td>
                </tr>
                <tr style="background-color:#66ccff">
                    <td colspan="17" style="text-align:right;font-weight:bold">
                        <?php
                            if($emp_type == 0){
                                echo "Total Pay Days";
                            } else {
                                echo "Total Pay Hours";
                            }
                        ?>
                    </td>
                    <?php if($emp_type == 0){ ?>
                        <td style="text-align:right;font-weight:bold"><?php echo $tot_paid_days-$Tot_Penalty; ?></td>
                    <?php } ?>
                    <td style="text-align:right;font-weight:bold">
                    <?php 
                    if($emp_type == 1){
                        echo $tot_pay_hrs-$Tot_Penalty;
                    }
                    ?>
                    </td>
                    <td></td>
                    <td style="text-align:right;font-weight:bold;color:red"></td>
                    <td style="text-align:right;font-weight:bold;color:red"></td>
                    <td style="text-align:right;font-weight:bold"></td>
                    <td style="text-align:right;font-weight:bold"></td>
                    <td style="text-align:right;font-weight:bold"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>