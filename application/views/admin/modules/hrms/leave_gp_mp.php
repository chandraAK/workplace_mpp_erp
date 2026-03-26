<?php
//Min Date
$sql_mindate = "select min(CalDate) as minDate from tran_attendence";
$qry_mindate = $this->db->query($sql_mindate)->row();
$minDate = $qry_mindate->minDate;

//Max Date
$sql_maxdate = "select max(CalDate) as maxDate from tran_attendence";
$qry_maxdate = $this->db->query($sql_maxdate)->row();
$maxDate = $qry_maxdate->maxDate;

$minDate = '2026-02-01';
//$month_first_date =  '2026-01-01';
//$month_last_date =  '2026-01-31';

//Special Querries
$this->db->query("UPDATE tran_attendence SET InDateTime = NULL WHERE CAST(InDateTime AS CHAR(20)) = '0000-00-00 00:00:00'");
$this->db->query("UPDATE tran_attendence SET OutDateTime = NULL WHERE CAST(OutDateTime AS CHAR(20)) = '0000-00-00 00:00:00'");

$this->db->query("UPDATE tran_attendence SET InDateTime = NULL WHERE CAST(date(InDateTime) AS CHAR(20)) = '0000-00-00'");
$this->db->query("UPDATE tran_attendence SET OutDateTime = NULL WHERE CAST(date(OutDateTime) AS CHAR(20)) = '0000-00-00'");

//Policy Adjustment 5 Minutes Starts 
//Type 1
$this->db->query("
update `tran_attendence`
set InDateTime = concat(date(InDateTime), ' ', ShiftStartTime),
pol_adj_cnt = 1
WHERE Tot_Hrs != 0 
and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= 10 
and CalDate >= '".$minDate."'
and is_employee = 1
");

//Type 2
$this->db->query("
update `tran_attendence`
set InDateTime = concat(date(InDateTime), ' ', ShiftStartTime),
pol_adj_cnt = 1
WHERE Tot_Hrs != 0 
and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= 10
and CalDate >= '".$minDate."'
and is_employee = 0
");

//Modified Query If over time exists then don't run policy adjustment
/*$sql_pol_adj = "select * from `tran_attendence` where pol_adj_cnt = 1 and CalDate >= '".$minDate."' 
and leaves = 0 and (InDateTime is NOT NULL AND OutDateTime is not NULL) 
and (emp_ot is NULL OR emp_ot = '')";*/

$sql_pol_adj = "select * from `tran_attendence` where pol_adj_cnt = 1 and pol_adj = 0 and CalDate >= '".$minDate."' 
and leaves = 0 and (InDateTime is NOT NULL AND OutDateTime is not NULL)
and (emp_ot is NULL OR emp_ot = '')";
$qry_pol_adj = $this->db->query($sql_pol_adj);

foreach($qry_pol_adj->result() as $row){
    $EmpId = $row->EmpId;
    $CalDate = $row->CalDate;
    $InDateTime = $row->InDateTime;
    $OutDateTime = $row->OutDateTime;
    $ShiftWorkingHrs = $row->ShiftWorkingHrs;

    // $datetime1 = new DateTime($InDateTime);
    // $datetime2 = new DateTime($OutDateTime);
    // $interval = $datetime1->diff($datetime2);
    // $Tot_Hrs = $interval->format('%H:%I:%S');
    // $Tot_Hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$Tot_Hrs);
    $datetime1 = new DateTime($InDateTime);
    $datetime2 = new DateTime($OutDateTime);
    $interval = $datetime1->diff($datetime2);
    
    // Calculate total hours worked as a decimal
    $hours = $interval->h + ($interval->days * 24);
    $minutes = $interval->i;
    $Tot_Hrs = $hours + ($minutes / 60);

    $half_day = ($ShiftWorkingHrs/2)-0.5;
    $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
    $full_day = $ShiftWorkingHrs/1;

    //Paid Days Calculation
    if($Tot_Hrs < $half_day){
        $paid_days = 0; 
    } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
        $paid_days = 0.5;
    } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
        $paid_days = 0.75;
    } else if($Tot_Hrs >= $full_day) {
        $paid_days = 1;
    } else {
        $paid_days = 0;
    }

    $this->db->query("update tran_attendence 
    set Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."', pol_adj = 1
    where pol_adj_cnt = 1 
    and EmpId = '".$EmpId."' 
    and CalDate = '".$CalDate."'
    and (emp_dr is NULL OR emp_dr = '' OR emp_adjustment is NULL)
    and (InDateTime is NOT NULL AND OutDateTime is not NULL)");
}

//TYPE 1 POLICY ADJUSTMENT
/*
$this->db->query("update `tran_attendence`
set InDateTime = concat(date(InDateTime), ' ', ShiftStartTime),
pol_adj = 1 
WHERE Tot_Hrs != 0 
and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= 
(
    select max(relax_time) from reg_relax 
    where relax_app_date <= tran_attendence.CalDate 
    and relax_emp_type = 0
)
and CalDate >=
(
    select max(relax_app_date) from reg_relax 
    where relax_app_date <= tran_attendence.CalDate 
    and relax_emp_type = 0
)
and is_employee = 0
and CalDate >= '".$minDate."'
");

//TYPE 2 POLICY ADJUSTMENT
$this->db->query("update `tran_attendence`
set InDateTime = concat(date(InDateTime), ' ', ShiftStartTime),
pol_adj = 1 
WHERE Tot_Hrs != 0 
and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= 
(
    select max(relax_time) from reg_relax 
    where relax_app_date <= tran_attendence.CalDate 
    and relax_emp_type = 1
)
and CalDate >=
(
    select max(relax_app_date) from reg_relax 
    where relax_app_date <= tran_attendence.CalDate 
    and relax_emp_type = 1
)
and is_employee = 1
and CalDate >= '".$minDate."'
");*/
//Policy Adjustment 5 Minutes Ends

//Occassional Relaxation

//Type 2
$sql_occ_rel = "select relax_app_date, relax_time, relax_notm from occ_relax where relax_app_date = (
    select max(relax_app_date) from occ_relax
) and relax_emp_type = 0";

