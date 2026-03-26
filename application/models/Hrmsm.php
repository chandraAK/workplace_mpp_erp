<?php
class Hrmsm extends CI_Model{ 

	function __construct(){   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
        $query = $this->db->query("SHOW columns FROM $tbl_nm where Field not in('password','admin_pass')");

        return $query;
    }

	//id's Columns
	public function get_by_id($tbl_nm, $id_col, $id)
	{
		$query = $this->db->query("select * from $tbl_nm where $id_col = '".$id."'");
		return $query;
	}

	//Get Employee ID 
	public function GetEmpId($username){
		$query = $this->db->query("select emp_id, role from login where username = '".$username."'");
		return $query;
	}

	
	public function InPunchListCnt($from_dt){
		$query = $this->db->query("
		SELECT count(*) as cnt_ip FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND YEAR(InDateTime) = 0
		AND YEAR(OutDateTime) != 0
		ORDER BY CardNo");

		return $query;
	}

	public function InPunchList($from_dt){
		$query = $this->db->query("SELECT * FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND YEAR(InDateTime) = 0
		AND YEAR(OutDateTime) != 0
		ORDER BY CardNo");

		return $query;
	}

	public function OutPunchListCnt($from_dt){
		$query = $this->db->query("
		SELECT count(*) as cnt_op FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND YEAR(OutDateTime) = 0 
		AND YEAR(InDateTime) != 0 
		ORDER BY CardNo");

		return $query;
	}

	public function OutPunchList($from_dt){
		$query = $this->db->query("SELECT * FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND YEAR(OutDateTime) = 0 
		AND YEAR(InDateTime) != 0 
		ORDER BY CardNo");

		return $query;
	}

	public function EarlyExitListCnt($from_dt){
		$query = $this->db->query("
		SELECT count(*) as cnt_ee FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND shiftEndTime > TIME(OutDateTime)
		AND YEAR(OutDateTime) != 0 
		ORDER BY CardNo");

		return $query;
	}

	public function EarlyExitList($from_dt){
		$query = $this->db->query("SELECT * FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND shiftEndTime > TIME(OutDateTime)
		AND YEAR(OutDateTime) != 0 
		ORDER BY CardNo");

		return $query;
	}

	public function LateEntryListCnt($from_dt){
		$query = $this->db->query("
		SELECT count(*) as cnt_le FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND TIME(InDateTime) > shiftStartTime
	    AND YEAR(InDateTime) != 0 
		ORDER BY CardNo");

		return $query;
	}

	public function LateEntryList($from_dt){
		$query = $this->db->query("SELECT * FROM tran_attendence 
		WHERE CalDate = '".$from_dt."'
		AND TIME(InDateTime) > shiftStartTime
	    AND YEAR(InDateTime) != 0  
		ORDER BY CardNo");

		return $query;
	}

	public function consolidate_mail_cnt($from_dt){
		$query = $this->db->query("SELECT count(*) as cnt FROM tran_mail_det WHERE CalDate = '".$from_dt."'ORDER BY sno");
		return $query;
	}

	public function consolidate_mail($from_dt){
		$query = $this->db->query("SELECT * FROM tran_mail_det WHERE CalDate = '".$from_dt."'ORDER BY sno");
		return $query;
	}
	
	public function ra($from_dt){
		$query = $this->db->query("SELECT distinct reports_to FROM tran_mail_det 
		WHERE CalDate = '".$from_dt."'ORDER BY reports_to");

		return $query;
	}

	public function ra_mail_cnt($from_dt, $reports_to){
		$query = $this->db->query("SELECT count(*) as cnt FROM tran_mail_det 
		WHERE CalDate = '".$from_dt."' AND reports_to = '".$reports_to."'");

		return $query;
	}

	public function ra_mail($from_dt, $reports_to){
		$query = $this->db->query("SELECT * FROM tran_mail_det 
		WHERE CalDate = '".$from_dt."' AND reports_to = '".$reports_to."' ORDER BY reports_to");

		return $query;
	}

// 	//Gate Pass Entry
// 	public function gp_entry($data){
// 		$gp_id = $this->input->post("gp_id");
// 		$gp_id1 = $this->input->post("gp_id");

// 		if($gp_id == ""){
// 			$sql_cnt = "select count(*) as count from gatepass where substring(gp_id,11,4) = '".date("Y")."'";
// 			$qry_cnt = $this->db->query($sql_cnt)->row();
// 			$count = $qry_cnt->count;

// 			if($count == 0){
// 				//GP-000001-2021;
// 				$gp_id = "GP-".sprintf('%06d', 1)."-".date("Y");
// 			} else {
// 				$sql_max = "select max(substring(gp_id,4,6)) as prev_no from gatepass 
// 				where substring(gp_id,11,4) = '".date("Y")."'";
				
// 				$qry_max = $this->db->query($sql_max)->row();
// 				$prev_no = $qry_max->prev_no;
// 				$new_no = $prev_no+1;
				
// 				$gp_id = "GP-".sprintf('%06d', $new_no)."-".date("Y");
// 			}
// 		}

// 		$gp_emp_id = $this->input->post("gp_emp_id");
// 		$gp_emp_name = $this->input->post("gp_emp_name");
// 		$gp_date = $this->input->post("gp_date");
// 		$gp_from_datetime = $this->input->post("gp_from_datetime");
// 		$gp_to_datetime = $this->input->post("gp_to_datetime");
// 		$gp_type = $this->input->post("gp_type");
// 		$gp_permission = $this->input->post("gp_permission");
// 		$gp_remarks = $this->input->post("gp_remarks");
// 		$gp_reports_to = $this->input->post("gp_reports_to");
// 		$gp_reports_to_name = $this->input->post("gp_reports_to_name");
// 		$gp_reports_email = $this->input->post("gp_reports_email");
// 		$gp_status = "Fresh";
// 		$created_by = $_SESSION['username'];
// 		$created_date = date("Y-m-d h:i:s");
// 		$modified_by = $_SESSION['username'];

// 		$this->db->trans_start();

// 		$query = $this->db->query("insert into gatepass(gp_id, gp_emp_id, gp_emp_name, gp_date, 
// 		gp_from_datetime, gp_to_datetime, gp_type, 
// 		gp_permission, gp_remarks, gp_reports_to, 
// 		gp_reports_to_name, gp_reports_email, gp_status, 
// 		created_by, created_date, modified_by)
// 		values('".$gp_id."', '".$gp_emp_id."', '".$gp_emp_name."', '".$gp_date."', 
// 		'".$gp_from_datetime."', '".$gp_to_datetime."', '".$gp_type."', 
// 		'".$gp_permission."', '".$gp_remarks."', '".$gp_reports_to."', 
// 		'".$gp_reports_to_name."', '".$gp_reports_email."', '".$gp_status."',
// 		'".$created_by."', '".$created_date."', '".$modified_by."')");

// 		$this->db->trans_complete();

// 	}

// 	//gate pass Send For Approval
// 	public function gp_sfa($data){
// 		$leave_id = $this->input->post("leave_id");
// 		$leave_status = "Pending For HOD Approval";
// 		$created_by = $_SESSION['username'];
// 		$created_date = date("Y-m-d h:i:s");
// 		$modified_by = $_SESSION['username'];

// 		$this->db->trans_start();

// 		$query = $this->db->query("update leave_mst set leave_status = '".$leave_status."' where leave_id = '".$leave_id."'");

// 		$this->db->trans_complete();

// 	}

// 	//gate pass HOD Approval
// 	public function gp_app_hod($data){
// 		$leave_id = $this->input->post("leave_id");
// 		$leave_status = "Pending For HR Approval";
// 		$created_by = $_SESSION['username'];
// 		$created_date = date("Y-m-d h:i:s");
// 		$modified_by = $_SESSION['username'];

// 		$this->db->trans_start();

// 		$query = $this->db->query("update leave_mst set leave_status = '".$leave_status."' where leave_id = '".$leave_id."'");

// 		$this->db->trans_complete();

// 	}

// 	//gate pass HR Approval
// 	public function gp_app_hr($data){
// 		$leave_id = $this->input->post("leave_id");
// 		$leave_status = "Approved";
// 		$created_by = $_SESSION['username'];
// 		$created_date = date("Y-m-d h:i:s");
// 		$modified_by = $_SESSION['username'];

// 		$this->db->trans_start();

// 		$query = $this->db->query("update leave_mst set leave_status = '".$leave_status."' where leave_id = '".$leave_id."'");

// 		$this->db->trans_complete();

// 	}



	//Leave Application 
	public function leave_entry($data){
		$db2 = $this->load->database('db2', TRUE);
		$leave_id = $this->input->post("leave_id");
		$leave_id1 = $this->input->post("leave_id");

		if($leave_id == ""){
			$sql_cnt = "select count(*) as count from leave_mst where substring(leave_id,11,4) = '".date("Y")."'";
			$qry_cnt = $this->db->query($sql_cnt)->row();
			$count = $qry_cnt->count;

			if($count == 0){
				//GP-000001-2021;
				$leave_id = "LV-".sprintf('%06d', 1)."-".date("Y");
			} else {
				$sql_max = "select max(substring(leave_id,4,6)) as prev_no from leave_mst 
				where substring(leave_id,11,4) = '".date("Y")."'";
				
				$qry_max = $this->db->query($sql_max)->row();
				$prev_no = $qry_max->prev_no;
				$new_no = $prev_no+1;
				
				$leave_id = "LV-".sprintf('%06d', $new_no)."-".date("Y");
			}
		}

		$leave_emp_id = $this->input->post("leave_emp_id");
		//$leave_reports_to = $this->input->post("leave_reports_to");

		//Reports To ID
		$sql_reports_to = "select prefered_email, reports_to from `tabEmployee` where name = '".$leave_emp_id."'";
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;
		$leave_pref_mail = $qry_reports_to->prefered_email;		
		
		//Reports To Mail
		$sql_reports_to_email = "select prefered_email , reports_to from `tabEmployee` where name = '".$reports_to."'";
		$qry_reports_to_email = $db2->query($sql_reports_to_email)->row();		
		$leave_pref_mail_hod = $qry_reports_to_email->prefered_email;		
		

		$leave_type = $this->input->post("leave_type");
		$leave_from_date = $this->input->post("leave_from_date");
		$leave_to_date = $this->input->post("leave_to_date");
		$leave_days = $this->input->post("tot_days");
		$leave_from_time = $this->input->post("leave_from_time");
		$is_halfday = $this->input->post("is_halfday");
		$half_day_type = $this->input->post("half_day_type");
		$half_day_date = $this->input->post("half_day_date");
		$leave_remarks = $this->input->post("leave_remarks");
		$leave_status = "Pending For HOD Approval";
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];

		$start_date = substr($leave_from_date,0,8)."01";
		$end_date = substr($leave_from_date,0,8)."31";

		if($half_day_type != ""){
			$is_halfday = 1;
		} else {
			$is_halfday = 0;
		}

		//Checking Condition User Cant Able to Apply Leaves More than 2 Days In A Month CL & Sick Leaves
		$sql_check = "select sum(leave_days) as tot_leave_days from leave_mst 
		where leave_type in('Casual_Leave','Sick_Leave') 
		and leave_from_date between '".$start_date."' and '".$end_date."'
		and leave_emp_id = '".$leave_emp_id."'
		and leave_status not in('Rejected By HOD','Rejected By HR','Rejected By Management')";

		$qry_check = $this->db->query($sql_check)->row();

		$tot_leave_days = $qry_check->tot_leave_days; 

		if($tot_leave_days == "" || $tot_leave_days == NULL){
			$tot_leave_days = 0;
		}

		if($leave_days == "" || $leave_days == NULL){
			echo "<h2 style='color:red'>Leave Days Cannot Be Null OR Zero. Go Back.</h2>";
			die;
		}
		
		$tot_leave_days = $tot_leave_days+$leave_days;

		if($tot_leave_days > 2 && $leave_type != 'Without_Pay_Leave'){
			echo "<h2 style='color:red'>More than Two Paid leaves in a month are not allowed. Go Back.</h2>";
			die;
		}


		$this->db->trans_start();
		
// 		echo "insert into leave_mst(leave_id, leave_emp_id, reports_to, leave_type, leave_from_date, leave_to_date, is_halfday,
// 		half_day_type, half_day_date,leave_days, created_by, created_date, modified_by , leave_status , leave_remarks)
// 		values('".$leave_id."', '".$leave_emp_id."','".$reports_to."','".$leave_type."', '".$leave_from_date."', '".$leave_to_date."', '".$is_halfday."', 
// 		'".$half_day_type."', '".$half_day_date."','".$leave_days."', '".$created_by."', '".$created_date."', '".$modified_by."','".$leave_status."','".$leave_remarks."')";
		
// 		die;

		$query = "insert into leave_mst(leave_id, leave_emp_id, reports_to, leave_type, leave_from_date, leave_to_date, is_halfday,
		half_day_type, half_day_date,leave_days, created_by, created_date, modified_by , leave_status , leave_remarks)
		values('".$leave_id."', '".$leave_emp_id."','".$reports_to."','".$leave_type."', '".$leave_from_date."', '".$leave_to_date."', '".$is_halfday."', 
		'".$half_day_type."', '".$half_day_date."','".$leave_days."', '".$created_by."', '".$created_date."', '".$modified_by."','".$leave_status."','".$leave_remarks."')";
		
		$this->db->db_debug = false;

        if(!@$this->db->query($query))
        {
            echo $error = $this->db->error();
            die;
            // do something in error case
        }

		$this->db->trans_complete();

		$query = $this->db->query("select * from leave_mst where leave_id='".$leave_id."'");
		return $query;
		
	}

	//Leave HOD Approval
	public function leave_app_hod($data){
		$leave_id = $this->input->post("leave_id");
		$app_inst = $this->input->post("app_status");

		if($app_inst == "Approve"){
			$leave_status = "Pending For HR Approval";
		} else {
			$leave_status = "Rejected By HOD";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$hod_app_by =  $_SESSION['username'];
		$hod_app_date = date("Y-m-d h:i:s");


		// $this->db->trans_start();

		// $query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
		// hod_app_by = '".$hod_app_by."', hod_app_date = '".$hod_app_date."' where leave_id = '".$leave_id."'");

		// $query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
		// hod_app_by = '".$hod_app_by."', hod_app_date = '".$hod_app_date."' where leave_id = '".$leave_id[$i]."'");

		// $this->db->trans_complete();

		$count_leave_id = count($leave_id);

		$this->db->trans_start();

		for($i=0;$i<$count_leave_id;$i++){
			$query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
			hod_app_by = '".$hod_app_by."', hod_app_date = '".$hod_app_date."' where leave_id = '".$leave_id[$i]."'");
		}

		$this->db->trans_complete();
	}

	//Leave HR Approval
	public function leave_app_hr($data){
		$leave_id = $this->input->post("leave_id");
		$app_inst = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$leave_status = "Pending For Management Approval";
		} else {
			$leave_status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");


		// $this->db->trans_start();

		// $query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
		// hr_app_by = '".$hr_app_by."', hr_app_date = '".$hr_app_date."', app_rmks_hr = '".$app_rmks."'  
		// where leave_id = '".$leave_id."'");

		// $this->db->trans_complete();

		$count_leave_id = count($leave_id);

		$this->db->trans_start();

		for($i=0;$i<$count_leave_id;$i++){
			$query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
			hr_app_by = '".$hr_app_by."', hr_app_date = '".$hr_app_date."'  
			where leave_id = '".$leave_id[$i]."'");
		}

		$this->db->trans_complete();
	}

	//Leave Management Approval
	public function leave_app_mng($data){
		$leave_id = $this->input->post("leave_id");
		$app_inst = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$leave_status = "Approved";
		} else {
			$leave_status = "Rejected By Management";
		}
		
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		// $this->db->trans_start();

		// $query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
		//  mgmt_app_by = '".$mgmt_app_by."', mgmt_app_date = '".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."'  
		//  where leave_id = '".$leave_id."'");

		// $this->db->trans_complete();

		$count_leave_id = count($leave_id);

		$this->db->trans_start();

		for($i=0;$i<$count_leave_id;$i++){
			$query = $this->db->query("update leave_mst set leave_status = '".$leave_status."',
			mgmt_app_by = '".$mgmt_app_by."', mgmt_app_date = '".$mgmt_app_date."'  
			where leave_id = '".$leave_id[$i]."'");
		}

		$this->db->trans_complete();
	}


	public function miss_pun_entry($data){  
		$db2 = $this->load->database('db2', TRUE); 
		$miss_pun_date = $this->input->post("miss_pun_date");
		$modified_by =  $_SESSION['username'];
		$created_by = $_SESSION['username'];
		$miss_pun_id = $this->input->post("miss_pun_id");				
		$miss_pun_id1 = $this->input->post("miss_pun_id");
		$miss_pun_date = $this->input->post("miss_pun_date");
		$miss_pun_type = $this->input->post("miss_pun_type");
		$mp_emp_id = $this->input->post("mp_emp_id");
		$hod_name = $this->input->post("hod_name");
		$hod_email = $this->input->post("hod_email");
		$miss_pun_time = $this->input->post("mp_time");
		$reason= $this->input->post("mp_reason");
		$created_date = date("Y-m-d h:i:s");
		$miss_punch_msd = substr($miss_pun_date,0,5)."01-01";
		$miss_punch_med = substr($miss_pun_date,0,5)."12-31";
		
		$mp_status=	"Pending For HOD Approval";

		//Lock For Duplicate Entries
		$sql_entry = "select count(*) as cnt from miss_punch 
		where mp_emp_id = '".$mp_emp_id."' and miss_pun_date = '".$miss_pun_date."'";

		$qyr_entry = $this->db->query($sql_entry)->row();
		$count_mp = $qyr_entry->cnt;

		if($count_mp >= 1){
			echo "<h2 style='color:red'>You Have Already Applied Miss Punch for this date.</h2>";
			die;
		}

		//Lock More than 3 Mispunches in a Year
		$sql = "select count(*) as cnt from miss_punch where mp_emp_id ='".$mp_emp_id."'
		and miss_pun_date between '".$miss_punch_msd."' and '".$miss_punch_med."'";

		$query = $this->db->query($sql)->row();

		$count1 = $query->cnt;

		if ($count1 > 3){
			echo "<h2 style='color:red'>More than 3 Mispunches are not allowed in a Year. Go Back</h2>";
			die;
		}

		//Lock If No Mispunch Then Mispunch is not allowed
		if($miss_pun_type == 'in'){
			$sql_mpin_chk = "select count(*) as InCnt from tran_attendence 
			where CalDate = '".$miss_pun_date."' and EmpId = '".$mp_emp_id."' and YEAR(InDateTime) != 0";

			$qry_mpin_chk = $this->db->query($sql_mpin_chk)->row();

			$InCnt = $qry_mpin_chk->InCnt;

			if($InCnt > 0){
				echo "<h2 style='color:red'>Miss Punch Application Not Allowed If In Punch Is Available. Go Back</h2>";
				die;	
			}
		}

		if($miss_pun_type == 'out'){
			$sql_mpout_chk = "select count(*) as OutCnt from tran_attendence 
			where CalDate = '".$miss_pun_date."' and EmpId = '".$mp_emp_id."' and YEAR(OutDateTime) != 0";

			$qry_mpout_chk = $this->db->query($sql_mpout_chk)->row();

			$OutCnt = $qry_mpout_chk->OutCnt;

			if($OutCnt > 0){
				echo "<h2 style='color:red'>Miss Punch Application Not Allowed If Out Punch Is Available. Go Back</h2>";
				die;	
			}
		}


		//Reports To ID
		$sql_reports_to = "select prefered_email , reports_to from `tabEmployee` where name = '".$mp_emp_id."'";
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;
		$mp_pref_mail = $qry_reports_to->prefered_email;
		//Reports To Mail
		$sql_reports_to_email = "select prefered_email , reports_to from `tabEmployee` where name = '".$reports_to."'";
		$qry_reports_to_email = $db2->query($sql_reports_to_email)->row();		
		$mp_pref_mail_hod = $qry_reports_to_email->prefered_email;		
		
		$query = $this->db->query("select * from miss_punch where miss_pun_id is not null");
		$id=$query->row();
		
		$sql_miss_cnt = "select count(*) as count from miss_punch";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;

		if($count == 0){
			//MPA-000000-21;
			$miss_pun_id = "MPA-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_miss_max = "select max(substring(miss_pun_id,10,6)) as prev_id from miss_punch";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$miss_pun_id = "MPA-".date("Y")."-".sprintf('%06d', $new_id);
			
		}

		//Transaction Start
		$this->db->trans_start();

		if($miss_pun_id1 == ""){
			//Insert Code
			$this->db->query("insert into miss_punch(miss_pun_id ,miss_pun_date ,miss_pun_time, 
			miss_pun_type, mp_emp_id, mp_emp_mail, mp_hod_id, mp_status, 
			mp_reason, created_by, created_date, modified_by)
			values ('".$miss_pun_id."','".$miss_pun_date."','".$miss_pun_time."',
			'".$miss_pun_type."','".$mp_emp_id."','".$mp_pref_mail."','".$reports_to."','".$mp_status."',
			'".$reason."' ,'".$created_by."','".$created_date."','".$modified_by."')");
		} else {
			//Update Code
			$sql_updt = $this->db->query("update miss_punch set miss_pun_date = '".$miss_pun_date."', 
			miss_pun_time= '".$miss_pun_time."', miss_pun_type = '".$miss_pun_type."', 
			mp_emp_id = '".$mp_emp_id."', mp_emp_mail='".$mp_pref_mail."', 
			mp_hod_id = '".$reports_to."', mp_reason='".$reason."' 
			where miss_pun_id = '".$miss_pun_id."'");
		}

		$this->db->trans_complete();
		//Transaction Complete
	}

	//Miss Punch HOD Approval
	public function mp_app_hod($data){
		$miss_pun_id = $this->input->post("miss_pun_id");
		$app_inst = $this->input->post("submit");

		if($app_inst == "Approve"){
			$mp_status = "Pending For HR Approval";
		} else {
			$mp_status = "Rejected By HOD";
		}

	 	$hod_approval_by = $_SESSION['username'];
		$hod_approval_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("update miss_punch set mp_status = '".$mp_status."', 
		hod_approval_by ='".$hod_approval_by."', hod_approval_date = '".$hod_approval_date."'  
		where miss_pun_id = '".$miss_pun_id."'");

		$this->db->trans_complete();

	}

	//Miss Punch HR Approval
	public function mp_app_hr($data){
		$miss_pun_id = $this->input->post("miss_pun_id");
		$app_inst = $this->input->post("submit");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$mp_status = "Pending For Management Approval";
		} else {
			$mp_status = "Rejected By HR";
		}
		
		$hr_approval_by =  $_SESSION['username'];
		$hr_approval_date = date("Y-m-d h:i:s");


		$this->db->trans_start();

		$query = $this->db->query("update miss_punch set mp_status = '".$mp_status."', 
		hr_approval_by ='".$hr_approval_by."', hr_approval_date = '".$hr_approval_date."', app_rmks_hr = '".$app_rmks."'
		where miss_pun_id = '".$miss_pun_id."'");

		$this->db->trans_complete();

	}

	//Miss Punch Management Approval
	public function mp_app_mng($data){
		$miss_pun_id = $this->input->post("miss_pun_id");
		
		$app_inst = $this->input->post("submit");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$mp_status = "Approved";
		} else {
			$mp_status = "Rejected By Management";
		}

		$mp_status = "Approved";
		$mgmt_approval_by =  $_SESSION['username'];
		$mgmt_approval_date = date("Y-m-d h:i:s");


		$this->db->trans_start();

		$query = $this->db->query("update miss_punch set mp_status = '".$mp_status."',
		 mgmt_app_by = '".$mgmt_approval_by."', mgmt_app_dt = '".$mgmt_approval_date."', app_rmks_mgmt = '".$app_rmks."'  
		 where miss_pun_id = '".$miss_pun_id."'");

		$this->db->trans_complete();
	}

	// Over Time
	public function over_time_entry($data){ 
		$db2 = $this->load->database('db2', TRUE); 
		$over_tim_id = $this->input->post("over_tim_id");		
		$over_tim_id1 = $this->input->post("over_tim_id");		
		$ot_emp_id =  $this->input->post("ot_emp_id");		
		$ot_frm_date =  $this->input->post("ot_frm_date");
		$ot_to_date = $this->input->post("ot_to_date");
		$ot_frm_time =  $this->input->post("ot_frm_time");		
		$ot_remarks =  $this->input->post("ot_remarks");
		$ot_to_time = $this->input->post("ot_to_time");
		$ot_tot_hrs = $this->input->post("ot_tot_hrs");		
		$username = $_SESSION['username'];		
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$ot_status=	"Pending For HOD Approval";

		//time difference

		$from_datetime = $ot_frm_date." ".$ot_frm_time;
		$to_datetime = $ot_to_date." ".$ot_to_time;
		
		$datetime1 = new DateTime($from_datetime);
		$datetime2 = new DateTime($to_datetime);
		$interval = $datetime1->diff($datetime2);
		$diffHours = $interval->format('%H:%I:%S');
		$diffHours = (float) preg_replace('/^(\d+):(\d+).+/','\1.\2',$diffHours);	
		
		if($diffHours > 24.00){
			echo "<style:'color-red';><h2>Overtime should not be greater than 24 Hours</h2>";
			die;
		}

		//locking two enteries in a day
		$sql_entry = "select count(*) as cnt from over_time where ot_emp_id = '".$ot_emp_id."' 
		and ot_frm_date = '".$ot_frm_date."' and ot_to_date = '".$ot_to_date."' 
		and ot_status not in('Rejected By Management','Rejected By HOD','Rejected By HR')";
		$qyr_entry = $this->db->query($sql_entry)->row();
		$count_ot = $qyr_entry->cnt;

		if($count_ot >= 1){
			echo "You have ALREADY APPLIED OVER TIME for this date";
			die;
		}
		
		//Reports To ID
		$sql_reports_to = "select prefered_email , reports_to from `tabEmployee` where name = '".$ot_emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;
		$ot_pref_mail = $qry_reports_to->prefered_mail;
		//Reports To Mail
		$sql_reports_to_email = "select prefered_email , reports_to from `tabEmployee` where name = '".$reports_to."'";
		$qry_reports_to_email = $db2->query($sql_reports_to_email)->row();		
		$ot_pref_mail_hod = $qry_reports_to_email->prefered_email;			
			
		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from over_time where over_tim_id is not null");
		$id=$query->row();
		
		
		//$id_miss_pun=$id->miss_pun_id;
		
		$sql_miss_cnt = "select count(*) as count from over_time";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){

			//OVT-2021-000005
			$over_tim_id = "OVT-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(over_tim_id,10,6)) as prev_id from over_time";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$over_tim_id = "OVT-".date("Y")."-".sprintf('%06d', $new_id);
					
		}
		

		if($over_tim_id1 == ""){
			//Insert Code
			$sql = "insert into over_time(over_tim_id, ot_emp_id ,ot_reports_to ,ot_frm_date,ot_frm_time,ot_to_date,ot_to_time ,ot_tot_hrs ,
			ot_status ,ot_remarks,created_by,created_date ,modified_by)values ('".$over_tim_id."','".$ot_emp_id."','".$reports_to."',
			'".$ot_frm_date."','".$ot_frm_time."','".$ot_to_date."' ,'".$ot_to_time."',
			'".$diffHours."','".$ot_status."' ,'".$ot_remarks."' ,'".$created_by."','".$created_date."','".$modified_by."')";
			
			$this->db->query($sql);

		} else {
			$sql_updt = "update over_time set  ot_emp_id= '".$ot_emp_id."',ot_emp_id= '".$ot_emp_id."',
			ot_reports_to = '".$reports_to."',	ot_frm_date = '".$ot_frm_date."', ot_frm_time = '".$ot_frm_time."', ot_to_date = '".$ot_to_date."',ot_to_time = '".$ot_to_time."',
			ot_total_hrs = '".$diffHours."',ot_status='".$ot_status."',ot_remarks='".$ot_remarks."',created_by = '".$created_by."',
			created_date= '".$created_date."',modified_by='".$modified_by."' where over_tim_id = '".$over_tim_id."'";
			
			$this->db->query($sql_updt);
		}
		
			$this->db->trans_complete();

			$query = $this->db->query("select * from over_time where over_tim_id ='".$over_tim_id."'");
			return $query;
	}

	//Over Time HOD Approval
	public function ot_app_hod($data){
		$over_tim_id = $this->input->post("over_tim_id");
		
		$app_inst = $this->input->post("app_status");

		if($app_inst == "Approve"){
			$ot_status = "Pending For HR Approval";
		} else {
			$ot_status = "Rejected By HOD";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$hod_app_by =  $_SESSION['username'];
		$hod_app_date = date("Y-m-d h:i:s");

		$count_over_tim_id = count($over_tim_id);

		$this->db->trans_start();

		for($i=0;$i<$count_over_tim_id;$i++){
			$query = $this->db->query("update over_time set ot_status = '".$ot_status."',
			hod_app_by = '".$hod_app_by."', hod_app_date = '".$hod_app_date."'  where over_tim_id = '".$over_tim_id[$i]."'");

		}

		$this->db->trans_complete();

	}

	//Over Time HR Approval
	public function ot_app_hr($data){
		$over_tim_id = $this->input->post("over_tim_id");

		$app_inst = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$ot_status = "Pending For Management Approval";
		} else {
			$ot_status = "Rejected By HR";
		}

		
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$count_over_tim_id = count($over_tim_id);

		$this->db->trans_start();

		for($i=0;$i<$count_over_tim_id;$i++){
			$query = $this->db->query("update over_time set ot_status = '".$ot_status."',
			hr_app_by = '".$hr_app_by."', hr_app_date = '".$hr_app_date."'  where over_tim_id = '".$over_tim_id[$i]."'");

		}

		$this->db->trans_complete();

	}
	
	//Over Time Management Approval
	public function ot_app_mng($data){
		$over_tim_id = $this->input->post("over_tim_id");
		
		$app_inst = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$ot_status = "Approved";
		} else {
			$ot_status = "Rejected By Management";
		}
		
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$mgm_app_by =  $_SESSION['username'];
		$mgm_app_date = date("Y-m-d h:i:s");

		$count_over_tim_id = count($over_tim_id);

		$this->db->trans_start();

		for($i=0;$i<$count_over_tim_id;$i++){
			$query = $this->db->query("update over_time set ot_status = '".$ot_status."',
			mgm_app_by = '".$mgm_app_by."', mgm_app_date = '".$mgm_app_date."'  where over_tim_id = '".$over_tim_id[$i]."'");

		}

		$this->db->trans_complete();
	
	}
	
	//email function
	public function emp_mail(){
		$query = $this->db->query("select * from old_employee");
		return $query;
	}

	//Salary Advance Entry
	public function sal_adv_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$sal_adv_id = $this->input->post("sal_adv_id");		
		$sal_adv_id1 =  $this->input->post("sal_adv_id");
		$emp_id =  $this->input->post("emp_id");
		$sys_cal_advamt =  $this->input->post("sys_cal_advamt");
		$sal_adv_req = $this->input->post("sal_adv_req");	
		$sal_adv_rmks = $this->input->post("sal_adv_rmks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For HOD Approval";

		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;	
		
		
		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from salary_adv where sal_adv_id is not null");
		$id=$query->row();
		//$id_miss_pun=$id->miss_pun_id;
		
		$sql_miss_cnt = "select count(*) as count from salary_adv";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){
			//SA-2021-000001
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(sal_adv_id,10,6)) as prev_id from salary_adv";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', $new_id);
		}

		$query_alert="select count(*) as cnt from salary_adv 
		where year(created_date) ='". date('Y')."'and month(created_date) = '".date('m')."' and emp_id='".$emp_id."'";

		$sql_alert=$this->db->query($query_alert)->row();

		$count_alert = $sql_alert->cnt;
		
		if($count_alert > 0){
			echo "<h2 style='color:red'>Advance already applied for this month.</h2>"; 
			die;
		}

		//Insert Code
		$sql = $this->db->query("insert into salary_adv(sal_adv_id,emp_id, reports_to ,sys_cal_advamt, 
		sal_adv_req, sal_adv_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$sal_adv_id."','".$emp_id."','".$reports_to."','".$sys_cal_advamt."',
		'".$sal_adv_req."','".$sal_adv_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	//Salary Advance HOD Approval
	public function sa_app_hod($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");

		if($app_status == "Approve"){
			$status = "Pending For HR Approval";
		} else {
			$status = "Rejected By HOD";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hod_app_by =  $_SESSION['username'];
		$hod_app_date = date("Y-m-d h:i:s");

		/*
		$this->db->trans_start();

		$query = $this->db->query("update salary_adv set status = '".$status."', hod_app_by='".$hod_app_by."',
		hod_app_date='".$hod_app_date."' where sal_adv_id = '".$sal_adv_id."'");
		$this->db->trans_complete();

		$this->db->trans_complete();
		*/

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv set status = '".$status."', hod_app_by='".$hod_app_by."',
			hod_app_date='".$hod_app_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance HR Approval
	public function sa_app_hr($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");
		/*
		$this->db->trans_start();

		$query = $this->db->query("update salary_adv set status = '".$status."', hr_app_by='".$hr_app_by."',
		hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
		where sal_adv_id = '".$sal_adv_id."'");

		$this->db->trans_complete();
		*/

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv set status = '".$status."', hr_app_by='".$hr_app_by."',
			hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
			where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}
	//Salary Advance Management Approval
	public function sa_app_mng($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Payment";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");		

		/*
		$this->db->trans_start();

		$query = $this->db->query("update salary_adv set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
		mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where sal_adv_id = '".$sal_adv_id."'");

		$this->db->trans_complete();
		*/

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance Payment
	public function sa_app_pay($data){
		$sal_adv_id = $this->input->post("sal_adv_id");
		$PaidMode = $this->input->post("PaidMode");

		$app_status = $this->input->post("app_status");

		if($app_status == "Paid"){
			$status = "Paid";
		} else {
			$status = "Unpaid";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$payment_by =  $_SESSION['username'];
		$payment_date = date("Y-m-d h:i:s");		

		/*
		$this->db->trans_start();

		$query = $this->db->query("update salary_adv set status = '".$status."', PaidMode = '".$PaidMode."', payment_by='".$payment_by."',
		payment_date='".$payment_date."' where sal_adv_id = '".$sal_adv_id."'");

		$this->db->trans_complete();
		*/

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv set status = '".$status."', PaidMode = '".$PaidMode."', 
			payment_by='".$payment_by."', payment_date='".$payment_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	/*********************************************** */
	/*************Spcl Salary Advance*************** */
	/*********************************************** */
	//Special Salary Advance Entry
	public function spcl_sal_adv_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$sal_adv_id = $this->input->post("sal_adv_id");		
		$sal_adv_id1 =  $this->input->post("sal_adv_id");
		$emp_id =  $this->input->post("emp_id");
		$sys_cal_advamt =  $this->input->post("sys_cal_advamt");
		$sal_adv_req = $this->input->post("sal_adv_req");	
		$sal_adv_rmks = $this->input->post("sal_adv_rmks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For Management Approval";
		
		//Removing Single Quotes
		$sal_adv_rmks = str_replace("'","",$sal_adv_rmks);

		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;	
		
		
		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from spcl_salary_adv where sal_adv_id is not null");
		$id=$query->row();
		//$id_miss_pun=$id->miss_pun_id;
		
		$sql_miss_cnt = "select count(*) as count from salary_adv";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){
			//SA-2021-000001
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(sal_adv_id,10,6)) as prev_id from spcl_salary_adv";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Insert Code
		$sql = $this->db->query("insert into spcl_salary_adv(sal_adv_id,emp_id, reports_to ,sys_cal_advamt, 
		sal_adv_req, sal_adv_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$sal_adv_id."','".$emp_id."','".$reports_to."','".$sys_cal_advamt."',
		'".$sal_adv_req."','".$sal_adv_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	
	//Special Salary Advance Management Approval
	public function spcl_sa_app_mng($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Payment";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update spcl_salary_adv set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Special Salary Advance Payment
	public function spcl_sa_app_pay($data){
		$sal_adv_id = $this->input->post("sal_adv_id");
		$PaidMode = $this->input->post("PaidMode");

		$app_status = $this->input->post("app_status");

		if($app_status == "Paid"){
			$status = "Paid";
		} else {
			$status = "Unpaid";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$payment_by =  $_SESSION['username'];
		$payment_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update spcl_salary_adv set status = '".$status."', PaidMode = '".$PaidMode."', 
			payment_by='".$payment_by."', payment_date='".$payment_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	/****************************************************************** */
	/*************Paper Cup Salary Advance*************** */
	/****************************************************************** */

	//Salary Advance Entry
	public function pcpb_sal_adv_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$sal_adv_id = $this->input->post("sal_adv_id");		
		$sal_adv_id1 =  $this->input->post("sal_adv_id");
		$emp_id =  $this->input->post("emp_id");
		$sys_cal_advamt =  $this->input->post("sys_cal_advamt");
		$sal_adv_req = $this->input->post("sal_adv_req");	
		$sal_adv_rmks = $this->input->post("sal_adv_rmks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For HOD Approval";

		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;	
		
		
		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from salary_adv_pcpb where sal_adv_id is not null");
		$id=$query->row();
		//$id_miss_pun=$id->miss_pun_id;
		
		$sql_miss_cnt = "select count(*) as count from salary_adv_pcpb";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){
			//SA-2021-000001
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(sal_adv_id,10,6)) as prev_id from salary_adv_pcpb";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', $new_id);
		}

		$query_alert="select count(*) as cnt from salary_adv_pcpb 
		where year(created_date) ='". date('Y')."'and month(created_date) = '".date('m')."' and emp_id='".$emp_id."'";

		$sql_alert=$this->db->query($query_alert)->row();

		$count_alert = $sql_alert->cnt;
		
		if($count_alert > 0){
			echo "<h2 style='color:red'>Advance already applied for this month.</h2>"; 
			die;
		}

		//Insert Code
		$sql = $this->db->query("insert into salary_adv_pcpb(sal_adv_id,emp_id, reports_to ,sys_cal_advamt, 
		sal_adv_req, sal_adv_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$sal_adv_id."','".$emp_id."','".$reports_to."','".$sys_cal_advamt."',
		'".$sal_adv_req."','".$sal_adv_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	//Salary Advance HOD Approval
	public function pcpb_sa_app_hod($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");

		if($app_status == "Approve"){
			$status = "Pending For HR Approval";
		} else {
			$status = "Rejected By HOD";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hod_app_by =  $_SESSION['username'];
		$hod_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pcpb set status = '".$status."', hod_app_by='".$hod_app_by."',
			hod_app_date='".$hod_app_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance HR Approval
	public function pcpb_sa_app_hr($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pcpb set status = '".$status."', hr_app_by='".$hr_app_by."',
			hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
			where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}
	//Salary Advance Management Approval
	public function pcpb_sa_app_mng($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Payment";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pcpb set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance Payment
	public function pcpb_sa_app_pay($data){
		$sal_adv_id = $this->input->post("sal_adv_id");
		$PaidMode = $this->input->post("PaidMode");

		$app_status = $this->input->post("app_status");

		if($app_status == "Paid"){
			$status = "Paid";
		} else {
			$status = "Unpaid";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$payment_by =  $_SESSION['username'];
		$payment_date = date("Y-m-d h:i:s");		

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pcpb set status = '".$status."', PaidMode = '".$PaidMode."', 
			payment_by='".$payment_by."', payment_date='".$payment_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}


	/****************************************************************** */
	/*************Paper Blank Salary Advance*************** */
	/****************************************************************** */

	//Salary Advance Entry
	public function pb_sal_adv_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$sal_adv_id = $this->input->post("sal_adv_id");		
		$sal_adv_id1 =  $this->input->post("sal_adv_id");
		$emp_id =  $this->input->post("emp_id");
		$sys_cal_advamt =  $this->input->post("sys_cal_advamt");
		$sal_adv_req = $this->input->post("sal_adv_req");	
		$sal_adv_rmks = $this->input->post("sal_adv_rmks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For HOD Approval";

		//Reports To ID
		$sql_reports_to = "select hod_id as reports_to from `tabWorker` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;	
		
		
		//Transaction Start
		$this->db->trans_start();
		$query = $this->db->query("select * from salary_adv_pb where sal_adv_id is not null");
		$id=$query->row();
		//$id_miss_pun=$id->miss_pun_id;
		
		$sql_miss_cnt = "select count(*) as count from salary_adv_pb";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){
			//SA-2021-000001
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(sal_adv_id,10,6)) as prev_id from salary_adv_pb";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', $new_id);
		}

		$query_alert="select count(*) as cnt from salary_adv_pb 
		where year(created_date) ='". date('Y')."'and month(created_date) = '".date('m')."' and emp_id='".$emp_id."'";

		$sql_alert=$this->db->query($query_alert)->row();

		$count_alert = $sql_alert->cnt;
		
		if($count_alert > 0){
			echo "<h2 style='color:red'>Advance already applied for this month.</h2>"; 
			die;
		}

		//Insert Code
		$sql = $this->db->query("insert into salary_adv_pb(sal_adv_id,emp_id, reports_to ,sys_cal_advamt, 
		sal_adv_req, sal_adv_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$sal_adv_id."','".$emp_id."','".$reports_to."','".$sys_cal_advamt."',
		'".$sal_adv_req."','".$sal_adv_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	//Salary Advance HOD Approval
	public function pb_sa_app_hod($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");

		if($app_status == "Approve"){
			$status = "Pending For HR Approval";
		} else {
			$status = "Rejected By HOD";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hod_app_by =  $_SESSION['username'];
		$hod_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pb set status = '".$status."', hod_app_by='".$hod_app_by."',
			hod_app_date='".$hod_app_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance HR Approval
	public function pb_sa_app_hr($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pb set status = '".$status."', hr_app_by='".$hr_app_by."',
			hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
			where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}
	//Salary Advance Management Approval
	public function pb_sa_app_mng($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Payment";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pb set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance Payment
	public function pb_sa_app_pay($data){
		$sal_adv_id = $this->input->post("sal_adv_id");
		$PaidMode = $this->input->post("PaidMode");

		$app_status = $this->input->post("app_status");

		if($app_status == "Paid"){
			$status = "Paid";
		} else {
			$status = "Unpaid";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$payment_by =  $_SESSION['username'];
		$payment_date = date("Y-m-d h:i:s");		

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_pb set status = '".$status."', PaidMode = '".$PaidMode."', 
			payment_by='".$payment_by."', payment_date='".$payment_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}


	/*********************************************** */
	/*************Payment Request / Return*************** */
	/*********************************************** */
	//Payment Request / Return Entry
	public function pr_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$pr_id = $this->input->post("pr_id");		
		$pr_id1 =  $this->input->post("pr_id");
		$emp_id =  $this->input->post("emp_id");
		$pr_type =  $this->input->post("pr_type");
		$pr_amt = $this->input->post("pr_amt");	
		$pr_rmks = $this->input->post("pr_rmks");			
		$pay_type = $this->input->post("pay_type");			
		$pay_mode = $this->input->post("pay_mode");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For Management Approval";		
		
		//Transaction Start
		$this->db->trans_start();
		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;
		
		$sql_miss_cnt = "select count(*) as count from pr_mst";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){
			//PR-2021-000001
			$pr_id = "PR-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(pr_id,10,6)) as prev_id from pr_mst";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$pr_id = "PR-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Insert Code
		$sql = $this->db->query("insert into pr_mst(pr_id, emp_id, reports_to, pr_type, pr_amt, pay_type, pay_mode, 
		pr_rmks, status, created_by, created_date, modified_by) 
		values ('".$pr_id."','".$emp_id."','".$reports_to."','".$pr_type."','".$pr_amt."','".$pay_type."','".$pay_mode."',
		'".$pr_rmks."','".$status."','".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	//Payment Request / Return Management Approval
	public function pr_app_mng($data){
		$pr_id = $this->input->post("pr_id");

		$app_inst = $this->input->post("submit");
		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Pending For Payment";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");		

		$this->db->trans_start();

		$query = $this->db->query("update pr_mst set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
		mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where pr_id = '".$pr_id."'");

		$this->db->trans_complete();

	}

	//Payment Request / Return Payment
	public function pr_app_pay($data, $NewFileName2){
		$pr_id = $this->input->post("pr_id");
		$chk_utr_no = $this->input->post("chk_utr_no");

		$app_inst = $this->input->post("submit");

		if($app_inst == "Paid"){
			$status = "Paid";
		} else {
			$status = "Unpaid";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$payment_by =  $_SESSION['username'];
		$payment_date = date("Y-m-d h:i:s");		

		$this->db->trans_start();

		$query = $this->db->query("update pr_mst set status = '".$status."', payment_by='".$payment_by."',
		payment_date='".$payment_date."', chk_utr_no = '".$chk_utr_no."', cash_att = '".$NewFileName2."' 
		where pr_id = '".$pr_id."'");

		$this->db->trans_complete();

	}


	//Penalty Entry
	public function penalty_entry($data){
		$db2 = $this->load->database('db2', TRUE); 

		$penalty_id = $this->input->post("penalty_id");		
		$penalty_id1 =  $this->input->post("penalty_id");
		$penalty_emp_id =  $this->input->post("penalty_emp_id");
		$penalty_hours =  $this->input->post("penalty_hours");
		$penalty_date = $this->input->post("penalty_date");	
		$penalty_remarks = $this->input->post("penalty_remarks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$penalty_status = "Pending For HR Approval";
		
		$sql_miss_cnt = "select count(*) as count from penalty";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;

		if($count == 0){
			//PE-2021-000001
			$penalty_id = "PE-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(penalty_id,10,6)) as prev_id from penalty";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$penalty_id = "PE-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Transaction Start
		$this->db->trans_start();

		//Insert Code
		$sql = $this->db->query("insert into penalty(penalty_id, penalty_emp_id, penalty_hours, penalty_date, 
		penalty_remarks, penalty_status, 
		created_by, created_date, modified_by) 
		values ('".$penalty_id."','".$penalty_emp_id."','".$penalty_hours."','".$penalty_date."',
		'".$penalty_remarks."','".$penalty_status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	//Penalty HR Approval
	public function penalty_app_hr($data){
		$penalty_id = $this->input->post("penalty_id");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("update penalty set penalty_status = '".$status."', hr_app_by='".$hr_app_by."',
		hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
		where penalty_id = '".$penalty_id."'");

		$this->db->trans_complete();

	}

	//Penalty Management Approval
	public function penalty_app_mng($data){
		$penalty_id = $this->input->post("penalty_id");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Approved";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");		

		$this->db->trans_start();

		$query = $this->db->query("update penalty set penalty_status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
		mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' 
		where penalty_id = '".$penalty_id."'");

		$this->db->trans_complete();
	}


	//Adjustment Entry
	public function adjustments_entry($data){
		$db2 = $this->load->database('db2', TRUE); 

		$adjustments_id = $this->input->post("adjustments_id");		
		$adjustments_id1 =  $this->input->post("adjustments_id");
		$adjustments_emp_id =  $this->input->post("adjustments_emp_id");
		$adjustments_hours =  $this->input->post("adjustments_hours");
		$adjustments_date = $this->input->post("adjustments_date");	
		$adjustments_rmks = $this->input->post("adjustments_rmks");			
		$adjustments_type = $this->input->post("adjustments_type");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$adjustments_status = "Pending For HR Approval";
		
		$sql_miss_cnt = "select count(*) as count from adjustments";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;

		if($count == 0){
			//AD-2021-000001
			$adjustments_id = "AD-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(adjustments_id,10,6)) as prev_id from adjustments";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$adjustments_id = "AD-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Transaction Start
		$this->db->trans_start();

		//Insert Code
		$sql = $this->db->query("insert into adjustments(adjustments_id, adjustments_emp_id, 
		adjustments_hours, adjustments_date, 
		adjustments_rmks, adjustments_status, adjustments_type,
		created_by, created_date, modified_by) 
		values ('".$adjustments_id."','".$adjustments_emp_id."',
		'".$adjustments_hours."','".$adjustments_date."',
		'".$adjustments_rmks."','".$adjustments_status."','".$adjustments_type."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
		//Transanction Complete
	}

	//Adjustment HR Approval
	public function adjustments_app_hr($data){
		$adjustments_id = $this->input->post("adjustments_id");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("update adjustments set adjustments_status = '".$status."', hr_app_by='".$hr_app_by."',
		hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
		where adjustments_id = '".$adjustments_id."'");

		$this->db->trans_complete();

	}

	//Adjustment Management Approval
	public function adjustments_app_mng($data){
		$adjustments_id = $this->input->post("adjustments_id");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Approved";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");		

		$this->db->trans_start();

		$query = $this->db->query("update adjustments set adjustments_status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
		mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' 
		where adjustments_id = '".$adjustments_id."'");

		$this->db->trans_complete();
	}

	//DR Entry
	public function dr_entry($data){ 
		$db2 = $this->load->database('db2', TRUE);   
		$dr_id = $this->input->post("dr_id");
		$dr_id1 = $this->input->post("dr_id");
		$dr_emp_id = $this->input->post("dr_emp_id");
		$dr_date = $this->input->post("dr_date");
		$dr_att_type = $this->input->post("dr_att_type");
		$dr_from_time = $this->input->post("dr_from_time");
		$dr_to_time = $this->input->post("dr_to_time");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$dr_status = "Pending For HOD Approval";

		$dr_details = $this->input->post("dr_details");
		$dr_tour_loc = $this->input->post("dr_tour_loc");

		$dr_details = str_replace("'","",$dr_details);
		$dr_tour_loc = str_replace("'","",$dr_tour_loc);

		//Checking Duplicate Entries Of Same Date
		$sql_prev = "select count(*) as cnt_prev from dr_hrms_mst 
		where dr_emp_id = '".$dr_emp_id."' and dr_date = '".$dr_date."' 
		and dr_status not in('Rejected By HOD','Rejected By HR','Rejected By Management')";

		$qry_prev = $this->db->query($sql_prev)->row();

		$cnt_prev = $qry_prev->cnt_prev;

		if($cnt_prev > 0){
			echo "<h2 style='color:red'>Same Date DR Cannot Be Applied. Go Back</h2>";
			die;
		}

		//Checking Previous Unapproved DR
		$sql_unapp_dr = "SELECT count(*) as cnt_uapp_dr FROM `dr_hrms_mst` 
		where dr_emp_id = '".$dr_emp_id."' 
		and dr_status in('Pending For HOD Approval','Pending For HR Approval','Pending For Management Approval')";

		$qry_unapp_dr = $this->db->query($sql_unapp_dr)->row();

		$cnt_uapp_dr = $qry_unapp_dr->cnt_uapp_dr;

		if($cnt_uapp_dr > 0){
			echo "<h2 style='color:red'>New DR Cannot Be Applied When Previous DR Not Approved. Go Back</h2>";
			die;
		}


		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$dr_emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;

		//Counts
		$arr_cnt = count($dr_details);

		//Transaction Start
		$this->db->trans_start();	
		$sql_dr_cnt = "select count(*) as count from dr_hrms_mst";
		$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
		$count = $qry_dr_cnt->count;

		if($count == 0){
			//PNIDR-2020-000001;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_dr_max = "select max(substring(dr_id,12,6)) as prev_id from dr_hrms_mst";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', $new_id);
		}
		
		if($dr_id1 == ""){
			//Insert Code
			$sql = "insert into dr_hrms_mst(dr_id, dr_emp_id, dr_date, dr_att_type, reports_to, dr_status,
			created_by, created_date, modified_by) 
			values ('".$dr_id."', '".$dr_emp_id."', '".$dr_date."', '".$dr_att_type."', '".$reports_to."', '".$dr_status."',
			'".$created_by."','".$created_date."','".$modified_by."')";
			
			$this->db->query($sql);

			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = "insert into dr_hrms_dtl(dr_id, dr_details, dr_tour_loc, dr_from_time, dr_to_time) 
				values ('".$dr_id."', '".$dr_details[$i]."', '".$dr_tour_loc[$i]."', '".$dr_from_time[$i]."', '".$dr_to_time[$i]."')";

				$qry_itm_ins = $this->db->query($sql_itm_ins);
			}

		} else {
			//Update Code
			$sql = "update dr_hrms_mst set dr_date = '".$dr_date."', 
			dr_emp_id = '".$dr_emp_id."', 
			dr_att_type = '".$dr_att_type."', 
			reports_to = '".$reports_to."', 
			dr_status = '".$dr_status."'
			where dr_id = '".$dr_id1."'";

			$this->db->query($sql);

			//count dr_details
			$sql_dr_cnt = "select count(*) as cnt from dr_hrms_dtl where dr_id = '".$dr_id1."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from dr_hrms_dtl where dr_id = '".$dr_id1."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_hrms_dtl(dr_id, dr_details, dr_tour_loc, dr_from_time, dr_to_time) 
					values ('".$dr_id."', '".$dr_details[$i]."', '".$dr_tour_loc[$i]."', '".$dr_from_time[$i]."', '".$dr_to_time[$i]."')";

					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into dr_hrms_dtl(dr_id, dr_details, dr_tour_loc, dr_from_time, dr_to_time) 
					values ('".$dr_id."', '".$dr_details[$i]."', '".$dr_tour_loc[$i]."', '".$dr_from_time[$i]."', '".$dr_to_time[$i]."')";

					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}

		}
		
		$this->db->trans_complete();
		//Transanction Complete
	 }

	//DR HOD Approval
	public function dr_app_hod($data){
		$dr_id = $this->input->post("dr_id");
		$dr_att_type = $this->input->post("dr_att_type");

		$app_inst = $this->input->post("submit");

		if($app_inst == "Approve"){
			$status = "Pending For HR Approval";
		} else {
			$status = "Rejected By HOD";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hod_app_by =  $_SESSION['username'];
		$hod_app_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("update dr_hrms_mst set dr_status = '".$status."', dr_att_type = '".$dr_att_type."',
		hod_app_by='".$hod_app_by."', hod_app_date='".$hod_app_date."' where dr_id = '".$dr_id."'");

		$this->db->trans_complete();

	}

	//DR HR Approval
	public function dr_app_hr($data){
		$dr_id = $this->input->post("dr_id");
		$dr_att_type = $this->input->post("dr_att_type");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("update dr_hrms_mst set dr_status = '".$status."', dr_att_type = '".$dr_att_type."',
		hr_app_by='".$hr_app_by."', hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
		where dr_id = '".$dr_id."'");

		$this->db->trans_complete();

	}

	//DR Management Approval
	public function dr_app_mng($data){
		$dr_id = $this->input->post("dr_id");
		$dr_att_type = $this->input->post("dr_att_type");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Approved";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");		

		$this->db->trans_start();

		$query = $this->db->query("update dr_hrms_mst set dr_status = '".$status."', dr_att_type = '".$dr_att_type."',
		mgmt_app_by='".$mgmt_app_by."', mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' 
		where dr_id = '".$dr_id."'");

		$this->db->trans_complete();

	}

	//HKCL DR
	public function hkcl_dr_entry($data){ 
		$db2 = $this->load->database('db2', TRUE);   
		$hkcl_dr_id = $this->input->post("hkcl_dr_id");
		$hkcl_dr_id1 = $this->input->post("hkcl_dr_id");
		$dr_name = $this->input->post("dr_name");
		$dr_date = $this->input->post("dr_date");
		$dr_type = $this->input->post("dr_type");
		$dr_comp = $this->input->post("dr_comp");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$dr_status = "Pending For Management Approval";
		$dr_details = $this->input->post("dr_details");
		
		//Counts
		$arr_cnt = count($dr_details);

		//Transaction Start
		$this->db->trans_start();	
		$sql_dr_cnt = "select count(*) as count from hkcl_dr_mst";
		$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
		$count = $qry_dr_cnt->count;

		if($count == 0){
			//PNIDR-2020-000001;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', 1);
		} else {
			$sql_dr_max = "select max(substring(hkcl_dr_id,12,6)) as prev_id from hkcl_dr_mst";
			$qry_dr_max = $this->db->query($sql_dr_max)->row();
			$prev_id = $qry_dr_max->prev_id;
			$prev_id = number_format($prev_id,0,".","");
			$new_id = $prev_id+1;
			$dr_id = "PNIDR-".date("Y")."-".sprintf('%06d', $new_id);
		}
		
		if($dr_id1 == ""){
			//Insert Code
			$sql = "insert into hkcl_dr_mst(hkcl_dr_id, dr_name, dr_date, dr_type, dr_comp, dr_status,
			created_by, created_date, modified_by) 
			values ('".$dr_id."', '".$dr_name."', '".$dr_date."', '".$dr_type."', '".$dr_comp."', '".$dr_status."',
			'".$created_by."','".$created_date."','".$modified_by."')";
			
			$this->db->query($sql);

			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = "insert into hkcl_dr_det(hkcl_dr_id, dr_details) 
				values ('".$dr_id."', '".$dr_details[$i]."')";

				$qry_itm_ins = $this->db->query($sql_itm_ins);
			}

		} else {
			//Update Code
			$sql = "update hkcl_dr_mst set dr_date = '".$dr_date."', 
			dr_name = '".$dr_name."', 
			dr_type = '".$dr_type."', 
			dr_comp = '".$dr_comp."', 
			dr_status = '".$dr_status."'
			where hkcl_dr_id = '".$hkcl_dr_id."'";

			$this->db->query($sql);

			//count dr_details
			$sql_dr_cnt = "select count(*) as cnt from hkcl_dr_det where hkcl_dr_id = '".$hkcl_dr_id1."'";
			$qry_dr_cnt = $this->db->query($sql_dr_cnt)->row();
			$cnt = $qry_dr_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from hkcl_dr_det where hkcl_dr_id = '".$hkcl_dr_id1."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into hkcl_dr_det(hkcl_dr_id, dr_details) 
					values ('".$hkcl_dr_id."', '".$dr_details[$i]."')";

					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into hkcl_dr_det(hkcl_dr_id, dr_details) 
					values ('".$hkcl_dr_id."', '".$dr_details[$i]."')";

					$qry_itm_ins = $this->db->query($sql_itm_ins);
				}
			}

		}
		
		$this->db->trans_complete();
		//Transanction Complete
	 }

	//DR Management Approval
	public function hkcl_dr_app_mng($data){
		$hkcl_dr_id = $this->input->post("hkcl_dr_id");

		$app_inst = $this->input->post("submit");

		$app_rmks = $this->input->post("app_rmks");

		if($app_inst == "Approve"){
			$status = "Approved";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");		

		$this->db->trans_start();

		$query = $this->db->query("update hkcl_dr_mst set dr_status = '".$status."',
		mgmt_app_by='".$mgmt_app_by."', mgmt_app_date='".$mgmt_app_date."'
		where hkcl_dr_id = '".$hkcl_dr_id."'");

		$this->db->trans_complete();

	}	

	//Salary Approval Management
	public function sal_app_mgmt($data){
		$payroll_id = $this->input->post("payroll_id");
		$sal_app_emp = $this->input->post("sal_app_emp");
		$app_status = $this->input->post("app_status");
		$emp_type = $this->input->post("emp_type");
		$type = $this->input->post("type");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		if($app_status == 'Approved'){
			$app_status = "Pending For Payment";
		}

		$count_emp = count($sal_app_emp);

		if($type == '0'){
			$tbl_name = 'payroll_mst_type1';
		} else if($type == '1') {
			$tbl_name = 'payroll_mst_type2';
		} else if($type == 'pc') {
			$tbl_name = 'payroll_mst_pc';
		} else if($type == 'pb') {
			$tbl_name = 'payroll_mst_pb';
		} else if($type == 'mpppro') {
			$tbl_name = 'payroll_mst_mpppro';
		}

		$this->db->trans_start();

		for($i=0;$i<$count_emp;$i++){

			$this->db->query("update $tbl_name set status = '".$app_status."',
			mgmt_app_by = '".$mgmt_app_by."', mgmt_app_date = '".$mgmt_app_date."' 
			where payroll_id = '".$payroll_id."' 
			and EmpId = '".$sal_app_emp[$i]."'");

		}

		$this->db->trans_complete();

	}

	//Salary Approval Payment
	public function sal_app_pay($data){
		$payroll_id = $this->input->post("payroll_id");
		$sal_app_emp = $this->input->post("sal_app_emp");
		$app_status = $this->input->post("app_status");
		$emp_type = $this->input->post("emp_type");
		$type = $this->input->post("type");
		$PaidMode = $this->input->post("PaidMode");
		$paid_by =  $_SESSION['username'];
		$paid_date = date("Y-m-d h:i:s");

		$count_emp = count($sal_app_emp);

		if($type == '0'){
			$tbl_name = 'payroll_mst_type1';
		} else if($type == '1') {
			$tbl_name = 'payroll_mst_type2';
		} else if($type == 'pc') {
			$tbl_name = 'payroll_mst_pc';
		} else if($type == 'pb') {
			$tbl_name = 'payroll_mst_pb';
		} else if($type == 'mpppro') {
			$tbl_name = 'payroll_mst_mpppro';
		}

		$this->db->trans_start();

		for($i=0;$i<$count_emp;$i++){

			$this->db->query("update $tbl_name set status = '".$app_status."',
			paid_by = '".$paid_by."', paid_date = '".$paid_date."', PaidMode = '".$PaidMode."'
			where payroll_id = '".$payroll_id."' 
			and EmpId = '".$sal_app_emp[$i]."'");

			//Updating Previous Negative Salary Payment
			if($app_status == "Paid"){
				$this->db->query("update neg_sal_emp set deducted = 1 where EmpId = '".$sal_app_emp[$i]."'");
			}

		}

		$this->db->trans_complete();

	}

	//OT Approval Management
	public function ot_app_mgmt($data){
		$payroll_id = $this->input->post("payroll_id");
		$sal_app_emp = $this->input->post("sal_app_emp");
		$app_status = $this->input->post("app_status");
		$emp_type = $this->input->post("emp_type");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		if($app_status == 'Approved'){
			$app_status = "Approved";
		}

		$count_emp = count($sal_app_emp);

		$this->db->trans_start();

		for($i=0;$i<$count_emp;$i++){

			$this->db->query("update fixed_overtime set status = '".$app_status."',
			mgmt_app_by = '".$mgmt_app_by."', mgmt_app_date = '".$mgmt_app_date."' 
			where payroll_id = '".$payroll_id."' 
			and EmpId = '".$sal_app_emp[$i]."'");

		}

		$this->db->trans_complete();

	}

	//OT Approval Payment
	public function ot_app_pay($data){
		$payroll_id = $this->input->post("payroll_id");
		$sal_app_emp = $this->input->post("sal_app_emp");
		$app_status = $this->input->post("app_status");
		$emp_type = $this->input->post("emp_type");
		$type = $this->input->post("type");
		$PaidMode = $this->input->post("PaidMode");
		$paid_by =  $_SESSION['username'];
		$paid_date = date("Y-m-d h:i:s");

		$count_emp = count($sal_app_emp);

		$this->db->trans_start();

		for($i=0;$i<$count_emp;$i++){

			$this->db->query("update fixed_overtime set status = '".$app_status."',
			paid_by = '".$paid_by."', paid_date = '".$paid_date."', PaidMode = '".$PaidMode."'
			where payroll_id = '".$payroll_id."' 
			and EmpId = '".$sal_app_emp[$i]."'");

			//Updating Previous Negative Salary Payment
			if($app_status == "Paid"){
				$this->db->query("update neg_sal_emp set deducted = 1 where EmpId = '".$sal_app_emp[$i]."'");
			}

		}

		$this->db->trans_complete();

	}


	/*********************************************** */
	/************* Arrear ************************** */
	/*********************************************** */
	//Arrear Entry
	public function arrear_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$arrear_id = $this->input->post("arrear_id");		
		$arrear_id1 =  $this->input->post("arrear_id");
		$emp_id =  $this->input->post("emp_id");
		$arrear_amt = $this->input->post("arrear_amt");	
		$arrear_rmks = $this->input->post("arrear_rmks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For Management Approval";

		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;	
		
		
		//Transaction Start
		$this->db->trans_start();		
		$sql_miss_cnt = "select count(*) as count from arrear";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;

		if($count == 0){
			//AR-2021-000001
			$arrear_id = "AR-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(arrear_id,10,6)) as prev_id from arrear";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$arrear_id = "AR-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Insert Code
		$sql = $this->db->query("insert into arrear(arrear_id, emp_id, reports_to, 
		arrear_amt, arrear_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$arrear_id."','".$emp_id."','".$reports_to."',
		'".$arrear_amt."','".$arrear_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	
	//Arrear Management Approval
	public function arrear_app_mng($data){
		$arrear_id = $this->input->post("arrear_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Approved";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		$count_ar_id = count($arrear_id);

		$this->db->trans_start();

		for($i=0;$i<$count_ar_id;$i++){
			$query = $this->db->query("update arrear set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where arrear_id = '".$arrear_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	/*********************************************** */
	/************* Deductions*********************** */
	/*********************************************** */
	//Deductions Entry
	public function ded_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$ded_id = $this->input->post("ded_id");		
		$ded_id1 =  $this->input->post("ded_id");
		$emp_id =  $this->input->post("emp_id");
		$ded_amt = $this->input->post("ded_amt");	
		$ded_rmks = $this->input->post("ded_rmks");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For Management Approval";

		//Reports To ID
		$sql_reports_to = "select reports_to from `tabEmployee` where name = '".$emp_id."'";		
		$qry_reports_to = $db2->query($sql_reports_to)->row();
		$reports_to = $qry_reports_to->reports_to;	
		
		
		//Transaction Start
		$this->db->trans_start();		
		$sql_miss_cnt = "select count(*) as count from deductions";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;

		if($count == 0){
			//DE-2021-000001
			$ded_id = "DE-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(ded_id,10,6)) as prev_id from deductions";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$ded_id = "DE-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Insert Code
		$sql = $this->db->query("insert into deductions(ded_id, emp_id, reports_to, 
		ded_amt, ded_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$ded_id."','".$emp_id."','".$reports_to."',
		'".$ded_amt."','".$ded_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	
	//Deductions Management Approval
	public function ded_app_mng($data){
		$ded_id = $this->input->post("ded_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Approved";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		$count_de_id = count($ded_id);

		$this->db->trans_start();

		for($i=0;$i<$count_de_id;$i++){
			$query = $this->db->query("update deductions set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where ded_id = '".$ded_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//MPP Production Employee & Others
	public function mpp_prod_emp_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$emp_id = $this->input->post("emp_id");		
		$emp_id1 =  $this->input->post("emp_id");
		$emp_name =  $this->input->post("emp_name");
		$type = $this->input->post("type");			
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		
		
		//Transaction Start
		$this->db->trans_start();		
		$sql_miss_cnt = "select count(*) as count from mpp_prod_oth_emp_mst";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;

		if($count == 0){
			//MPP-2021-000001
			$emp_id = "MPP-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(emp_id,11,6)) as prev_id from mpp_prod_oth_emp_mst";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$emp_id = "MPP-".date("Y")."-".sprintf('%06d', $new_id);
		}

		//Insert Code
		$sql = $this->db->query("insert into mpp_prod_oth_emp_mst(emp_id, emp_name ,type,
		created_by, created_date, modified_by) 
		values ('".$emp_id."','".$emp_name."','".$type."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		$this->db->trans_complete();
	}

	//Salary Advance Entry
	public function mpp_prod_sal_adv_entry($data){
		$db2 = $this->load->database('db2', TRUE); 
		$sal_adv_id = $this->input->post("sal_adv_id");		
		$sal_adv_id1 =  $this->input->post("sal_adv_id");
		$emp_id =  $this->input->post("emp_id");
		$sal_adv_req = $this->input->post("sal_adv_req");				
		$created_by = $_SESSION['username'];				
		$created_date = date("Y-m-d h:i:s");	
		$modified_by =  $_SESSION['username'];
		$status=	"Pending For HR Approval";	
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql_miss_cnt = "select count(*) as count from salary_adv_mpp_prod";
		$qry_miss_cnt = $this->db->query($sql_miss_cnt)->row();
		$count = $qry_miss_cnt->count;
		//echo $count;die;

		if($count == 0){
			//SA-2021-000001
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', 1);
			
		} else {
			$sql_miss_max = "select max(substring(sal_adv_id,10,6)) as prev_id from salary_adv_mpp_prod";
			$qry_miss_max = $this->db->query($sql_miss_max)->row();
			$prev_id = $qry_miss_max->prev_id;
			$new_id = $prev_id+1;
			$sal_adv_id = "SA-".date("Y")."-".sprintf('%06d', $new_id);
		}

		$query_alert="select count(*) as cnt from salary_adv_mpp_prod 
		where year(created_date) ='". date('Y')."'and month(created_date) = '".date('m')."' and emp_id='".$emp_id."'";

		$sql_alert=$this->db->query($query_alert)->row();

		$count_alert = $sql_alert->cnt;
		
		if($count_alert > 0){
			echo "<h2 style='color:red'>Advance already applied for this month.</h2>"; 
			die;
		}

		//Insert Code
		$sql = $this->db->query("insert into salary_adv_mpp_prod(sal_adv_id,emp_id, reports_to ,
		sal_adv_req, sal_adv_rmks, status, 
		created_by, created_date, modified_by) 
		values ('".$sal_adv_id."','".$emp_id."','".$reports_to."',
		'".$sal_adv_req."','".$sal_adv_rmks."','".$status."',
		'".$created_by."','".$created_date."' ,'".$modified_by."')");
		
		if($this->db->affected_rows() <= 0){
		    echo "Query Not Executed";
		    /*
		    echo "insert into salary_adv_mpp_prod(sal_adv_id,emp_id, reports_to , 
    		sal_adv_req, sal_adv_rmks, status, 
    		created_by, created_date, modified_by) 
    		values ('".$sal_adv_id."','".$emp_id."','".$reports_to."',
    		'".$sal_adv_req."','".$sal_adv_rmks."','".$status."',
    		'".$created_by."','".$created_date."' ,'".$modified_by."')";*/
		    die;
		}
		
		$this->db->trans_complete();
	}

	//Salary Advance HR Approval
	public function mpp_prod_sa_app_hr($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Management Approval";
		} else {
			$status = "Rejected By HR";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$hr_app_by =  $_SESSION['username'];
		$hr_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_mpp_prod set status = '".$status."', hr_app_by='".$hr_app_by."',
			hr_app_date='".$hr_app_date."', app_rmks_hr = '".$app_rmks."' 
			where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}
	//Salary Advance Management Approval
	public function mpp_prod_sa_app_mng($data){
		$sal_adv_id = $this->input->post("sal_adv_id");

		$app_status = $this->input->post("app_status");
		$app_rmks = $this->input->post("app_rmks");

		if($app_status == "Approve"){
			$status = "Pending For Payment";
		} else {
			$status = "Rejected By Management";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$mgmt_app_by =  $_SESSION['username'];
		$mgmt_app_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_mpp_prod set status = '".$status."', mgmt_app_by='".$mgmt_app_by."',
			mgmt_app_date='".$mgmt_app_date."', app_rmks_mgmt = '".$app_rmks."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//Salary Advance Payment
	public function mpp_prod_sa_app_pay($data){
		$sal_adv_id = $this->input->post("sal_adv_id");
		$PaidMode = $this->input->post("PaidMode");

		$app_status = $this->input->post("app_status");

		if($app_status == "Paid"){
			$status = "Paid";
		} else {
			$status = "Unpaid";
		}

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$payment_by =  $_SESSION['username'];
		$payment_date = date("Y-m-d h:i:s");

		$count_sa_id = count($sal_adv_id);

		$this->db->trans_start();

		for($i=0;$i<$count_sa_id;$i++){
			$query = $this->db->query("update salary_adv_mpp_prod set status = '".$status."', PaidMode = '".$PaidMode."', 
			payment_by='".$payment_by."', payment_date='".$payment_date."' where sal_adv_id = '".$sal_adv_id[$i]."'");
		}

		$this->db->trans_complete();

	}

	//MPP Production Salary Entry
	public function mpp_prod_sal_entry($data){
		$payroll_id = $this->input->post("payroll_id");
		$month_start_date = $this->input->post("month_start_date");
		$month_end_date = $this->input->post("month_end_date");
		$emp_id = $this->input->post("emp_id");
		$employee_name = $this->input->post("employee_name");
		$employee_type = $this->input->post("employee_type");
		$tot_sal = $this->input->post("tot_sal");

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		$count_emp_id = count($emp_id);

		$this->db->trans_start();

		for($i=0;$i<$count_emp_id;$i++){

			//Checking Previous Entry
			$sql_chk = "select count(*) as cnt from mpp_prod_sal where payroll_id = '".$payroll_id."' and emp_id = '".$emp_id[$i]."'";
			$qry_chk = $this->db->query($sql_chk)->row();

			$cnt = $qry_chk->cnt;

			if($cnt > 0){

				$query = $this->db->query("update mpp_prod_sal set payroll_id = '".$payroll_id."', 
				month_start_date = '".$month_start_date."', month_end_date = '".$month_end_date."', 
				emp_id = '".$emp_id[$i]."', employee_name = '".$employee_name[$i]."', employee_type = '".$employee_type[$i]."', tot_sal = '".$tot_sal[$i]."',
				modified_by = '".$created_by."' 
				where payroll_id = '".$payroll_id."' and emp_id = '".$emp_id[$i]."'");

			} else {

				$query = $this->db->query("insert into mpp_prod_sal(payroll_id, month_start_date, month_end_date, 
				emp_id, employee_name, employee_type, tot_sal,
				created_by, created_date) 
				values('".$payroll_id."', '".$month_start_date."', '".$month_end_date."', 
				'".$emp_id[$i]."', '".$employee_name[$i]."', '".$employee_type[$i]."', '".$tot_sal[$i]."',
				'".$created_by."', '".$created_date."')");

			}
		}

		$this->db->trans_complete();

	}

	/*****Regular Relaxation******* */
	public function reg_relax_entry($data){
		$relax_emp_type = $this->input->post("relax_emp_type");
		$relax_time = $this->input->post("relax_time");
		$relax_app_date = $this->input->post("relax_app_date");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("insert into reg_relax(relax_emp_type, relax_time, relax_app_date, created_by, created_date) 
		values('".$relax_emp_type."', '".$relax_time."', '".$relax_app_date."', '".$created_by."', '".$created_date."')");

		$this->db->trans_complete();
	}

	/*****Occassional Relaxation******* */
	public function occ_relax_entry($data){
		$relax_emp_type = $this->input->post("relax_emp_type");
		$relax_time = $this->input->post("relax_time");
		$relax_app_date = $this->input->post("relax_app_date");
		$relax_notm = $this->input->post("relax_notm");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		$this->db->trans_start();

		$query = $this->db->query("insert into occ_relax(relax_emp_type, relax_time, relax_app_date, relax_notm, created_by, created_date) 
		values('".$relax_emp_type."', '".$relax_time."', '".$relax_app_date."', '".$relax_notm."', '".$created_by."', '".$created_date."')");

		$this->db->trans_complete();
	}
}  
?>