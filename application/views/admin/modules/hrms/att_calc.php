<?php $this->load->helper("hrms"); ?>
<?php $db2 = $this->load->database('db2', TRUE); ?>
<html>
<head>
	<meta charset="utf-8">
	<title>Attendance Calculation</title>
</head>
<body>

<?php
$CurrDate = date("Y-m-d");

// First day of the month.
$month_first_date =  date('Y-m-01', strtotime($CurrDate));

// Last day of the month.
$month_last_date =  date('Y-m-t', strtotime($CurrDate));

//Deduct 10 Days From Current Date
$currentDate = new DateTime();
$yesterdayDT = $currentDate->sub(new DateInterval('P1D')); 
//Get yesterday's date in a YYYY-MM-DD format.
$MonthStartDate = $yesterdayDT->format('Y-m-d');

$CalStartDate = $MonthStartDate;
$CalEndDate = $CurrDate;

 $CalStartDate = '2026-02-01';
 //$CalEndDate = '2026-01-31';
 $month_first_date = '2026-02-01';
 //$month_last_date = '2026-01-31';

//Deleting Punch Date Range
/*
$this->db->query("delete from tran_attendence 
where CalDate between '".$CalStartDate."' and '".$CalEndDate."'");
*/

//Getting DR Employees
$sql_dr_emp = "select distinct `tabEmployee`.custom_card_no from `tabEmployee`
inner join `tabDaily Report` on `tabDaily Report`.employee = `tabEmployee`.name
where `tabDaily Report`.daily_report_type is not NULL
and `tabDaily Report`.posting_date between '".$month_first_date."' and '".$month_last_date."'
order by `tabEmployee`.custom_card_no";

$qry_dr_emp = $db2->query($sql_dr_emp);

$card_no_arr = array();

foreach($qry_dr_emp->result() as $row){
	$card_no = $row->custom_card_no;
	array_push($card_no_arr,$card_no);
}

$names = implode('\', \'', $card_no_arr);

$sql_get_cardno="SELECT distinct CardNo from tran_machinerawpunch 
where DATE(PunchDatetime) between '".$month_first_date."' and '".$month_last_date."' and CardNo in('00000102','00000669','00000177','00000567','00000072','00000063','00000082','00000144','00000144','00000365')
UNION
SELECT distinct CardNo from tran_machinerawpunch where  
CardNo in('.$names.') and CardNo in('00000102','00000669','00000177','00000567','00000072','00000063','00000082','00000144','00000144','00000365')
UNION
SELECT distinct emp_card_no as CardNo FROM `emp_rep_to_mst`
where emp_card_no in('.$names.')and emp_card_no in('00000102','00000669','00000177','00000567','00000072','00000063','00000082','00000144','00000144','00000365')
order by CardNo";

$qry_get_cardno = $this->db->query($sql_get_cardno);