$qry_occ_rel = $this->db->query($sql_occ_rel)->row();

$relax_app_date = $qry_occ_rel->relax_app_date;
$relax_time = $qry_occ_rel->relax_time;
$relax_notm = $qry_occ_rel->relax_notm;
$month_first_date =  date('Y-m-01', strtotime($relax_app_date));
$month_last_date =  date('Y-m-t', strtotime($relax_app_date));

$this->db->query("
    update `tran_attendence`
    set occ_rel_cnt = 1
    WHERE Tot_Hrs != 0 
    and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
    and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
    and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= '".$relax_time."' 
    and CalDate between '".$month_first_date."' and '".$month_last_date."'
    and is_employee = 0
    and occ_rel_cnt = 0
    and pol_adj = 0
    and CalDate >= '".$minDate."'
    and (InDateTime is NOT NULL AND OutDateTime is not NULL)
");

$sql_get_occ_emp = "select distinct(EmpId) as occ_emp from `tran_attendence` 
where CalDate between '".$month_first_date."' and '".$month_last_date."'
and is_employee = 0
and occ_rel_cnt = 1
and CalDate >= '".$minDate."'";

$qry_get_occ_emp = $this->db->query($sql_get_occ_emp);

foreach($qry_get_occ_emp->result() as $row){
    $occ_emp = $row->occ_emp;
    $occ_rel_sum = 0;
    
    //Getting Top 2 Id Occasional Count of that month employee wise
    $sql_top2_id = "select sno from tran_attendence 
    where occ_rel_cnt = 1 
    and CalDate between '".$month_first_date."' and '".$month_last_date."'
    and is_employee = 0
    and EmpId = '".$occ_emp."'
    limit $relax_notm";

    $qry_top2_id = $this->db->query($sql_top2_id);

    foreach($qry_top2_id->result() as $row){
        $sno = $row->sno;

        $this->db->query(
            "update `tran_attendence`
            set InDateTime = concat(date(InDateTime), ' ', ShiftStartTime),
            occ_rel_adj = 1
            WHERE Tot_Hrs != 0 
            and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
            and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
            and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= '".$relax_time."'
            and CalDate between '".$month_first_date."' and '".$month_last_date."'
            and is_employee = 0
            and occ_rel_cnt = 1
            and EmpId = '".$occ_emp."'
            and pol_adj = 0
            and sno = '".$sno."'
            and (InDateTime is NOT NULL AND OutDateTime is not NULL)");

        //Updating Time
        $sql_updt_time = "select * from `tran_attendence` where occ_rel_adj = 1 
        and CalDate between '".$month_first_date."' and '".$month_last_date."'
        and is_employee = 0 and sno = '".$sno."'";

        $qry_updt_time = $this->db->query($sql_updt_time);

        foreach($qry_updt_time->result() as $row){
            $EmpId = $row->EmpId;
            $CalDate = $row->CalDate;
            $InDateTime = $row->InDateTime;
            $OutDateTime = $row->OutDateTime;
            $ShiftWorkingHrs = $row->ShiftWorkingHrs;

            $datetime1 = new DateTime($InDateTime);
            $datetime2 = new DateTime($OutDateTime);
            $interval = $datetime1->diff($datetime2);
            $Tot_Hrs = $interval->format('%H:%I:%S');
            $Tot_Hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$Tot_Hrs);

            $half_day = ($ShiftWorkingHrs/2)-0.5;
            $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
            $full_day = $ShiftWorkingHrs/1;

            //Paid Days Calculation
            if($Tot_Hrs < $half_day){
                $paid_days = 0; 
            } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
                $paid_days = 0.5;
            } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
                $paid_days = 0.75;
            } else if($Tot_Hrs >= $full_day) {
                $paid_days = 1;
            } else {
                $paid_days = 0;
            }

            $this->db->query("update tran_attendence 
            set Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
            where occ_rel_adj = 1 
            and EmpId = '".$EmpId."' 
            and CalDate = '".$CalDate."'
            and (emp_dr is NULL OR emp_dr = '' OR emp_adjustment is NULL)
            and (InDateTime is NOT NULL AND OutDateTime is not NULL)
            and sno = '".$sno."'
            ");
        }
    }
}

