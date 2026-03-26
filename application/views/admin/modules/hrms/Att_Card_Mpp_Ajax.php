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

<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-2">
        <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel" class="form-control">
    </div>
    <div class="col-lg-1"></div>
</div><br>

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
                    <th><b>Default Shift</b></th>
                    <th><b>Shift On Att Date</b></th>
                    <th><b>Shift Start Time</b></th>
                    <th><b>Shift End Time</b></th>
                    <th><b>Shift Working Hours</b></th>
                    <th><b>In Time</b></th>
                    <th><b>Out Time</b></th>
                    <th><b>Employee Working Hours</b></th>
                    <th><b>Paid Day</b></th>
                    <th><b>Leaves / GatePass / Mispunch</b></th>
                    <th><b>Late Coming</b></th>
                    <th><b>Early Exit</b></th>
                    <th><b>Overtime</b></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $dates = getDatesFromRange($start_dt, $end_dt);
                    
                    $sno=0;
                    $tot_paid_days = 0;
                    $tot_all_hrs = 0;
                    $tot_lc = 0;
                    $tot_ee = 0;
                    $tot_ot = 0;
                    foreach ($dates as $key => $value) { 
                        $sno++; 
                        $AttDate = $value; 
						
						$sql_get_att = "select * from mpp_tran_attendence 
                        where CardNo = '".$card_no."' and CalDate = '".$AttDate."'";
                        $qry_get_att = $this->db->query($sql_get_att)->row();
						
						$CardNo = $qry_get_att->CardNo;
						$EmpId = $qry_get_att->EmpId;
						$EmpName = $qry_get_att->EmpName;
						$CalDate = $qry_get_att->CalDate;
						$Day = $qry_get_att->Day;
						$DefaultShift = $qry_get_att->DefaultShift;
                        $ShiftOnAttDate = $qry_get_att->ShiftOnAttDate;
                        $Tot_Hrs = $qry_get_att->Tot_Hrs;
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
                        $LateComing = $qry_get_att->LateComing;
                        $EarlyExit = $qry_get_att->EarlyExit;
						$OverTime = $qry_get_att->OverTime;
						
						//Calculating Total Paid Days
						$tot_paid_days = $tot_paid_days+$PaidDay; 
                        $tot_all_hrs = $tot_all_hrs+$Tot_Hrs;     
						$tot_lc = $tot_lc+$LateComing;       
						$tot_ee = $tot_ee+$EarlyExit;       
                        $tot_ot = $tot_ot+$OverTime;     
                        
                        if($emp_holiday > 0 && ($InDateTime == '0000-00-00 00:00:00' || $OutDateTime == '0000-00-00 00:00:00')){
                            $color = "#66ccff";
                        } else {
                            $color = "none";
                        }

                ?>
                <tr style="background-color:<?=$color;?>">
                    <td><?=$sno;?></td>
                    <td><?=$CardNo;?></td>
                    <td><?=$EmpId;?></td>
                    <td><?=$EmpName;?></td>
                    <td><?=$CalDate;?></td>
                    <td><?=$Day;?></td>
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
					<td><?=$PaidDay;?></td>
					<td><?=$emp_leave."<br/>".$emp_gatepass."<br/>".$emp_mispunch;?></td>
					<td style="color:red"><?=$LateComing;?></td>
					<td style="color:red"><?=$EarlyExit;?></td>
					<td><?=$OverTime;?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="13" style="text-align:right;font-weight:bold">Total Paid Days</td>
                    <td style="text-align:right;font-weight:bold"><?=$tot_all_hrs;?></td>
                    <td style="text-align:right;font-weight:bold"><?=$tot_paid_days;?></td>
                    <td></td>
                    <td style="text-align:right;font-weight:bold;color:red"><?=$tot_lc;?></td>
                    <td style="text-align:right;font-weight:bold;color:red"><?=$tot_ee;?></td>
                    <td style="text-align:right;font-weight:bold"><?=$tot_ot;?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>