foreach($qry_get_cardno->result() as $row){
	$CardNo = $row->CardNo;
	$dates = getDatesFromRange($CalStartDate, $CalEndDate);
	
	$sno=0;
	$tot_paid_days = 0;
	foreach($dates as $key => $value) { 
		$sno++; 
		$CalDate = $value;
		$Day = date('D', strtotime($CalDate));

		//Employee Id, Employee Name, Default Shift
		$sql_emp_det_cnt = "select count(*) as cnt_emp  from `tabEmployee` where custom_card_no = '".$CardNo."'";
		$qry_emp_det_cnt = $db2->query($sql_emp_det_cnt)->row();

		$cnt_emp = $qry_emp_det_cnt->cnt_emp;

		if($cnt_emp > 0){

			$sql_emp_det = "select name, employee_name, default_shift, custom__type_2, department, reports_to,
			custom__is_overtime_calculate, custom_type_1, custom__is_on_contract, date_of_joining, custom_date_of_contract_joining,
			salary_mode, custom_employee_type, branch
			from `tabEmployee` where custom_card_no = '".$CardNo."'";

			$qry_emp_det = $db2->query($sql_emp_det)->row();

			$emp_id = $qry_emp_det->name;
			$emp_name = $qry_emp_det->employee_name;
			$emp_shift = $qry_emp_det->default_shift;
			$is_labour = $qry_emp_det->custom__type_2;
			$department = $qry_emp_det->department;
			$reports_to = $qry_emp_det->reports_to;
			$is_overtime_calculate = $qry_emp_det->custom__is_overtime_calculate;
			$is_employee = $qry_emp_det->custom_type_1;
			$is_on_contract = $qry_emp_det->custom__is_on_contract;
			$date_of_joining = $qry_emp_det->date_of_joining;
			$date_of_contract_joining = $qry_emp_det->custom_date_of_contract_joining;
			$salary_mode = $qry_emp_det->salary_mode;
			$employee_type = $qry_emp_det->custom_employee_type;
			$branch = $qry_emp_det->branch;

		} else {
			echo "Employee Shift Not Found - ".$CardNo; die;
		}

		//Getting Shift As On Date
		$sql_aod_cnt = "select count(*) as count1 from `tabShift Assignment` 
		where employee = '".$emp_id."' and '".$CalDate."' between start_date and end_date and docstatus = 1";
		$qry_aod_cnt = $db2->query($sql_aod_cnt)->row();

		$count1 = $qry_aod_cnt->count1;
		
		if($count1 > 0){

			//Shift On Date
			$sql_aod = "select shift_type from `tabShift Assignment` 
			where employee = '".$emp_id."' and '".$CalDate."' between start_date and end_date  and docstatus = 1";
			$qry_aod = $db2->query($sql_aod)->row();

			$emp_shift_aod = $qry_aod->shift_type;

			//If Shift Not Available As On Date Then Shift As On Date = Default Shift
			if($emp_shift_aod == ""){
				$emp_shift_aod = $emp_shift;
			}

		} else {
			$emp_shift_aod = $emp_shift;	
		}

		//Shift Total Hours
		$sql_shift_th = "select name, start_time, end_time, 
		custom_total_hours as shift_tot_hrs, custom_shift_type from `tabShift Type`  
		where name = '".$emp_shift_aod."'";
		$qry_shift_th = $db2->query($sql_shift_th)->row();
		$shift_start_time = $qry_shift_th->start_time;
		$shift_start_datetime = $CalDate." ".$shift_start_time;
		$shift_type = $qry_shift_th->custom_shift_type;

		// Current date and time
		$datetime = date($shift_start_datetime);

		// Convert datetime to Unix timestamp
		$timestamp = strtotime($datetime);

		// Subtract time from datetime
		$time = $timestamp - (5 * 60 * 60);

		// Date and time after subtraction
		$shift_start_datetime = date("Y-m-d H:i:s", $time);

		 
		$shift_end_time = $qry_shift_th->end_time;
		$shift_end_datetime = $CalDate." ".$shift_end_time;

		if($shift_type == 'Night Shift'){
			$shift_end_datetime = date('Y-m-d H:i:s', strtotime($shift_end_datetime . ' +1 day'));
		}

		$shift_tot_hrs = abs($qry_shift_th->shift_tot_hrs);
		//$shift_tot_hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$shift_tot_hrs);

		//Half Day Full Day Calculation
		$half_day = ($shift_tot_hrs/2);
		$three_four_day = (($shift_tot_hrs*3)/4);
		$full_day = $shift_tot_hrs/1;

		//Half Shift
		$half_shift = $shift_tot_hrs/2;

		//InPunch Range
		$sql_ipr = "select DATE_ADD('".$shift_start_datetime."',interval ".($half_shift+5)." hour) as InPunchRange";
		$qry_ipr = $this->db->query($sql_ipr)->row();
		$InPunchRange = $qry_ipr->InPunchRange;

		$InPunchBetween = " '$shift_start_datetime' AND '$InPunchRange' ";

		//OutPunch Range
		$sql_opr = "select DATE_ADD('".$InPunchRange."',interval ".($half_shift+5)." hour) as OutPunchRange";
		$qry_opr = $this->db->query($sql_opr)->row();
		$OutPunchRange = $qry_opr->OutPunchRange;

		$OutPunchBetween = " '$InPunchRange' AND '$OutPunchRange' ";

		$ShiftTimeRange = " BETWEEN '$shift_start_datetime' AND '$shift_end_datetime' "; 

		//Getting In Punch
		$sql_get_intime_cnt = "SELECT count(*) as cnt_inpunch 
		FROM tran_machinerawpunch 
		WHERE CardNo = '".$CardNo."' 
		AND PunchDatetime BETWEEN  $InPunchBetween";

		$qry_get_intime_cnt = $this->db->query($sql_get_intime_cnt)->row();
		$cnt_inpunch = $qry_get_intime_cnt->cnt_inpunch;

		if($cnt_inpunch > 0){

			$sql_get_intime = "SELECT min(PunchDatetime) as InPunch 
			FROM tran_machinerawpunch 
			WHERE CardNo = '".$CardNo."' 
			AND PunchDatetime BETWEEN  $InPunchBetween";

			$qry_get_intime = $this->db->query($sql_get_intime)->row();

			$InPunch = $qry_get_intime->InPunch;

		} else {

			$InPunch = "0000-00-00 00:00:00";

		}

		//Getting OUT Punch
		$sql_get_outtime_cnt = "SELECT count(*) as cnt_outpunch 
		FROM tran_machinerawpunch 
		WHERE CardNo = '".$CardNo."'
		AND PunchDatetime BETWEEN  $OutPunchBetween";

		$qry_get_outtime_cnt = $this->db->query($sql_get_outtime_cnt)->row();
		$cnt_outpunch = $qry_get_outtime_cnt->cnt_outpunch;

		if($cnt_outpunch > 0){

			$sql_get_outtime = "SELECT max(PunchDatetime) as OutPunch 
			FROM tran_machinerawpunch 
			WHERE CardNo = '".$CardNo."'
			AND PunchDatetime BETWEEN  $OutPunchBetween";

			$qry_get_outtime = $this->db->query($sql_get_outtime)->row();

			$OutPunch = $qry_get_outtime->OutPunch;

		} else {

			$OutPunch = "0000-00-00 00:00:00";
			
		}

		if($shift_type != 'Night Shift'){
			if(($InPunch == "0000-00-00 00:00:00" || $InPunch == "") && ($OutPunch != "0000-00-00 00:00:00" && $OutPunch != "")){
				$sql_get_minpunch = "SELECT min(PunchDatetime) as InPunch 
				FROM tran_machinerawpunch 
				WHERE CardNo = '".$CardNo."'
				and date(PunchDatetime) = '".$CalDate."'
				and PunchDatetime < '".$OutPunch."'";

				$qry_get_minpunch = $this->db->query($sql_get_minpunch)->row();

				$InPunch = $qry_get_minpunch->InPunch;
			}
		}

		if($shift_type != 'Night Shift'){
			if(($OutPunch == "0000-00-00 00:00:00" || $OutPunch == "") && ($InPunch != "0000-00-00 00:00:00" && $InPunch != "")){
				$sql_get_maxpunch = "SELECT max(PunchDatetime) as OutPunch 
				FROM tran_machinerawpunch 
				WHERE CardNo = '".$CardNo."'
				and date(PunchDatetime) = '".$CalDate."'
				AND PunchDatetime > '".$InPunch."'";

				$qry_get_maxpunch = $this->db->query($sql_get_maxpunch)->row();

				$OutPunch = $qry_get_maxpunch->OutPunch;
			}
		}

		$miss_punch_id = "";

		//If One Punch Or both punch are not found
		if($InPunch == "" || $InPunch == "0000-00-00 00:00:00" || $OutPunch == "" || $OutPunch == "0000-00-00 00:00:00"){
			$tot_emp_hrs = 0;
		} else {
			$datetime1 = new DateTime($InPunch);
			$datetime2 = new DateTime($OutPunch);
			$interval = $datetime1->diff($datetime2);
			$tot_emp_hrs = $interval->format('%H:%I:%S');
			$tot_emp_hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$tot_emp_hrs);
		}

		//Gate Pass Checking
		$gp_id_arr = array();
		//Leave Calculations
		$leave_id_arr = array();
		
		//Holidays
		$sql_holiday_cnt = "select count(*) as cnt_holiday from `tabHoliday List` 
		inner join `tabHoliday` on `tabHoliday`.parent = `tabHoliday List`.name
		inner join `tabEmployee` on `tabEmployee`.holiday_list = `tabHoliday List`.name
		where `tabHoliday`.holiday_date = '".$CalDate."'
		and `tabEmployee`.name = '".$emp_id."'";

		$qry_holiday_cnt = $db2->query($sql_holiday_cnt)->row();
		$cnt_holiday = $qry_holiday_cnt->cnt_holiday;

		if($cnt_holiday > 0 && $CalDate >= $date_of_joining){
			$holidays = $shift_tot_hrs;
			$InPunch = "";
			$OutPunch = "";
		} else {
			$holidays = 0;
		}

		$tot_emp_hrs = $tot_emp_hrs+$holidays;

		//Paid Days Calculation
		if($tot_emp_hrs < $half_day-0.35){
			$paid_days = 0; 
			$tot_emp_hrs = 0;
		} else if($tot_emp_hrs >= $half_day-0.35 && $tot_emp_hrs < $three_four_day){
			$paid_days = 0.5;
		} else if($tot_emp_hrs >= $three_four_day && $tot_emp_hrs < $full_day){
			$paid_days = 0.75;
		} else if($tot_emp_hrs >= $full_day) {
			$paid_days = 1;
		} else {
			$paid_days = 0;
		}

		//LateComing
		$sql_lc = "SELECT TIMEDIFF(TIME('".$InPunch."') , '".$shift_start_time."') AS MinuteDiffLC";
		$qry_lc = $this->db->query($sql_lc)->row();
		$MinuteDiffLC = $qry_lc->MinuteDiffLC;
		$MinuteDiffLC = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$MinuteDiffLC);

		if($MinuteDiffLC > 0){
			$LateComing = $MinuteDiffLC;
		} else {
			$LateComing = "0";
		}

		//LateComing Greater Than One Hour Half Day Condition Applicable From 2021-04-01
		if($LateComing > 1 && $paid_days > 0.5){
			$paid_days = 0.5;
		}

		//Overtime
		$sql_ot = "SELECT TIMEDIFF(TIME('".$OutPunch."') , '".$shift_end_time."') AS MinuteDiffOT";
		$qry_ot = $this->db->query($sql_ot)->row();
		$MinuteDiffOT = $qry_ot->MinuteDiffOT;
		$MinuteDiffOT = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$MinuteDiffOT);

		if($MinuteDiffOT > 0){
			$a = number_format($MinuteDiffOT,2,".","");
			$b = explode(".",$a);
			$c = $b[0]+($b[1]/60);
		} else {
			$c = 0;
		}

		if($MinuteDiffOT > 0){
			$OverTime = number_format($c,2,".","");
		} else {
			$OverTime = "0";
		}

		//Early Entry
		$POverTime = "0";
		if($InPunch != '0000-00-00 00:00:00'){

			$sql_POT = "SELECT TIMEDIFF(TIME('".$shift_start_time."'), TIME('".$InPunch."')) AS MinuteDiffPOT";
			$qry_POT = $this->db->query($sql_POT)->row();
			$MinuteDiffPOT = $qry_POT->MinuteDiffPOT;
			$MinuteDiffPOT = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$MinuteDiffPOT);

			if($MinuteDiffPOT > 0){
				$a1 = number_format($MinuteDiffPOT,2,".","");
				$b1 = explode(".",$a1);
				$c1 = $b1[0]+($b1[1]/60);
			} else {
				$c1 = 0;
			}

			if($MinuteDiffPOT > 0){
				$POverTime = number_format($c1,2,".","");
			} else {
				$POverTime = "0";
			}

		}

		//Early Exit
		$sql_ee = "SELECT TIMEDIFF('".$shift_end_time."', TIME('".$OutPunch."')) AS MinuteDiffEE";
		$qry_ee = $this->db->query($sql_ee)->row();
		$MinuteDiffEE = $qry_ee->MinuteDiffEE;
		$MinuteDiffEE = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$MinuteDiffEE);

		if($MinuteDiffEE > 0){
			$EarlyExit = $MinuteDiffEE;
		} else {
			$EarlyExit = "0";
		}

		$sql_chk_prev = "select count(*) as cnt_prev from tran_attendence 
		where CardNo = '".$CardNo."' and CalDate = '".$CalDate."'";

		$qry_chk_prev = $this->db->query($sql_chk_prev)->row();
		
		$cnt_prev = $qry_chk_prev->cnt_prev;

		//Pay Hours
		if($tot_emp_hrs >=  $shift_tot_hrs){
			$Pay_Hrs = $shift_tot_hrs;
		} else {
			$Pay_Hrs = $tot_emp_hrs;
		}

		if($cnt_prev > 0){
			//Updating Records
			$this->db->query("update tran_attendence set 
			EmpId = '".$emp_id."', EmpName = '".$emp_name."',
			department = '".$department."', reports_to = '".$reports_to."',
			employee_type = '".$employee_type."', salary_mode = '".$salary_mode."',
			Day = '".$Day."', is_overtime_calculate = '".$is_overtime_calculate."',
			is_employee = '".$is_employee."', is_on_contract = '".$is_on_contract."',
			date_of_contract_joining = '".$date_of_contract_joining."', branch = '".$branch."',
			DefaultShift = '".$emp_shift."', ShiftOnAttDate = '".$emp_shift_aod."', ShiftOnAttDateType = '".$shift_type."',
			ShiftStartTime = '".$shift_start_time."', ShiftEndTime = '".$shift_end_time."',
			ShiftWorkingHrs = '".$shift_tot_hrs."', InDateTime = '".$InPunch."',
			OutDateTime = '".$OutPunch."', Tot_Hrs = '".$tot_emp_hrs."', Pay_Hrs = '".$Pay_Hrs."',
			PaidDay = '".$paid_days."', emp_mispunch = '".$miss_punch_id."',
			emp_gatepass = '".implode(",",$gp_id_arr)."', emp_leave = '".implode(",",$leave_id_arr)."',
			emp_holiday = '".$cnt_holiday."', LateComing = '".$LateComing."',
			OverTime = '".$OverTime."', EarlyExit = '".$EarlyExit."', PreOverTime = '".$POverTime."',
			emp_ot = '', emp_adjustment = '', emp_penalty = '', emp_dr = ''
			where CardNo = '".$CardNo."' and CalDate = '".$CalDate."'");
			
		} else {
			//Inserting Records
			$this->db->query("insert into tran_attendence
			(CardNo, EmpId, EmpName, department, 
			reports_to, employee_type, salary_mode,
			CalDate, Day, is_overtime_calculate, is_employee, is_on_contract,
			date_of_contract_joining, branch,
			DefaultShift, ShiftOnAttDate, ShiftOnAttDateType,
			ShiftStartTime, ShiftEndTime, ShiftWorkingHrs, 
			InDateTime, OutDateTime, Tot_Hrs, Pay_Hrs, PaidDay, 
			emp_mispunch, emp_gatepass, emp_leave, 
			emp_holiday, LateComing, OverTime, EarlyExit, PreOverTime) 
			values
			('".$CardNo."', '".$emp_id."', '".$emp_name."', '".$department."', 
			'".$reports_to."', '".$employee_type."', '".$salary_mode."', 
			'".$CalDate."', '".$Day."', '".$is_overtime_calculate."', '".$is_employee."', '".$is_on_contract."', 
			'".$date_of_contract_joining."', '".$branch."',
			'".$emp_shift."', '".$emp_shift_aod."', '".$shift_type."',
			'".$shift_start_time."', '".$shift_end_time."', '".$shift_tot_hrs."', 
			'".$InPunch."', '".$OutPunch."', '".$tot_emp_hrs."', '".$Pay_Hrs."', '".$paid_days."', 
			'".$miss_punch_id."', '".implode(",",$gp_id_arr)."', '".implode(",",$leave_id_arr)."',
			'".$cnt_holiday."', '".$LateComing."', '".$OverTime."', '".$EarlyExit."', '".$POverTime."')");
		}

	}

}

//Deleting Duplicate Records
/*
$this->db->query("
delete t1 from tran_attendence t1 
inner join tran_attendence t2 
where t1.sno > t2.sno
and t1.CalDate = t2.CalDate
and t1.CardNo = t2.CardNo
");*/

/*********Leaves/GatePass/Mispunch*********** */
include('leave_gp_mp.php');
/*********Leaves/GatePass/Mispunch*********** */

echo "Attendence Calculated Successfully Of Date - ".$CalStartDate." And ".$CalEndDate;
?>
</body>
</html>