//Type 1
$sql_occ_rel = "select relax_app_date, relax_time, relax_notm from occ_relax where relax_app_date = (
    select max(relax_app_date) from occ_relax
) and relax_emp_type = 1";

$qry_occ_rel = $this->db->query($sql_occ_rel)->row();

$relax_app_date = $qry_occ_rel->relax_app_date;
$relax_time = $qry_occ_rel->relax_time;
$relax_notm = $qry_occ_rel->relax_notm;
$month_first_date =  date('Y-m-01', strtotime($relax_app_date));
$month_last_date =  date('Y-m-t', strtotime($relax_app_date));

$this->db->query("
    update `tran_attendence`
    set occ_rel_cnt = 1
    WHERE Tot_Hrs != 0 
    and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
    and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
    and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= '".$relax_time."' 
    and CalDate between '".$month_first_date."' and '".$month_last_date."'
    and is_employee = 1
    and occ_rel_cnt = 0
    and pol_adj = 0
    and CalDate >= '".$minDate."'
    and (InDateTime is NOT NULL AND OutDateTime is not NULL)
    
");

$sql_get_occ_emp = "select distinct(EmpId) as occ_emp from `tran_attendence` 
where CalDate between '".$month_first_date."' and '".$month_last_date."'
and is_employee = 1
and occ_rel_cnt = 1
and CalDate >= '".$minDate."'";

$qry_get_occ_emp = $this->db->query($sql_get_occ_emp);

foreach($qry_get_occ_emp->result() as $row){
    $occ_emp = $row->occ_emp;
    $occ_rel_sum = 0;
    
    //Getting Top 2 Id Occasional Count of that month employee wise
    $sql_top2_id = "select sno from tran_attendence 
    where occ_rel_cnt = 1 
    and CalDate between '".$month_first_date."' and '".$month_last_date."'
    and is_employee = 1
    and EmpId = '".$occ_emp."'
    limit $relax_notm";

    $qry_top2_id = $this->db->query($sql_top2_id);

    foreach($qry_top2_id->result() as $row){
        $sno = $row->sno;
        
        $this->db->query(
            "update `tran_attendence`
            set InDateTime = concat(date(InDateTime), ' ', ShiftStartTime),
            occ_rel_adj = 1
            WHERE Tot_Hrs != 0 
            and InDateTime > concat(date(InDateTime), ' ', ShiftStartTime)
            and HOUR(time(InDateTime)) = HOUR(ShiftStartTime)
            and MINUTE(TIMEDIFF(time(InDateTime), ShiftStartTime)) <= '".$relax_time."'
            and CalDate between '".$month_first_date."' and '".$month_last_date."'
            and is_employee = 1
            and occ_rel_cnt = 1
            and EmpId = '".$occ_emp."'
            and pol_adj = 0
            and sno = '".$sno."'
            and (InDateTime is NOT NULL AND OutDateTime is not NULL)
        ");

        //Updating Time
        $sql_updt_time = "select * from `tran_attendence` where occ_rel_adj = 1 
        and CalDate between '".$month_first_date."' and '".$month_last_date."'
        and is_employee = 1 and sno = '".$sno."'";

        $qry_updt_time = $this->db->query($sql_updt_time);

        foreach($qry_updt_time->result() as $row){
            $EmpId = $row->EmpId;
            $CalDate = $row->CalDate;
            $InDateTime = $row->InDateTime;
            $OutDateTime = $row->OutDateTime;
            $ShiftWorkingHrs = $row->ShiftWorkingHrs;

            $datetime1 = new DateTime($InDateTime);
            $datetime2 = new DateTime($OutDateTime);
            $interval = $datetime1->diff($datetime2);
            $Tot_Hrs = $interval->format('%H:%I:%S');
            $Tot_Hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$Tot_Hrs);

            $half_day = ($ShiftWorkingHrs/2)-0.5;
            $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
            $full_day = $ShiftWorkingHrs/1;

            //Paid Days Calculation
            if($Tot_Hrs < $half_day){
                $paid_days = 0; 
            } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
                $paid_days = 0.5;
            } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
                $paid_days = 0.75;
            } else if($Tot_Hrs >= $full_day) {
                $paid_days = 1;
            } else {
                $paid_days = 0;
            }

            $this->db->query("update tran_attendence 
            set Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
            where occ_rel_adj = 1 
            and EmpId = '".$EmpId."' 
            and CalDate = '".$CalDate."'
            and (emp_dr is NULL OR emp_dr = '' OR emp_adjustment is NULL)
            and (InDateTime is NOT NULL AND OutDateTime is not NULL)
            ");
        }
    }
}

//Occassional Relaxation Ends

$dates = getDatesFromRange($minDate, $maxDate);
foreach($dates as $key => $value) { 
    $sno++; 
    $CalDate = $value; 

    //Workplace Leaves Overtime Mispunch DR Adjustment Settlement
    //Half Days Leave Workplace
    $sql_hd = "select leave_id, leave_from_date, leave_to_date, leave_days, leave_emp_id from `leave_mst` 
    where leave_status = 'Approved'
    and leave_type in('Casual_Leave','Sick_Leave')
    and half_day_date = '".$CalDate."'
    and is_halfday = 1
    and '".$CalDate."' between leave_from_date and leave_to_date";

    $qry_hd = $this->db->query($sql_hd);

    foreach($qry_hd->result() as $row){
        $name = $row->leave_id;
        $from_date = $row->leave_from_date;
        $to_date = $row->leave_to_date;
        $total_leave_days = $row->leave_days;
        $employee = $row->leave_emp_id;

        $sql_get_att = "select emp_leave, Tot_Hrs, ShiftWorkingHrs from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_leave = $qry_get_att->emp_leave;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        if($emp_leave == "" || $emp_leave == NULL){
            $half_day = ($ShiftWorkingHrs/2);
		    $three_four_day = (($ShiftWorkingHrs*3)/4);
            $full_day = $ShiftWorkingHrs/1;

            $Tot_Hrs = $Tot_Hrs+$half_day+0.5;
            
            //Paid Days Calculation
            if($Tot_Hrs < $half_day){
                $paid_days = 0; 
            } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
                $paid_days = 0.5;
            } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
                $paid_days = 0.75;
            } else if($Tot_Hrs >= $full_day) {
                $paid_days = 1;
            } else {
                $paid_days = 0;
            }

            $this->db->query("update tran_attendence 
            set emp_leave = '".$name."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', leaves = '1', PaidDay = '".$paid_days."'
            where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
        }
    }

    //Full Days Leave Workplace 
    $sql_hd = "select leave_id, leave_from_date, leave_to_date, leave_days, leave_emp_id from `leave_mst` 
    where leave_status = 'Approved'
    and leave_type in('Casual_Leave','Sick_Leave')
    and leave_days >= 0.5
    and '".$CalDate."' between leave_from_date and leave_to_date";

    $qry_hd = $this->db->query($sql_hd);

    foreach($qry_hd->result() as $row){
        $name = $row->leave_id;
        $from_date = $row->leave_from_date;
        $to_date = $row->leave_to_date;
        $total_leave_days = $row->leave_days;
        $employee = $row->leave_emp_id;

        $sql_get_att = "select emp_leave, Tot_Hrs, ShiftWorkingHrs from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_leave = $qry_get_att->emp_leave;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        if($emp_leave == "" || $emp_leave == NULL){
            $half_day = ($ShiftWorkingHrs/2)-0.5;
		    $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
            $full_day = $ShiftWorkingHrs/1;

            $Tot_Hrs = $ShiftWorkingHrs;
            
            //Paid Days Calculation
            if($Tot_Hrs < $half_day){
                $paid_days = 0; 
            } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
                $paid_days = 0.5;
            } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
                $paid_days = 0.75;
            } else if($Tot_Hrs >= $full_day) {
                $paid_days = 1;
            } else {
                $paid_days = 0;
            }

            $this->db->query("update tran_attendence 
            set emp_leave = '".$name."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', leaves = '1', PaidDay = '".$paid_days."'
            where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
        }
    }

    //Misspunch Workplace
    $sql_app_mp = "select miss_pun_id, mp_emp_id, miss_pun_date, miss_pun_time, miss_pun_type 
    from miss_punch
    where mp_status = 'Approved'
    and miss_pun_date = '".$CalDate."'";

    $qry_app_mp = $this->db->query($sql_app_mp);

    foreach($qry_app_mp->result() as $row){
        $name = $row->miss_pun_id;
        $employee = $row->mp_emp_id;
        $punch_type = $row->miss_pun_type;
        $miss_punch_date = $row->miss_pun_date;
        $exit_time = $row->miss_pun_time;
        //Mispunch Date time
        $miss_punch_datetime = $miss_punch_date." ".$exit_time;

        $sql_get_att = "select emp_mispunch, Tot_Hrs, ShiftWorkingHrs, InDateTime, OutDateTime from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_mispunch = $qry_get_att->emp_mispunch;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;
        $InDateTime = $qry_get_att->InDateTime;
        $OutDateTime = $qry_get_att->OutDateTime;

        if($punch_type == 'in'){
            $InDateTime = $miss_punch_datetime;
        } else if($punch_type == 'out'){
            $OutDateTime = $miss_punch_datetime;
        }

        $datetime1 = new DateTime($InDateTime);
        $datetime2 = new DateTime($OutDateTime);
        $interval = $datetime1->diff($datetime2);
        $Tot_Hrs = $interval->format('%H:%I:%S');
        $Tot_Hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$Tot_Hrs);

        $half_day = ($ShiftWorkingHrs/2)-0.5;
		$three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
        $full_day = $ShiftWorkingHrs/1;
        
        //Paid Days Calculation
        if($Tot_Hrs < $half_day){
            $paid_days = 0; 
        } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
            $paid_days = 0.5;
        } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
            $paid_days = 0.75;
        } else if($Tot_Hrs >= $full_day) {
            $paid_days = 1;
        } else {
            $paid_days = 0;
        }

        if($emp_mispunch == "" || $emp_mispunch == NULL){

            if($punch_type == 'in'){
                $this->db->query("update tran_attendence 
                set emp_mispunch = '".$name."', InDateTime = '".$miss_punch_datetime."', 
                Tot_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
                where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
            }

            if($punch_type == 'out'){
                $this->db->query("update tran_attendence 
                set emp_mispunch = '".$name."', OutDateTime = '".$miss_punch_datetime."', 
                Tot_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
                where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
            }            
        }
    }

    //Penalties Workplace
    $sql_adj = "select penalty_id, penalty_emp_id, penalty_hours, penalty_date 
    from `penalty` 
    where penalty_status = 'Approved' 
    and penalty_date = '".$CalDate."'";

    $qry_adj = $this->db->query($sql_adj);

    foreach($qry_adj->result() as $row){
        $penalty_id = $row->penalty_id;
        $penalty_emp_id = $row->penalty_emp_id;
        $penalty_hours = $row->penalty_hours;
        $penalty_date = $row->penalty_date;

        $sql_get_att = "select emp_penalty, ShiftWorkingHrs, Tot_Hrs, Pay_Hrs 
        from tran_attendence 
        where EmpId = '".$penalty_emp_id."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_penalty = $qry_get_att->emp_penalty;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $Pay_Hrs = $qry_get_att->Pay_Hrs;

        if($penalty_hours > 0){
            $Tot_Hrs = $Tot_Hrs-$penalty_hours;
            $Pay_Hrs = $Pay_Hrs-$penalty_hours;
        }

        
        $half_day = ($ShiftWorkingHrs/2)-0.5;
		$three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
        $full_day = $ShiftWorkingHrs/1;
        
        //Paid Days Calculation
        if($Tot_Hrs < $half_day){
            $paid_days = 0; 
        } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
            $paid_days = 0.5;
        } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
            $paid_days = 0.75;
        } else if($Tot_Hrs >= $full_day) {
            $paid_days = 1;
        } else {
            $paid_days = 0;
        }

        if($emp_penalty == "" || $emp_penalty == NULL){
            $this->db->query("update tran_attendence 
            set emp_penalty = '".$penalty_id."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Pay_Hrs."', 
            PaidDay = '".$paid_days."'
            where EmpId = '".$penalty_emp_id."' and CalDate = '".$CalDate."'");            
        }  
    }

    //Adjustment Workplace
    $sql_adj = "select adjustments_id, adjustments_emp_id, adjustments_hours, adjustments_date, adjustments_type 
    from `adjustments` 
    where adjustments_status = 'Approved' 
    and adjustments_date = '".$CalDate."'";

    $qry_adj = $this->db->query($sql_adj);

    foreach($qry_adj->result() as $row){
        $adjustments_id = $row->adjustments_id;
        $adjustments_emp_id = $row->adjustments_emp_id;
        $adjustments_hours = $row->adjustments_hours;
        $adjustments_date = $row->adjustments_date;
        $adjustments_type = $row->adjustments_type;

        if($adjustments_hours > 0){
			$a = number_format($adjustments_hours,2,".","");
			$b = explode(".",$a);
			$c = $b[0]+($b[1]/60);
		} else {
			$c = 0;
		}

        $sql_get_att = "select emp_adjustment, InDateTime, OutDateTime, ShiftWorkingHrs 
        from tran_attendence 
        where EmpId = '".$adjustments_emp_id."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_adjustment = $qry_get_att->emp_adjustment;
        $InDateTime = $qry_get_att->InDateTime;
        $OutDateTime = $qry_get_att->OutDateTime;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        if($adjustments_type == "In"){
            $InDateTime = date('Y-m-d H:i:s', strtotime($InDateTime) - 60 * 60 * $c);
        } else {
            $OutDateTime = date('Y-m-d H:i:s', strtotime($OutDateTime) + 60 * 60 * $c);
        }

        $datetime1 = new DateTime($InDateTime);
        $datetime2 = new DateTime($OutDateTime);
        $interval = $datetime1->diff($datetime2);
        $Tot_Hrs = $interval->format('%H:%I:%S');
        $Tot_Hrs = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$Tot_Hrs);

        $half_day = ($ShiftWorkingHrs/2)-0.5;
		$three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
        $full_day = $ShiftWorkingHrs/1;
        
        //Paid Days Calculation
        if($Tot_Hrs < $half_day){
            $paid_days = 0; 
        } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
            $paid_days = 0.5;
        } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
            $paid_days = 0.75;
        } else if($Tot_Hrs >= $full_day) {
            $paid_days = 1;
        } else {
            $paid_days = 0;
        }

        if($emp_adjustment == "" || $emp_adjustment == NULL){
            $this->db->query("update tran_attendence 
            set emp_adjustment = '".$adjustments_id."', InDateTime = '".$InDateTime."', 
            OutDateTime = '".$OutDateTime."', Tot_Hrs = '".$Tot_Hrs."', 
            PaidDay = '".$paid_days."'
            where EmpId = '".$adjustments_emp_id."' and CalDate = '".$CalDate."'");            
        }  
    }
    
    //Work From Home DR ERP 
    $sql_ot = "select name, employee, posting_date from `tabDaily Report` 
    where workflow_state = 'Approved' 
    and daily_report_type = 'Work From Home'
    and date = '".$CalDate."'";

    $qry_ot = $db2->query($sql_ot);

    foreach($qry_ot->result() as $row){
        $name = $row->name;
        $dr_date = $row->posting_date;
        $employee = $row->employee;

        $sql_get_att = "select emp_dr, Tot_Hrs, ShiftWorkingHrs from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_dr = $qry_get_att->emp_dr;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        $half_day = ($ShiftWorkingHrs/2)-0.5;
        $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
        $full_day = $ShiftWorkingHrs/1;

        $Tot_Hrs = $half_day;
                    
        //Paid Days Calculation
        if($Tot_Hrs < $half_day){
            $paid_days = 0; 
        } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
            $paid_days = 0.5;
        } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
            $paid_days = 0.75;
        } else if($Tot_Hrs >= $full_day) {
            $paid_days = 1;
        } else {
            $paid_days = 0;
        }

        if($emp_dr == "" || $emp_dr == NULL){
            $this->db->query("update tran_attendence 
            set emp_dr = '".$name."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
            where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
        }
    }

    //Tour / Tranee / OnDuty DR ERP --- Fullday
    $sql_ot_tour = "select * from `tabDaily Report` 
    where daily_report_type in('Tour Daily Report','Trainee','On Duty')
    and workflow_state = 'Approved'
    and attendance_type = 'Full Day'
    and date = '".$CalDate."'";

    $qry_ot_tour = $db2->query($sql_ot_tour);

    foreach($qry_ot_tour->result() as $row){
        $name = $row->name;
        $dr_date = $row->posting_date;
        $employee = $row->employee;

        $sql_get_att = "select emp_dr, Tot_Hrs, ShiftWorkingHrs from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_dr = $qry_get_att->emp_dr;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        $half_day = ($ShiftWorkingHrs/2)-0.5;
        $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
        $full_day = $ShiftWorkingHrs/1;

        $Tot_Hrs = $full_day;
                    
        //Paid Days Calculation
        if($Tot_Hrs < $half_day){
            $paid_days = 0; 
        } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
            $paid_days = 0.5;
        } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
            $paid_days = 0.75;
        } else if($Tot_Hrs >= $full_day) {
            $paid_days = 1;
        } else {
            $paid_days = 0;
        }

        if($emp_dr == "" || $emp_dr == NULL){
            $this->db->query("update tran_attendence 
            set emp_dr = '".$name."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
            where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
        }
    }

    //Tour / Tranee / OnDuty DR ERP -- Half Day
    $sql_ot_tour = "select * from `tabDaily Report` 
    where daily_report_type in('Tour Daily Report','Trainee','On Duty')
    and workflow_state = 'Approved'
    and attendance_type = 'Half Day'
    and date = '".$CalDate."'";

    $qry_ot_tour = $db2->query($sql_ot_tour);

    foreach($qry_ot_tour->result() as $row){
        $name = $row->name;
        $dr_date = $row->posting_date;
        $employee = $row->employee;

        $sql_get_att = "select emp_dr, Tot_Hrs, ShiftWorkingHrs from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_dr = $qry_get_att->emp_dr;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        $half_day = ($ShiftWorkingHrs/2)-0.5;
        $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
        $full_day = $ShiftWorkingHrs/1;

        $Tot_Hrs = $Tot_Hrs+($ShiftWorkingHrs/2);
                    
        //Paid Days Calculation
        if($Tot_Hrs < $half_day){
            $paid_days = 0; 
        } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
            $paid_days = 0.5;
        } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
            $paid_days = 0.75;
        } else if($Tot_Hrs >= $full_day) {
            $paid_days = 1;
        } else {
            $paid_days = 0;
        }

        if($emp_dr == "" || $emp_dr == NULL){
            $this->db->query("update tran_attendence 
            set emp_dr = '".$name."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', PaidDay = '".$paid_days."'
            where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
        }
    }

    //Overtime Workplace 
    $sql_ot = "select over_tim_id, ot_frm_date, ot_frm_time, ot_to_date, ot_to_time, ot_tot_hrs, ot_emp_id 
    from `over_time` 
    where ot_status = 'Approved' 
    and ot_frm_date = '".$CalDate."'";

    $qry_ot = $this->db->query($sql_ot);

    foreach($qry_ot->result() as $row){
        $name = $row->over_tim_id;
        $from_date = $row->ot_frm_date;
        $from_time = $row->ot_frm_time;
        $to_date = $row->ot_to_date;
        $to_time = $row->ot_to_time;
        $ot_tot_hrs = $row->ot_tot_hrs;
        $employee = $row->ot_emp_id;

        $sql_get_att = "select emp_ot, Tot_Hrs, ShiftWorkingHrs from tran_attendence 
        where EmpId = '".$employee."' and CalDate = '".$CalDate."'";

        $qry_get_att = $this->db->query($sql_get_att)->row();

        $emp_ot = $qry_get_att->emp_ot;
        $Tot_Hrs = $qry_get_att->Tot_Hrs;
        $ShiftWorkingHrs = $qry_get_att->ShiftWorkingHrs;

        if($emp_ot == "" || $emp_ot == NULL){
            $Tot_Hrs = $Tot_Hrs+$ot_tot_hrs;

            $half_day = ($ShiftWorkingHrs/2)-0.5;
		    $three_four_day = (($ShiftWorkingHrs*3)/4)-0.5;
            $full_day = $ShiftWorkingHrs/1;
            
            //Paid Days Calculation
            if($Tot_Hrs < $half_day){
                $paid_days = 0; 
            } else if($Tot_Hrs >= $half_day && $Tot_Hrs < $three_four_day){
                $paid_days = 0.5;
            } else if($Tot_Hrs >= $three_four_day && $Tot_Hrs < $full_day){
                $paid_days = 0.75;
            } else if($Tot_Hrs >= $full_day) {
                $paid_days = 1;
            } else {
                $paid_days = 0;
            }

            $this->db->query("update tran_attendence 
            set emp_ot = '".$name."', Tot_Hrs = '".$Tot_Hrs."', Pay_Hrs = '".$Tot_Hrs."', 
            ot = '1', PaidDay = '".$paid_days."'
            where EmpId = '".$employee."' and CalDate = '".$CalDate."'");
        }
    }
}


//SandWich Rule Starts
$sql_sw = "SELECT distinct CardNo, CalDate FROM tran_attendence 
WHERE CalDate between '".$minDate."' and '".$maxDate."' 
and emp_holiday != 0 ORDER BY CardNo";

$qry_sw = $this->db->query($sql_sw);

foreach($qry_sw->result() as $row){
	$CardNo = $row->CardNo;
	$CalDate = $row->CalDate; //2021-01-03
	$prev_date = date('Y-m-d', strtotime($CalDate .' -1 day')); //2021-01-02
	$next_date = date('Y-m-d', strtotime($CalDate .' +1 day')); //2021-01-04

	$sql_sw_prev = "SELECT Tot_Hrs FROM tran_attendence	WHERE CardNo = '".$CardNo."' and CalDate = '".$prev_date."'";
	$qry_sw_prev = $this->db->query($sql_sw_prev)->row();
	$prev_day_hrs = $qry_sw_prev->Tot_Hrs;

	$sql_sw_nexthoday = "SELECT emp_holiday FROM tran_attendence 
	WHERE CardNo = '".$CardNo."' and CalDate = '".$next_date."'";

	$qry_sw_nexthoday = $this->db->query($sql_sw_nexthoday)->row();

	$emp_holiday = $qry_sw_nexthoday->emp_holiday;

	if($emp_holiday != 0){
		for($i=2;$i<10;$i++){
			$next_date = date('Y-m-d', strtotime($CalDate .' +'.$i.' day'));

			$sql_sw_nexthoday1 = "SELECT emp_holiday FROM tran_attendence 
			WHERE CardNo = '".$CardNo."' and CalDate = '".$next_date."'";

			$qry_sw_nexthoday1 = $this->db->query($sql_sw_nexthoday1)->row();

			$emp_holiday1 = $qry_sw_nexthoday1->emp_holiday;

			if($emp_holiday1 != 0){
			} else {
				break;
			}
		}
	}

	$sql_sw_next = "SELECT Tot_Hrs FROM tran_attendence	
	WHERE CardNo = '".$CardNo."'
	and CalDate  = '".$next_date."'";

	$qry_sw_next = $this->db->query($sql_sw_next)->row();
	$next_day_hrs = $qry_sw_next->Tot_Hrs;

	if($prev_day_hrs == 0 && $next_day_hrs == 0){

		$this->db->query("update tran_attendence set Tot_hrs = 0, Pay_hrs = 0, PaidDay = 0 
		where CardNo = '".$CardNo."' 
		and CalDate > '".$prev_date."'
		and CalDate < '".$next_date."'");
        
        /*
        $this->db->query("update tran_attendence set Tot_hrs = 0, Pay_hrs = 0, PaidDay = 0 
		where CardNo = '".$CardNo."' 
		and CalDate > '".$prev_date."'
		and CalDate < '".$next_date."' 
        and is_employee = 0
        and is_on_contract = 1");
        */

	} else {

        $this->db->query("update tran_attendence set Tot_hrs = ShiftWorkingHrs, Pay_hrs = ShiftWorkingHrs, PaidDay = 1 
		where CardNo = '".$CardNo."' 
		and CalDate > '".$prev_date."'
		and CalDate < '".$next_date."'");

    }
}

//SandWich Rule Ends

//Present
$this->db->query("update tran_attendence 
set att_type = 'Present' 
where (YEAR(InDateTime) != 0 AND YEAR(OutDateTime) = 0) 
OR (YEAR(InDateTime) = 0 AND YEAR(OutDateTime) != 0) 
OR (YEAR(InDateTime) != 0 OR YEAR(OutDateTime) != 0)
AND present = 0
AND CalDate >= '".$minDate."'");

//Holiday
$this->db->query("update tran_attendence 
set att_type = 'Holiday' 
where emp_holiday = 1
AND YEAR(InDateTime) = 0 
AND YEAR(OutDateTime) = 0
AND CalDate >= '".$minDate."'
");

//Mispunch
$this->db->query("update tran_attendence 
set att_type = 'Mispunch' 
where (YEAR(InDateTime) = 0  AND YEAR(OutDateTime) != 0)
AND (YEAR(InDateTime) != 0  AND YEAR(OutDateTime) = 0)
AND CalDate >= '".$minDate."'");

//Late Coming
$this->db->query("update tran_attendence 
set att_type = 'Late Coming' 
where TIME(InDateTime) > shiftStartTime
AND YEAR(InDateTime) != 0
AND CalDate >= '".$minDate."'");

//Early Exit
$this->db->query("update tran_attendence 
set att_type = 'Early Exit' 
where shiftEndTime > TIME(OutDateTime)
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

//Leave
$this->db->query("update tran_attendence 
set att_type = 'On Leave' 
where emp_leave != ''
AND YEAR(InDateTime) = 0 
AND YEAR(OutDateTime) = 0
AND CalDate >= '".$minDate."'");

//Emergency Leave
$this->db->query("update tran_attendence 
set att_type = 'Emergency Leave' 
where YEAR(InDateTime) = 0 
AND YEAR(OutDateTime) = 0 
AND emp_leave = ''
AND emp_holiday = 0
AND CalDate >= '".$minDate."'");

//Half Day
$this->db->query("update tran_attendence 
set att_type = 'Half Day' 
where PaidDay >= '0.50' 
AND PaidDay < '1'
AND YEAR(InDateTime) != 0 
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

///Update Attendence Columns
//Present
$this->db->query("update tran_attendence 
set present = 1 
where (YEAR(InDateTime) != 0 AND YEAR(OutDateTime) = 0) 
OR (YEAR(InDateTime) = 0 AND YEAR(OutDateTime) != 0) 
OR (YEAR(InDateTime) != 0 OR YEAR(OutDateTime) != 0)
AND present = 0
AND CalDate >= '".$minDate."'");

//Leave
$this->db->query("update tran_attendence 
set leaves = 1 
where emp_leave != ''
AND YEAR(InDateTime) = 0 
AND YEAR(OutDateTime) = 0
AND CalDate >= '".$minDate."'");

//Emergency Leave
$this->db->query("update tran_attendence 
set emergency_leave = 1 
where YEAR(InDateTime) = 0 
AND YEAR(OutDateTime) = 0 
AND emp_leave = ''
AND emp_holiday = 0
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence 
set emergency_leave = 0 
where YEAR(InDateTime) != 0 
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

//Mispunch
$this->db->query("update tran_attendence set mispunch = 1
where YEAR(InDateTime) = 0  
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence set mispunch = 1
where YEAR(InDateTime) != 0  
AND YEAR(OutDateTime) = 0
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence set mispunch = 0
where YEAR(InDateTime) != 0  
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

//Late Coming
$this->db->query("update tran_attendence 
set late_entry = 1 
where TIME(InDateTime) > shiftStartTime
AND YEAR(InDateTime) != 0
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence 
set late_entry = 0 
where TIME(InDateTime) <= shiftStartTime
AND YEAR(InDateTime) != 0
AND CalDate >= '".$minDate."'");

//Early Exit
$this->db->query("update tran_attendence 
set early_exit = 1 
where shiftEndTime > TIME(OutDateTime)
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence 
set early_exit = 0 
where shiftEndTime <= TIME(OutDateTime)
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

//Half Day
$this->db->query("update tran_attendence 
set half_day = 1 
where PaidDay >= '0.50' 
AND PaidDay < '1'
AND YEAR(InDateTime) != 0 
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

//Holiday Early Exit Time 
$this->db->query("update tran_attendence 
set EarlyExit = 0 
where emp_holiday = 1
AND EarlyExit > 0
AND CalDate >= '".$minDate."'");

//Holiday Late Entry Time 
$this->db->query("update tran_attendence 
set LateComing = 0 
where emp_holiday = 1
AND LateComing > 0
AND CalDate >= '".$minDate."'");

//Holiday OverTime 
$this->db->query("update tran_attendence 
set OverTime = 0 
where emp_holiday != 0
AND OverTime > 0
AND CalDate >= '".$minDate."'");

//Early Exit Update when OutPunch > Shift End Time
$this->db->query("update `tran_attendence` 
set EarlyExit = 0 
where time(OutDateTime) > ShiftEndTime
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

//Overtime Update when OutPunch < Shift End Time
$this->db->query("update `tran_attendence` 
set OverTime = 0 
where time(OutDateTime) < ShiftEndTime 
AND YEAR(OutDateTime) != 0
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence 
set EarlyExit = 0, OverTime = 0, LateComing = 0
where YEAR(InDateTime) = 0 
AND YEAR(OutDateTime) = 0
AND CalDate >= '".$minDate."'");

//Updating Pay Hours
$this->db->query("update tran_attendence 
set Pay_Hrs = ShiftWorkingHrs
where Tot_Hrs >= ShiftWorkingHrs
AND ot != 1
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence 
set Pay_Hrs = Tot_Hrs
where Tot_Hrs < ShiftWorkingHrs
AND ot != 1
AND CalDate >= '".$minDate."'");

$this->db->query("update tran_attendence 
set Pay_Hrs = Tot_Hrs
where Tot_Hrs >= ShiftWorkingHrs
AND ot = 1
AND is_employee = 0
AND CalDate >= '".$minDate."'");
?>