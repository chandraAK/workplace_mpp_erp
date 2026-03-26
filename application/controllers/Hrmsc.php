<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Hrmsc extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->database(); 
		 $this->load->model('hrmsm');
	}
	
	//Dashboard
	public function index(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'HRMS DB' => 'hrmsc',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/hrms_db',$data); 
		$this->load->view('admin/footer');
	}

	//Dashboard
	public function hrms_pni_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'HRMS DB' => 'hrmsc',
			'HRMS PNI DB' => 'hrmsc/hrms_pni_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/hrms_pni_db',$data); 
		$this->load->view('admin/footer');
	}

	//Dashboard
	public function hrms_mpp_db(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'HRMS DB' => 'hrmsc',
			'HRMS MPP DB' => 'hrmsc/hrms_mpp_db',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/hrms_mpp_db',$data); 
		$this->load->view('admin/footer');
	}

	public function Att_Card(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Attendance Card' => 'hrmsc/Att_Card',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/Att_Card',$data); 
		$this->load->view('admin/footer');
	}

	public function Att_Card_Ajax(){ 
		$this->load->view('admin/modules/hrms/Att_Card_Ajax'); 
	}

	//Attendance Report New
	public function att_rpt_new(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Attendence Report New' => 'hrmsc/att_rpt_new',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/att_rpt_new',$data); 
		$this->load->view('admin/footer');
	}

	public function att_rpt_new_ajax(){ 
		$this->load->view('admin/modules/hrms/att_rpt_new_ajax'); 
	}

	//Attendance Report New
	public function att_det_tot(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Attendence Details' => 'hrmsc/att_det_tot',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/att_det_tot',$data); 
		$this->load->view('admin/footer');
	}

	public function att_det_tot_ajax(){ 
		$this->load->view('admin/modules/hrms/att_det_tot_ajax'); 
	}

	//Attendance Paid Days Report
	public function att_pd_rpt(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Paid Days Report' => 'hrmsc/att_pd_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/att_pd_rpt',$data); 
		$this->load->view('admin/footer');
	}

	public function att_pd_rpt_ajax(){ 
		$this->load->view('admin/modules/hrms/att_pd_rpt_ajax'); 
	}

	//Monthly Attendence Report
	public function monthly_att_rpt(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Monthly Attendence Report' => 'hrmsc/monthly_att_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/monthly_att_rpt',$data); 
		$this->load->view('admin/footer');
	}

	//Monthly Attendence Report Ajax
	public function monthly_att_rpt_ajax(){ 
		$this->load->view('admin/modules/hrms/monthly_att_rpt_ajax'); 
	}

	//Monthly Attendence Report
	public function monthly_mp_rpt(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Monthly Mispunch Report' => 'hrmsc/monthly_mp_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/monthly_mp_rpt',$data); 
		$this->load->view('admin/footer');
	}

	//Monthly Attendence Report Ajax
	public function monthly_mp_rpt_ajax(){ 
		$this->load->view('admin/modules/hrms/monthly_mp_rpt_ajax'); 
	}

	//Attendence Calculate
	public function att_calc(){
		$this->load->view('admin/modules/hrms/att_calc'); 
	} 

	//Mispunch Script
	public function mispunch_script(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Mispunch Report' => 'hrmsc/mispunch_script',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mispunch_script',$data); 
		$this->load->view('admin/footer');
	}
	
	//Mispunch Script Ajax
	public function mispunch_script_ajax(){
		$this->load->view('admin/modules/hrms/mispunch_script_ajax'); 
	}

	//Mispunch Script Ajax
	public function mispunch_script_mail(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$from_dt = $_REQUEST['from_dt'];

		//Inpunch Email
		$data['InPunchListCnt']=$this->hrmsm->InPunchListCnt($from_dt);
		foreach($data['InPunchListCnt']->result_array() AS $row){
			$cnt_ip = $row['cnt_ip'];
		}

		if($cnt_ip > 0){

			$data['InPunchList']=$this->hrmsm->InPunchList($from_dt);

			foreach($data['InPunchList']->result_array() AS $row){
				$CardNo = $row['CardNo'];
				$EmpId = $row['EmpId'];
				$EmpName = $row['EmpName'];
				$CalDate = $row['CalDate'];
				$reports_to = $row['reports_to'];
				$mispunch = "In Punch Missing";
				$emp_email = get_emp_email($EmpId);
				$rep_email = get_rep_email($reports_to);

				$this->email->from("notifications@mahaveergroup.net");
				$this->email->bcc('notifications@mahaveergroup.net');
				$subject = "Mispunch-".$from_dt;
				$this->email->subject($subject);
				$this->email->to($emp_email);
				//$this->email->to("chandra.sharmadb@gmail.com");
				//$cc_email = "notifications@mahaveergroup.net,".$emp_rt_email;
				$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com";
				$this->email->cc($cc_email);

				$message_table = "
				<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black; font-size:11px; padding:10px; border-radius:5px;'>
					<tr style='background-color:#CFF'>
						<td><b>CARD NO</b></td>
						<td><b>EMPLOYEE ID</b></td>
						<td><b>EMPLOYEE NAME</b></td>
						<td><b>MISPUNCH DATE</b></td>
						<td><b>MISPUNCH TIME</b></td>
					</tr>
					<tr>
						<td>".$CardNo."</td>
						<td>".$EmpId."</td>
						<td>".$EmpName."</td>
						<td>".$CalDate."</td>
						<td>".$mispunch."</td>
					</tr>
				</table>";

				$message = $message_table."<br/><b>Thanks & Regards,</b>
				<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

				$this->email->message($message);
				if(!$this->email->send()){
					echo $this->email->print_debugger();
					die;
				}
			}

		}

		//Outpunch Email
		$data['OutPunchListCnt']=$this->hrmsm->OutPunchListCnt($from_dt);

		foreach($data['OutPunchListCnt']->result_array() AS $row){
			$cnt_op = $row['cnt_op'];
		}

		if($cnt_op > 0){
			$data['OutPunchList']=$this->hrmsm->OutPunchList($from_dt);

			foreach($data['OutPunchList']->result_array() AS $row){
				$CardNo = $row['CardNo'];
				$EmpId = $row['EmpId'];
				$EmpName = $row['EmpName'];
				$CalDate = $row['CalDate'];
				$reports_to = $row['reports_to'];
				$mispunch = "Out Punch Missing";
				$emp_email = get_emp_email($EmpId);
				$rep_email = get_rep_email($reports_to);

				$this->email->from("notifications@mahaveergroup.net");
				$this->email->bcc('notifications@mahaveergroup.net');
				$subject = "Mispunch-".$from_dt;
				$this->email->subject($subject);
				$this->email->to($emp_email);
				//$this->email->to("chandra.sharmadb@gmail.com");
				//$cc_email = "notifications@mahaveergroup.net,".$emp_rt_email;
				$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com";
				$this->email->cc($cc_email);

				$message_table = "
				<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black; font-size:11px; padding:10px; border-radius:5px;'>
					<tr style='background-color:#CFF'>
						<td><b>CARD NO</b></td>
						<td><b>EMPLOYEE ID</b></td>
						<td><b>EMPLOYEE NAME</b></td>
						<td><b>MISPUNCH DATE</b></td>
						<td><b>MISPUNCH TIME</b></td>
					</tr>
					<tr>
						<td>".$CardNo."</td>
						<td>".$EmpId."</td>
						<td>".$EmpName."</td>
						<td>".$CalDate."</td>
						<td>".$mispunch."</td>
					</tr>
				</table>";

				$message = $message_table."<br/><b>Thanks & Regards,</b>
				<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

				$this->email->message($message);
				if(!$this->email->send()){
					echo $this->email->print_debugger();
					die;
				}
			}
		}
		

		$this->load->view('admin/modules/hrms/mispunch_script_mail'); 
	}

	//Early Exit Script
	public function early_exit_script(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Early Exit Report' => 'hrmsc/early_exit_script',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/early_exit_script',$data); 
		$this->load->view('admin/footer');
	}
	
	//Early Exit Script Ajax
	public function early_exit_script_ajax(){
		$this->load->view('admin/modules/hrms/early_exit_script_ajax'); 
	}

	//Early Exit Script Mail
	public function early_exit_script_mail(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$from_dt = $_REQUEST['from_dt'];

		//Inpunch Email
		$data['EarlyExitListCnt']=$this->hrmsm->EarlyExitListCnt($from_dt);
		foreach($data['EarlyExitListCnt']->result_array() AS $row){
			$cnt_ee = $row['cnt_ee'];
		}

		if($cnt_ee > 0){

			$data['EarlyExitList']=$this->hrmsm->EarlyExitList($from_dt);

			foreach($data['EarlyExitList']->result_array() AS $row){
				$CardNo = $row['CardNo'];
				$EmpId = $row['EmpId'];
				$EmpName = $row['EmpName'];
				$CalDate = $row['CalDate'];
				$reports_to = $row['reports_to'];
				$ShiftEndTime = $row['ShiftEndTime'];
                $OutDateTime = $row['OutDateTime'];
				$emp_email = get_emp_email($EmpId);
				$rep_email = get_rep_email($reports_to);

				$this->email->from("notifications@mahaveergroup.net");
				$this->email->bcc('notifications@mahaveergroup.net');
				$subject = "Early Exit-".$from_dt;
				$this->email->subject($subject);
				$this->email->to($emp_email);
				//$this->email->to("chandra.sharmadb@gmail.com");
				//$cc_email = "notifications@mahaveergroup.net,".$emp_rt_email;
				$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com";
				$this->email->cc($cc_email);

				$message_table = "
				<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black; font-size:11px; padding:10px; border-radius:5px;'>
					<tr style='background-color:#CFF'>
						<td><b>CARD NO</b></td>
						<td><b>EMPLOYEE ID</b></td>
						<td><b>EMPLOYEE NAME</b></td>
						<td><b>SHIFT END TIME</b></td>
						<td><b>OUTPUNCH</b></td>
					</tr>
					<tr>
						<td>".$CardNo."</td>
						<td>".$EmpId."</td>
						<td>".$EmpName."</td>
						<td>".$ShiftEndTime."</td>
						<td>".$OutDateTime."</td>
					</tr>
				</table>";

				$message = $message_table."<br/><b>Thanks & Regards,</b>
				<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

				$this->email->message($message);
				if(!$this->email->send()){
					echo $this->email->print_debugger();
					die;
				}
			}
		}
		

		$this->load->view('admin/modules/hrms/early_exit_script_mail'); 
	}

	//Late Entry Script
	public function late_entry_script(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Late Entry Report' => 'hrmsc/late_entry_script',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/late_entry_script',$data); 
		$this->load->view('admin/footer');
	}
	
	//Late Entry Script Ajax
	public function late_entry_script_ajax(){
		$this->load->view('admin/modules/hrms/late_entry_script_ajax'); 
	}

	//Late Entry Script Ajax
	public function late_entry_script_mail(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$from_dt = $_REQUEST['from_dt'];

		//Late Entry Email
		$data['LateEntryListCnt']=$this->hrmsm->LateEntryListCnt($from_dt);
		foreach($data['LateEntryListCnt']->result_array() AS $row){
			$cnt_le = $row['cnt_le'];
		}

		if($cnt_le > 0){

			$data['LateEntryList']=$this->hrmsm->LateEntryList($from_dt);

			foreach($data['LateEntryList']->result_array() AS $row){
				$CardNo = $row['CardNo'];
				$EmpId = $row['EmpId'];
				$EmpName = $row['EmpName'];
				$CalDate = $row['CalDate'];
				$reports_to = $row['reports_to'];
				$ShiftStartTime = $row['ShiftStartTime'];
                $InDateTime = $row['InDateTime'];
				$emp_email = get_emp_email($EmpId);
				$rep_email = get_rep_email($reports_to);

				$this->email->from("notifications@mahaveergroup.net");
				$this->email->bcc('notifications@mahaveergroup.net');
				$subject = "Late Entry-".$from_dt;
				$this->email->subject($subject);
				$this->email->to($emp_email);
				//$this->email->to("chandra.sharmadb@gmail.com");
				//$cc_email = "notifications@mahaveergroup.net,".$emp_rt_email;
				$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com";
				$this->email->cc($cc_email);

				$message_table = "
				<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black; font-size:11px; padding:10px; border-radius:5px;'>
					<tr style='background-color:#CFF'>
						<td><b>CARD NO</b></td>
						<td><b>EMPLOYEE ID</b></td>
						<td><b>EMPLOYEE NAME</b></td>
						<td><b>SHIFT START TIME</b></td>
						<td><b>INPUNCH</b></td>
					</tr>
					<tr>
						<td>".$CardNo."</td>
						<td>".$EmpId."</td>
						<td>".$EmpName."</td>
						<td>".$ShiftStartTime."</td>
						<td>".$InDateTime."</td>
					</tr>
				</table>";

				$message = $message_table."<br/><b>Thanks & Regards,</b>
				<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

				$this->email->message($message);
				if(!$this->email->send()){
					echo $this->email->print_debugger();
					die;
				}
			}
		}
		

		$this->load->view('admin/modules/hrms/late_entry_script_mail'); 
	}

	//HR Mail Script
	public function mail_script(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Mail Script' => 'hrmsc/mail_script',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mail_script',$data); 
		$this->load->view('admin/footer');
	}

	//HR Mail Script
	public function mail_script_ajax(){
		$this->load->view('admin/modules/hrms/mail_script_ajax'); 
	}


	public function mail_all(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$from_dt = $_REQUEST['from_dt'];

		//HR Consolidate Mail
		$this->email->to("hr@mahaveergroup.net");
		//$this->email->to("chandra.sharmadb@gmail.com");
		$this->email->from("notifications@mahaveergroup.net");
		$this->email->bcc('notifications@mahaveergroup.net');
		$subject = "ALL Mispunch/ Early Exit / Late Entry -".$from_dt;
		$this->email->subject($subject);
		$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com";
		$this->email->cc($cc_email);

		$data['consolidate_mail_cnt']=$this->hrmsm->consolidate_mail_cnt($from_dt);
		foreach($data['consolidate_mail_cnt']->result_array() AS $row){
			$cnt = $row['cnt'];
		}

		if($cnt > 0){

			$data['consolidate_mail']=$this->hrmsm->consolidate_mail($from_dt);

			$message_table = "
			<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black; font-size:11px; padding:10px; border-radius:5px;'>
				<tr style='background-color:#CFF'>
					<td><b>CARD NO</b></td>
					<td><b>EMPLOYEE ID</b></td>
					<td><b>EMPLOYEE NAME</b></td>
					<td><b>SHIFT START TIME</b></td>
					<td><b>SHIFT START TIME</b></td>
					<td><b>MISPUNCH TYPE</b></td>
					<td><b>LATE ENTRY</b></td>
					<td><b>EARLY EXIT</b></td>
				</tr>";

			foreach($data['consolidate_mail']->result_array() AS $row){
				$CardNo = $row['CardNo'];
				$EmpId = $row['EmpId'];
				$EmpName = $row['EmpName'];
				$CalDate = $row['CalDate'];
				$reports_to = $row['reports_to'];
				$ShiftStartTime = $row['ShiftStartTime'];
				$ShiftEndTime = $row['ShiftEndTime'];
				$MisPunchType = $row['MisPunchType'];
				$LateEntry = $row['LateEntry'];
				$EarlyExit = $row['EarlyExit'];

				$message_table .= "
					<tr>
						<td>".$CardNo."</td>
						<td>".$EmpId."</td>
						<td>".$EmpName."</td>
						<td>".$ShiftStartTime."</td>
						<td>".$ShiftEndTime."</td>
						<td>".$MisPunchType."</td>
						<td>".$LateEntry."</td>
						<td>".$EarlyExit."</td>
					</tr>";

				
			}

			$message_table .= "</table>";

			$message = $message_table."<br/><b>Thanks & Regards,</b>
				<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

			$this->email->message($message);
			if(!$this->email->send()){
				echo $this->email->print_debugger();
				die;
			}
		}


		$this->load->view('admin/modules/hrms/mail_all'); 
	}

	public function mail_ra(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$from_dt = $_REQUEST['from_dt'];

		$data['ra']=$this->hrmsm->ra($from_dt);

		foreach($data['ra']->result_array() AS $row){
			$cnt = 0;
			$reports_to = $row['reports_to'];
			$rep_email = get_rep_email($reports_to);

			$this->email->to($rep_email);
			//$this->email->to("chandra.sharmadb@gmail.com");
			$this->email->from("notifications@mahaveergroup.net");
			$this->email->bcc('notifications@mahaveergroup.net');
			$subject = "ALL TEAM Mispunch/ Early Exit / Late Entry -".$from_dt;
			$this->email->subject($subject);
			$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com";
			$this->email->cc($cc_email);


			$data['ra_mail_cnt']=$this->hrmsm->ra_mail_cnt($from_dt, $reports_to);

			foreach($data['ra_mail_cnt']->result_array() AS $row){
				$cnt = $row['cnt'];
			}

			if($cnt > 0){
				$data['ra_mail']=$this->hrmsm->ra_mail($from_dt, $reports_to);

				$message_table = "
				<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black; font-size:11px; padding:10px; border-radius:5px;'>
					<tr style='background-color:#CFF'>
						<td><b>CARD NO</b></td>
						<td><b>EMPLOYEE ID</b></td>
						<td><b>EMPLOYEE NAME</b></td>
						<td><b>SHIFT START TIME</b></td>
						<td><b>SHIFT START TIME</b></td>
						<td><b>MISPUNCH TYPE</b></td>
						<td><b>LATE ENTRY</b></td>
						<td><b>EARLY EXIT</b></td>
					</tr>";

				foreach($data['ra_mail']->result_array() AS $row){
					$CardNo = $row['CardNo'];
					$EmpId = $row['EmpId'];
					$EmpName = $row['EmpName'];
					$CalDate = $row['CalDate'];
					$reports_to = $row['reports_to'];
					$ShiftStartTime = $row['ShiftStartTime'];
					$ShiftEndTime = $row['ShiftEndTime'];
					$MisPunchType = $row['MisPunchType'];
					$LateEntry = $row['LateEntry'];
					$EarlyExit = $row['EarlyExit'];

					$message_table .= "
						<tr>
							<td>".$CardNo."</td>
							<td>".$EmpId."</td>
							<td>".$EmpName."</td>
							<td>".$ShiftStartTime."</td>
							<td>".$ShiftEndTime."</td>
							<td>".$MisPunchType."</td>
							<td>".$LateEntry."</td>
							<td>".$EarlyExit."</td>
						</tr>";

					
				}

				$message_table .= "</table>";

				$message = $message_table."<br/><b>Thanks & Regards,</b>
					<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

				$this->email->message($message);
				if(!$this->email->send()){
					echo $this->email->print_debugger();
					die;
				}


			}
		}

		$this->load->view('admin/modules/hrms/mail_ra'); 
	}
	
	//Attendance Log Report
	public function att_log_report(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Attendence Log Report' => 'hrmsc/att_log_report',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/att_log_report',$data); 
		$this->load->view('admin/footer');
	}

	//Attendance Log Report Ajax
	public function att_log_report_ajax(){
		$this->load->view('admin/modules/hrms/att_log_report_ajax'); 
	}

	//Penalties Type1
	public function penalty_type1(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Penalties Type1 Report' => 'hrmsc/penalty_type1',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/penalty_type1',$data); 
		$this->load->view('admin/footer');
	}
	
	//Penalties Type1 Ajax
	public function penalty_type1_ajax(){
		$this->load->view('admin/modules/hrms/penalty_type1_ajax'); 
	}

	//Penalties Type2
	public function penalty_type2(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Penalties Type2 Report' => 'hrmsc/penalty_type2',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/penalty_type2',$data); 
		$this->load->view('admin/footer');
	}
	
	//Penalties Type2 Ajax
	public function penalty_type2_ajax(){
		$this->load->view('admin/modules/hrms/penalty_type2_ajax'); 
	}

	/*********************************** */
	/************Payroll**************** */
	/*********************************** */

	//Salary Sheet Monthly
	public function sal_sheet_monthly(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Salary Sheet Monthly' => 'hrmsc/sal_sheet_monthly',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_sheet_monthly',$data); 
		$this->load->view('admin/footer');
	}

	//Salary Sheet Monthly Ajax
	public function sal_sheet_monthly_ajax(){
		$this->load->view('admin/modules/hrms/sal_sheet_monthly_ajax'); 
	}

	//Salary Sheet Daily
	public function sal_sheet_daily(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Salary Sheet Daily' => 'hrmsc/sal_sheet_daily',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_sheet_daily',$data); 
		$this->load->view('admin/footer');
	}

	//Salary Sheet Monthly Ajax
	public function sal_sheet_daily_ajax(){
		$this->load->view('admin/modules/hrms/sal_sheet_daily_ajax'); 
	}

	/********************************************** */
	/*****************Gatepass********************* */
	/********************************************** */

	//Gate Pass Application
	public function gp_list(){
		$tbl_nm = "gatepass";
		$data = array();
		$data['list_title'] = "Gate Pass List";
		$data['list_url'] = "hrmsc/gp_list";
		$data['tbl_nm'] = "gatepass";
		$data['primary_col'] = "gp_id";
		$data['edit_url'] = "hrmsc/gp_add";
		$data['edit_enable'] = "yes";

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'HRMS List' => 'hrmsc/gp_list',
		);

		$data['ViewHead'] = $this->hrmsm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Gate Pass Add
	public function gp_add(){
		$id = $_REQUEST['id'];
		$tbl_nm = "gatepass";
		$id_col = "gp_id";

		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id($tbl_nm, $id_col, $id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Gate Pass List' => 'hrmsc/gp_list',
			'Gate Pass Add ' => 'hrmsc/gp_add?id=',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/gp_add', $data);
		$this->load->view('admin/footer');
	}

	//Gate Pass Entry
	public function gp_entry(){
		$data = array();
		$data['gp_entry'] = $this->hrmsm->gp_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/gp_list';
		$this->load->view('admin/QueryPage', $data);
	}

	/********************************************** */
	/*****************Leaves*************** */
	/********************************************** */

	//Leave Application
	public function leave_list(){
		$tbl_nm = "leave_mst";
		$data = array();
		$data['list_title'] = "Leave List";
		$data['list_url'] = "hrmsc/leave_list";
		$data['tbl_nm'] = "leave_mst";
		$data['primary_col'] = "leave_id";
		$data['edit_url'] = "hrmsc/leave_add";
		$data['edit_enable'] = "yes";

		$username = $_SESSION['username'];

		//Get EmpId
		$data['GetEmpId'] = $this->hrmsm->GetEmpId($username);

		foreach($data['GetEmpId']->result_array() AS $row){
			$emp_id = $row['emp_id'];
			$role = $row['role'];
		}

		if($role != 'Admin'){
			$where_str = "where leave_reports_to = '".$emp_id."' OR leave_emp_id = '".$emp_id."'";
			$data['where_str'] = $where_str;
		} else {
			$where_str = "";
			$data['where_str'] = $where_str;
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Leave List' => 'hrmsc/leave_list',
		);

		$data['ViewHead'] = $this->hrmsm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data);
		$this->load->view('admin/footer');
	}

	//Leave Stages
	public function leave_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Leave Report' => 'hrmsc/leave_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/leave_rpt_main', $data); 
		$this->load->view('admin/footer');	
	}

	//Leave Report
	public function leave_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Leave Report' => 'hrmsc/leave_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/leave_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	//Leave Report Ajax
	public function leave_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/leave_rpt_ajax'); 
	}

	//Leave Add
	public function leave_add(){
		$id = $_REQUEST['id'];
		$tbl_nm = "leave_mst";
		$id_col = "leave_id";

		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id($tbl_nm, $id_col, $id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Leave Stages' => 'hrmsc/leave_stages',
			'Leave Add ' => 'hrmsc/leave_add?id=',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/leave_add', $data);
		$this->load->view('admin/footer');
	}

	//Leave Allocation Ajax
	public function leave_alloc_ajax(){
		$this->load->view('admin/modules/hrms/leave_alloc_ajax'); 
	}

	//Leave Entry
	public function leave_entry(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
        // echo "cha"; die;
		$data = array();
		$data['leave_entry'] = $this->hrmsm->leave_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/leave_stages';
		$this->load->view('admin/QueryPage', $data);
	}
		
	//Leave HOD Approval
	public function leave_app_hod(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
	
		$data = array();
		$data['leave_app_hod'] = $this->hrmsm->leave_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/leave_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	//Leave HR Approval
	public function leave_app_hr(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
	   
		$data = array();
		$data['leave_app_hr'] = $this->hrmsm->leave_app_hr($data);
		$data['message'] = '';	
		$data['url'] = 'hrmsc/leave_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	
	//Leave Mangement Approval
	public function leave_app_mng(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
	   
		$data = array();
		$data['leave_app_mng'] = $this->hrmsm->leave_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/leave_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	/********************************************** */
	/*****************MissPunch*************** */
	/********************************************** */

	public function mp_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Miss Punch Stages' => 'hrmsc/mp_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mp_stages', $data); 
		$this->load->view('admin/footer');	
	}

	// Miss Punch Application
	public function miss_pun_app_list(){
		$tbl_nm = "miss_punch";
		$data = array();
		$data['list_title'] = "Mispunch List";
		$data['list_url'] = "hrmsc/miss_pun_app_list";
		$data['tbl_nm'] = "miss_punch";
		$data['primary_col'] = "miss_pun_id";
		$data['edit_url'] = "hrmsc/miss_pun_app_form";
		$data['edit_enable'] = "yes";
		$data['another_link_enable'] = 'no';

		$username = $_SESSION['username'];
		//Get EmpId
		$data['GetEmpId'] = $this->hrmsm->GetEmpId($username);

		foreach($data['GetEmpId']->result_array() AS $row){
			$emp_id = $row['emp_id'];
			$role = $row['role'];
		}

		if($role != 'Admin'){
			$where_str = "where mp_hod_id = '".$emp_id."' OR mp_emp_id = '".$emp_id."'";
			$data['where_str'] = $where_str;
		} else {
			$where_str = "";
			$data['where_str'] = $where_str;
		}


		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',			
			'Miss Punch List' => 'hrmsc/miss_pun_app_list',
		);

		$data['ViewHead'] = $this->hrmsm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');

	}

	public function miss_pun_app_form(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('miss_punch','miss_pun_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Miss Punch Stages ' => 'hrmsc/mp_stages',
			'Miss Punch Application Form' => 'hrmsc/miss_pun_app_form?id=',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/miss_pun_app_form', $data); 
		$this->load->view('admin/footer');	
	}


	public function miss_pun_entry(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");

		/*
		foreach($data['miss_pun_entry']->result_array() as $row){
			 $miss_pun_id = $row['miss_pun_id'];
			 $mp_emp_mail = $row['mp_emp_mail'];
			 $mp_hod_id = $row['mp_hod_id'];
		}

		//miss_punch_mail		
		
		$miss_pun_date = $this->input->post("miss_pun_date");
		$modified_by =  $_SESSION['username'];
		$created_by = $_SESSION['username'];		
		$miss_pun_date = $this->input->post("miss_pun_date");
		$miss_pun_type = $this->input->post("miss_pun_type");
		$mp_emp_id = $this->input->post("mp_emp_id");			
		$hod_name = $this->input->post("hod_name");
		$hod_email = $this->input->post("hod_email");
		$this->load->helper("hrms");
		$rep_email = get_rep_email($mp_hod_id);
		//echo $rep_email;
		$emp_email = get_emp_email($mp_emp_id);
		//echo $emp_email;die;
	

		$this->email->to($rep_email);			
		$this->email->from("notifications@mahaveergroup.net");
		$this->email->bcc("notifications@mahaveergroup.net");
		$subject = "Miss Punch Application";
		$this->email->subject($subject);
		$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com,sharma.char22@gmail.com";
		$this->email->cc($cc_email);

		//message
		$message_table = "
		<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black;
		font-size:11px; padding:10px; border-radius:5px;'>
		<tr style='background-color:#CFF'>
			<td><b>Miss Punch ID</b></td>
			<td><b>EMPLOYEE ID</b></td>
			<td><b>MISS PUNCH DATE</b></td>
			<td><b>HOD ID</b></td>
			<td><b>MISS PUNCH TYPE</b></td>						
		</tr>";				

		$message_table .= "
		<tr>
			<td>".$miss_pun_id."</td>
			<td>".$mp_emp_id."</td>
			<td>".$miss_pun_date."</td>
			<td>".$mp_hod_id."</td>
			<td>".$miss_pun_type."</td>							
		</tr>";					
			
		$message_table .= "</table>";

		$message = $message_table."<br/><b>Thanks & Regards,</b>
		<br><b style='text-transform:uppercase;'>WORKPLACE</b>";
 
			
		$this->email->message($message);
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		}*/
		
		$data = array();
		$data['miss_pun_entry'] = $this->hrmsm->miss_pun_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mp_stages';
		$this->load->view('admin/QueryPage', $data);
	}		

	//Miss Punch HOD Approval
	public function mp_app_hod(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$miss_pun_id = $this->input->post("miss_pun_id");		

		/* 
		foreach($data['mp_app_hod']->result_array() as $row){
			$miss_pun_date = $this->input->post("miss_pun_date");
			$modified_by =  $_SESSION['username'];
			$created_by = $_SESSION['username'];		
			$miss_pun_date = $this->input->post("miss_pun_date");
			$miss_pun_type = $this->input->post("miss_pun_type");
			$mp_emp_id = $this->input->post("mp_emp_id");			
			$hod_name = $this->input->post("hod_name");		
			$this->load->helper("hrms");
			$rep_email = get_rep_email($mp_hod_id);
			$emp_email = get_emp_email($mp_emp_id);
		}

		//leave_mail		
		$this->email->to("vijeta.yadav@mahaveergroup.net");		
		$this->email->from("notifications@mahaveergroup.net");
		$this->email->bcc('notifications@mahaveergroup.net');
		$subject = "Miss Punch pending for HR approval";
		$this->email->subject($subject);
		$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com,sharma.char22@gmail.com,'".$emp_email."'";
		$this->email->cc($cc_email);

		//message
		$message_table = "
		<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black;
			font-size:11px; padding:10px; border-radius:5px;'>
			<tr style='background-color:#CFF'>
				<td><b>Miss Punch ID</b></td>
				<td><b>EMPLOYEE ID</b></td>
				<td><b>MISS PUNCH DATE</b></td>
				<td><b>HOD ID</b></td>
				<td><b>MISS PUNCH TYPE</b></td>						
			</tr>";				

			$message_table .= "
				<tr>
					<td>".$miss_pun_id."</td>
					<td>".$mp_emp_id."</td>
					<td>".$miss_pun_date."</td>
					<td>".$mp_hod_id."</td>
					<td>".$miss_pun_type."</td>							
				</tr>";					
			
		$message_table .= "</table>";

		$message = $message_table."<br/><b>Thanks & Regards,</b>
		<br><b style='text-transform:uppercase;'>WORKPLACE</b>";
		$this->email->message($message);
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		}	   
		*/

		$data = array();
		$data['mp_app_hod'] = $this->hrmsm->mp_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mp_stages'; 
		$this->load->view('admin/QueryPage', $data);
	}

	//Miss punch HR Approval
	public function mp_app_hr(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$miss_pun_id = $this->input->post("miss_pun_id");
		
		/* 
		foreach($data['mp_app_hr']->result_array() as $row){
			$miss_pun_date = $this->input->post("miss_pun_date");
			$modified_by =  $_SESSION['username'];
			$created_by = $_SESSION['username'];		
			$miss_pun_date = $this->input->post("miss_pun_date");
			$miss_pun_type = $this->input->post("miss_pun_type");
			$mp_emp_id = $this->input->post("mp_emp_id");			
			$mp_hod_id = $this->input->post("mp_hod_id");			
			$hod_name = $this->input->post("hod_name");
			$hod_email = $this->input->post("hod_email");
			$this->load->helper("hrms");
			$rep_email = get_rep_email($mp_hod_id);
			$emp_email = get_emp_email($mp_emp_id);
		}
		
		//leave_mail	
		$this->email->to("abhishek.jain@mahaveergroup.net");		
		$this->email->from("notifications@mahaveergroup.net");
		$this->email->bcc('notifications@mahaveergroup.net');
		$subject = "Miss Punch Pending for Management approval";
		$this->email->subject($subject);
		$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com,sharma.char22@gmail.com,'".$emp_email."'";
		$this->email->cc($cc_email);

		//message
		$message_table = "
		<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black;
			font-size:11px; padding:10px; border-radius:5px;'>
			<tr style='background-color:#CFF'>
				<td><b>Miss Punch ID</b></td>
				<td><b>EMPLOYEE ID</b></td>
				<td><b>MISS PUNCH DATE</b></td>
				<td><b>HOD ID</b></td>
				<td><b>MISS PUNCH TYPE</b></td>						
			</tr>";				

			$message_table .= "
				<tr>
					<td>".$miss_pun_id."</td>
					<td>".$mp_emp_id."</td>
					<td>".$miss_pun_date."</td>
					<td>".$mp_hod_id."</td>
					<td>".$miss_pun_type."</td>							
				</tr>";					
			
		$message_table .= "</table>";

		$message = $message_table."<br/><b>Thanks & Regards,</b>
		<br><b style='text-transform:uppercase;'>WORKPLACE</b>";
		$this->email->message($message);
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		}	   
		*/

		$data = array();
		$data['mp_app_hr'] = $this->hrmsm->mp_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mp_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	//Miss punch HR Approval
	public function mp_app_mng(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		$miss_pun_id = $this->input->post("miss_pun_id");		

		/* 
		foreach($data['mp_app_mng']->result_array() as $row){
			$miss_pun_date = $this->input->post("miss_pun_date");
			$modified_by =  $_SESSION['username'];
			$created_by = $_SESSION['username'];		
			$miss_pun_date = $this->input->post("miss_pun_date");
			$miss_pun_type = $this->input->post("miss_pun_type");
			$mp_emp_id = $this->input->post("mp_emp_id");			
			$mp_hod_id = $this->input->post("mp_hod_id");			
			$hod_name = $this->input->post("hod_name");
			$hod_email = $this->input->post("hod_email");
			$this->load->helper("hrms");
			$rep_email = get_rep_email($mp_hod_id);
			$emp_email = get_emp_email($mp_emp_id);
		}	

		//leave_mail
		$this->email->to("notifications@mahaveergroup.net");		
		$this->email->from("notifications@mahaveergroup.net");
		$this->email->bcc('notifications@mahaveergroup.net');
		$subject = "Miss Punch pending for hod approval";
		$this->email->subject($subject);
		$cc_email = "notifications@mahaveergroup.net,chandra.sharmadb@gmail.com,sharma.char22@gmail.com,$emp_email";
		$this->email->cc($cc_email);

		//message
		$message_table = "
		<table cellpadding='5px' cellspacing='0' border='1' width='500px' style='border:solid 1px black;
			font-size:11px; padding:10px; border-radius:5px;'>
			<tr style='background-color:#CFF'>
				<td><b>Miss Punch ID</b></td>
				<td><b>EMPLOYEE ID</b></td>
				<td><b>MISS PUNCH DATE</b></td>
				<td><b>HOD ID</b></td>
				<td><b>MISS PUNCH TYPE</b></td>						
			</tr>";				

			$message_table .= "
				<tr>
					<td>".$miss_pun_id."</td>
					<td>".$mp_emp_id."</td>
					<td>".$miss_pun_date."</td>
					<td>".$mp_hod_id."</td>
					<td>".$miss_pun_type."</td>							
				</tr>";					
			
		$message_table .= "</table>";

		$message = $message_table."<br/><b>Thanks & Regards,</b>
		<br><b style='text-transform:uppercase;'>WORKPLACE</b>";

		$this->email->message($message);
		if(!$this->email->send()){
			echo $this->email->print_debugger();
			die;
		}	   
		 */

		$data = array();
		$data['mp_app_mng'] = $this->hrmsm->mp_app_mng($data);		
		$data['message'] = '';
		$data['url'] = 'hrmsc/mp_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	/********************************************** */
	/*****************Overtime*************** */
	/********************************************** */

	public function ot_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Over Time Stages' => 'hrmsc/ot_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/ot_rpt_main', $data); 
		$this->load->view('admin/footer');	
	}

	//Overtime Report
	public function ot_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Leave Report' => 'hrmsc/ot_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/ot_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	//Overtime Report Ajax
	public function ot_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/ot_rpt_ajax'); 
	}
	
	//Overtime Application List
	public function over_time_list(){
		$tbl_nm = "over_time";
		$data = array();
		$data['list_title'] = "Over Time List";
		$data['list_url'] = "hrmsc/over_time_list";
		$data['tbl_nm'] = "over_time";
		$data['primary_col'] = "over_tim_id";
		$data['edit_url'] = "hrmsc/over_time";
		$data['edit_enable'] = "yes";
		$data['another_link_enable'] = 'no';

		$username = $_SESSION['username'];
		//Get EmpId
		$data['GetEmpId'] = $this->hrmsm->GetEmpId($username);

		foreach($data['GetEmpId']->result_array() AS $row){
			$emp_id = $row['emp_id'];
			$role = $row['role'];
		}

		if($role != 'Admin'){
			$where_str = "where ot_hod_id = '".$emp_id."' OR ot_emp_id = '".$emp_id."'";
			$data['where_str'] = $where_str;
		} else {
			$where_str = "";
			$data['where_str'] = $where_str;
		}


		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',			
			'Over Time List' => 'hrmsc/over_tim_list',
		);

		$data['ViewHead'] = $this->hrmsm->ListHead($tbl_nm);
		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');

	}	

	public function over_time(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('over_time','over_tim_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Over Time Stages' => 'hrmsc/ot_stages',
			'Over Time Application Form' => 'hrmsc/over_time?id=',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/over_time', $data); 
		$this->load->view('admin/footer');	
	}

	//Overtime Entry
	public function over_time_entry(){
		$this->load->library('email');
		$this->email->set_mailtype("html");
		$this->load->helper("hrms");
		
		$data = array();
		$data['over_time_entry'] = $this->hrmsm->over_time_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/ot_rpt_main';
		$this->load->view('admin/QueryPage', $data);
	}

	//Over Time HOD Approval
	public function ot_app_hod(){
		$data = array();
		$data['ot_app_hod'] = $this->hrmsm->ot_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/ot_rpt_main';
		$this->load->view('admin/QueryPage', $data);
	}

	//Over Time HR Approval
	public function ot_app_hr(){
		$data = array();
		$data['ot_app_hr'] = $this->hrmsm->ot_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/ot_rpt_main';
		$this->load->view('admin/QueryPage', $data);
	}

	//Over Time Management Approval
	public function ot_app_mng(){
		$data = array();
		$data['ot_app_mng'] = $this->hrmsm->ot_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/ot_rpt_main';
		$this->load->view('admin/QueryPage', $data);
	}

	//Employee Wise Reports To Master
	public function emp_rep_to_mst(){
		$this->load->view('admin/modules/hrms/emp_rep_to_mst'); 
	}

	/********************************************** */
	/*****************Salary Advance*************** */
	/********************************************** */
	//Salary Advance Stages
	public function sa_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Salary Advance Stages' => 'hrmsc/sa_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sa_stages', $data); 
		$this->load->view('admin/footer');	
	}

	//Salary Advance Stages All
	public function sa_stages_all(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Salary Advance Stages' => 'hrmsc/sa_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sa_stages_all', $data); 
		$this->load->view('admin/footer');	
	}

	//Salary Advance List
	public function sal_adv_list(){
		$tbl_nm = "salary_adv";
		$data = array();
		$data['list_title'] = "Salary Advance List";
		$data['list_url'] = "hrmsc/sal_adv_list";
		$data['tbl_nm'] = "salary_adv";
		$data['primary_col'] = "sal_adv_id";
		$data['edit_url'] = "hrmsc/sal_adv_add";
		$data['edit_enable'] = "yes";
		
		$data['ViewHead'] = $this->hrmsm->ListHead($tbl_nm);

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'HRMS Dashboard' => 'hrmsc', 
			'Salary Advance List' => 'hrmsc/sal_adv_list',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/ListView', $data); 
		$this->load->view('admin/footer');

	}
	
	//Salary Advance Add
	public function sal_adv_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('salary_adv','sal_adv_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Salary Advance' => 'hrmsc/sa_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_adv_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Salary Advance Ajax
	public function sal_adv_cal(){
		$this->load->view('admin/modules/hrms/sal_adv_cal');
	}

	//Salary Advance Entry
	public function sal_adv_entry(){
		$data = array();
		$data['sal_adv_entry'] = $this->hrmsm->sal_adv_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	//Salary Advance HOD Approval
	public function sa_app_hod(){
		$data = array();
		$data['sa_app_hod'] = $this->hrmsm->sa_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Salary Advance HR Approval
	public function sa_app_hr(){
		$data = array();
		$data['sa_app_hr'] = $this->hrmsm->sa_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//Salary Advance Management Approval
	public function sa_app_mng(){
		$data = array();
		$data['sa_app_mng'] = $this->hrmsm->sa_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Salary Advance Management Approval
	public function sa_app_pay(){
		$data = array();
		$data['sa_app_pay'] = $this->hrmsm->sa_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Salary Advance Report
	public function sal_adv_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Salary Advance Report' => 'hrmsc/sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_adv_rpt', $data); 
		$this->load->view('admin/footer');
	}

	//Salary Advance Report Ajax
	public function sal_adv_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/sal_adv_rpt_ajax'); 
	}

	/********************************** */
	/*******SPCL Salary Advance******** */
	/********************************** */
	//Special Salary Advance Stages
	public function spcl_sa_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Special Salary Advance Stages' => 'hrmsc/spcl_sa_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/spcl_sa_stages', $data); 
		$this->load->view('admin/footer');	
	}
	
	//Special Salary Advance Add
	public function spcl_sal_adv_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('spcl_salary_adv','sal_adv_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Special Salary Advance Stages' => 'hrmsc/spcl_sa_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/spcl_sal_adv_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Special Salary Advance Ajax
	public function spcl_sal_adv_cal(){
		$this->load->view('admin/modules/hrms/spcl_sal_adv_cal');
	}

	//Special Salary Advance Entry
	public function spcl_sal_adv_entry(){
		$data = array();
		$data['spcl_sal_adv_entry'] = $this->hrmsm->spcl_sal_adv_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/spcl_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data); 	
	}
		
	//Special Salary Advance Management Approval
	public function spcl_sa_app_mng(){
		$data = array();
		$data['spcl_sa_app_mng'] = $this->hrmsm->spcl_sa_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/spcl_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Special Salary Advance Payment
	public function spcl_sa_app_pay(){
		$data = array();
		$data['spcl_sa_app_pay'] = $this->hrmsm->spcl_sa_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/spcl_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Special Salary Advance Report
	public function spcl_sal_adv_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Special Salary Advance Report' => 'hrmsc/spcl_sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/spcl_sal_adv_rpt', $data); 
		$this->load->view('admin/footer');
	}

	//Special Salary Advance Report Ajax
	public function spcl_sal_adv_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/spcl_sal_adv_rpt_ajax'); 
	}

	/***************************************************** */
	/*******Paper Cup Salary Advance********************** */
	/***************************************************** */

	//Paper Cup Advance Add
	public function pcpb_sal_adv_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('salary_adv_pcpb','sal_adv_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Paper Cup Advance' => 'hrmsc/pcpb_sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pcpb_sal_adv_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Paper Cup Advance Ajax
	public function pcpb_sal_adv_cal(){
		$this->load->view('admin/modules/hrms/pcpb_sal_adv_cal');
	}

	//Paper Cup Advance Entry
	public function pcpb_sal_adv_entry(){
		$data = array();
		$data['pcpb_sal_adv_entry'] = $this->hrmsm->pcpb_sal_adv_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pcpb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	//Paper Cup Advance HOD Approval
	public function pcpb_sa_app_hod(){
		$data = array();
		$data['pcpb_sa_app_hod'] = $this->hrmsm->pcpb_sa_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pcpb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Paper Cup Advance HR Approval
	public function pcpb_sa_app_hr(){
		$data = array();
		$data['pcpb_sa_app_hr'] = $this->hrmsm->pcpb_sa_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pcpb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//Paper Cup Advance Management Approval
	public function pcpb_sa_app_mng(){
		$data = array();
		$data['pcpb_sa_app_mng'] = $this->hrmsm->pcpb_sa_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pcpb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Paper Cup Advance Management Approval
	public function pcpb_sa_app_pay(){
		$data = array();
		$data['pcpb_sa_app_pay'] = $this->hrmsm->pcpb_sa_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pcpb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Paper Cup Advance Report
	public function pcpb_sal_adv_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Paper Cup & Paper Blank Salary Advance Report' => 'hrmsc/pcpb_sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pcpb_sal_adv_rpt', $data); 
		$this->load->view('admin/footer');
	}

	//Paper Cup Advance Report Ajax
	public function pcpb_sal_adv_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/pcpb_sal_adv_rpt_ajax'); 
	}

	/***************************************************** */
	/*******Paper Blank Advance******** */
	/***************************************************** */
	//Paper Blank Advance Add
	public function pb_sal_adv_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('salary_adv_pb','sal_adv_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Paper Blank Advance' => 'hrmsc/pb_sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pb_sal_adv_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Paper Blank Advance Ajax
	public function pb_sal_adv_cal(){
		$this->load->view('admin/modules/hrms/pb_sal_adv_cal');
	}

	//Paper Blank Advance Entry
	public function pb_sal_adv_entry(){
		$data = array();
		$data['pb_sal_adv_entry'] = $this->hrmsm->pb_sal_adv_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data); 	
	}
	
	//Paper Blank Advance HOD Approval
	public function pb_sa_app_hod(){
		$data = array();
		$data['pb_sa_app_hod'] = $this->hrmsm->pb_sa_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Paper Blank Advance HR Approval
	public function pb_sa_app_hr(){
		$data = array();
		$data['pb_sa_app_hr'] = $this->hrmsm->pb_sa_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//Paper Blank Advance Management Approval
	public function pb_sa_app_mng(){
		$data = array();
		$data['pb_sa_app_mng'] = $this->hrmsm->pb_sa_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Paper Blank Advance Management Approval
	public function pb_sa_app_pay(){
		$data = array();
		$data['pb_sa_app_pay'] = $this->hrmsm->pb_sa_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pb_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Paper Blank Advance Report
	public function pb_sal_adv_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Paper Blank Advance Report' => 'hrmsc/pb_sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pb_sal_adv_rpt', $data); 
		$this->load->view('admin/footer');
	}

	//Paper Blank Advance Report Ajax
	public function pb_sal_adv_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/pb_sal_adv_rpt_ajax'); 
	}



	/******************************************** */
	/*******Payment Request/Return Module******** */
	/******************************************** */
	//Payment Request / Return Stages
	public function pr_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Payment Request / Return Stages' => 'hrmsc/pr_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pr_stages', $data); 
		$this->load->view('admin/footer');	
	}
	
	//Payment Request / Return Add
	public function pr_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('pr_mst','pr_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Payment Request / Return Stages' => 'hrmsc/pr_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pr_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Payment Request / Return Entry
	public function pr_entry(){
		$data = array();
		$data['pr_entry'] = $this->hrmsm->pr_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pr_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}
		
	//Payment Request / Return Management Approval
	public function pr_app_mng(){
		$data = array();
		$data['pr_app_mng'] = $this->hrmsm->pr_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pr_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	//Payment Request / Return Payment
	public function pr_app_pay(){
		//Attachment Code Starts
		$filename = strtolower($_FILES["cash_att"]["name"]);
		
		//File Attachment
		if( $filename !== ""){
			$config['upload_path']   = './uploads/'; 
			$config['allowed_types'] = 'gif|jpg|jpeg|png|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|txt|';		
			$RandNumber = rand(0, 9999999999); //Random number to make each filename unique.
			$fileExe  = substr($filename, strrpos($filename,'.'));
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$file = basename($filename, ".".$ext);		
			$NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($file));
			$NewFileName2 = $NewFileName.'_'.$RandNumber.".".$ext;
			$config['file_name'] = $NewFileName2;
			$config['log_threshold'] = 1;
			$config['overwrite'] = false;
			$config['remove_spaces'] = true;
			
			$this->load->library('upload', $config);			
		   
			if (!$this->upload->do_upload('cash_att')) {
			   $error = array('error' => $this->upload->display_errors());
			}else { 
			   $data = array('upload_data' => $this->upload->data());
			   $file_name = $data['upload_data']['file_name'];
			   rename("./uploads/$file_name","./uploads/$NewFileName2");
			}
		}

		$data = array();
		$data['pr_app_pay'] = $this->hrmsm->pr_app_pay($data, $NewFileName2);
		$data['message'] = '';
		$data['url'] = 'hrmsc/pr_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	/**************************************************** */
	/*******Housekeeping & Construction Labour DR******** */
	/**************************************************** */
	//HK & CL DR Stages
	public function hkcl_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'HK & CL Stages' => 'hrmsc/hkcl_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/hkcl_stages', $data); 
		$this->load->view('admin/footer');	
	}
	
	//HK & CL DR Add
	public function hkcl_dr_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('hkcl_dr_mst','hkcl_dr_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'HK & CL Stages' => 'hrmsc/hkcl_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/hkcl_dr_add', $data); 
		$this->load->view('admin/footer');	
	}

	//HK & CL DR Entry
	public function hkcl_dr_entry(){
		$data = array();
		$data['hkcl_dr_entry'] = $this->hrmsm->hkcl_dr_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/hkcl_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}
		
	//HK & CL DR Management Approval
	public function hkcl_dr_app_mng(){
		$data = array();
		$data['hkcl_dr_app_mng'] = $this->hrmsm->hkcl_dr_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/hkcl_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	/********************** */
	/*******Penalty******** */
	/********************** */
	public function penalty_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Penalty Stages' => 'hrmsc/penalty_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/penalty_stages', $data); 
		$this->load->view('admin/footer');	
	}

	//Penalty Add
	public function penalty_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('penalty','penalty_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Penalty' => 'hrmsc/penalty_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/penalty_add', $data); 
		$this->load->view('admin/footer');
	}

	//Penalty Entry
	public function penalty_entry(){
		$data = array();
		$data['penalty_entry'] = $this->hrmsm->penalty_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/penalty_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Penalty HR Approval
	public function penalty_app_hr(){
		$data = array();
		$data['penalty_app_hr'] = $this->hrmsm->penalty_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/penalty_stages';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//Penalty Management Approval
	public function penalty_app_mng(){
		$data = array();
		$data['penalty_app_mng'] = $this->hrmsm->penalty_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/penalty_stages';
		$this->load->view('admin/QueryPage', $data);
	}


	/************************** */
	/*******Adjustments******** */
	/************************** */
	//Adjustment Stages
	public function adjustments_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Adjustment Stages' => 'hrmsc/adjustments_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/adjustments_stages', $data); 
		$this->load->view('admin/footer');	
	}

	//Adjustments Form
	public function adjustments_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('adjustments','adjustments_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Adjustment Stages' => 'hrmsc/adjustments_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/adjustments_add', $data); 
		$this->load->view('admin/footer');
	}

	//Adjustments Entry
	public function adjustments_entry(){
		$data = array();
		$data['adjustments_entry'] = $this->hrmsm->adjustments_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/adjustments_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Adjustments HR Approval
	public function adjustments_app_hr(){
		$data = array();
		$data['adjustments_app_hr'] = $this->hrmsm->adjustments_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/adjustments_stages';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//Adjustments Management Approval
	public function adjustments_app_mng(){
		$data = array();
		$data['adjustments_app_mng'] = $this->hrmsm->adjustments_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/adjustments_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	//Overtime Report For Overtime Employees Fixed OT
	public function fixed_ot_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Fixed Overtime List' => 'hrmsc/fixed_ot_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/fixed_ot_main', $data); 
		$this->load->view('admin/footer');
	}

	public function fixed_ot_ajax(){	
		$this->load->view('admin/modules/hrms/fixed_ot_ajax'); 
	}

	/******************************** */
	/***********Daily Report********* */
	/******************************** */

	//DR Stages
	public function dr_stages(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'DR Form' => 'hrmsc/dr_stages',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/dr_stages', $data); 
		$this->load->view('admin/footer');
	}

	//DR Form
	public function dr_form(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('dr_hrms_mst','dr_id',$id);
		}

		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'DR Stages' => 'hrmsc/dr_stages', 			
			'DR Form' => 'hrmsc/dr_form',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/dr_form', $data); 
		$this->load->view('admin/footer');
	}

	//DR Entry
	public function dr_entry(){
		$data = array();
		$data['dr_entry'] = $this->hrmsm->dr_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/dr_stages';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//DR HOD Approval
	public function dr_app_hod(){
		$data = array();
		$data['dr_app_hod'] = $this->hrmsm->dr_app_hod($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/dr_stages';
		$this->load->view('admin/QueryPage', $data);
	}

	//DR HR Approval
	public function dr_app_hr(){
		$data = array();
		$data['dr_app_hr'] = $this->hrmsm->dr_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/dr_stages';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//DR Management Approval
	public function dr_app_mng(){
		$data = array();
		$data['dr_app_mng'] = $this->hrmsm->dr_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/dr_stages';
		$this->load->view('admin/QueryPage', $data);
	}



	/************************************** */
	/***********Tea Payment Report********* */
	/************************************** */
	public function tea_pay_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Tea Payment Report' => 'hrmsc/tea_pay_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/tea_pay_main', $data); 
		$this->load->view('admin/footer');
	}

	public function tea_pay_ajax(){	
		$this->load->view('admin/modules/hrms/tea_pay_ajax'); 
	}

	/************************************** */
	/***********PF Report********* */
	/************************************** */
	public function pf_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'PF Report' => 'hrmsc/pf_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pf_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	public function pf_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/pf_rpt_ajax'); 
	}

	/************************************** */
	/***********ESIC Report********* */
	/************************************** */
	public function esic_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'ESIC Report' => 'hrmsc/esic_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/esic_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	public function esic_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/esic_rpt_ajax'); 
	}

	/************************************** */
	/***********Salary Approval************ */
	/************************************** */
	public function sal_app_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Salary Approval' => 'hrmsc/sal_app_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_app_main', $data); 
		$this->load->view('admin/footer');
	}

	public function sal_app_ajax(){	
		$this->load->view('admin/modules/hrms/sal_app_ajax'); 
	}

	public function sal_app_mgmt(){
		$data = array();
		$data['sal_app_mgmt'] = $this->hrmsm->sal_app_mgmt($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_app_main';
		$this->load->view('admin/QueryPage', $data);
	}

	public function sal_app_pay(){
		$data = array();
		$data['sal_app_pay'] = $this->hrmsm->sal_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/sal_app_main';
		$this->load->view('admin/QueryPage', $data);
	}

	public function ot_app_mgmt(){
		$data = array();
		$data['ot_app_mgmt'] = $this->hrmsm->ot_app_mgmt($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/fixed_ot_main';
		$this->load->view('admin/QueryPage', $data);
	}

	public function ot_app_pay(){
		$data = array();
		$data['ot_app_pay'] = $this->hrmsm->ot_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/fixed_ot_main';
		$this->load->view('admin/QueryPage', $data);
	}

	/************************************** */
	/***********Ledger************ */
	/************************************** */
	public function ledger_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Ledger' => 'hrmsc/ledger_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/ledger_main', $data); 
		$this->load->view('admin/footer');
	}

	public function ledger_ajax(){	
		$this->load->view('admin/modules/hrms/ledger_ajax'); 
	}

	/************************************** */
	/***********DR Tour Report************ */
	/************************************** */
	public function dr_tour_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'DR Tour Report' => 'hrmsc/dr_tour_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/dr_tour_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	public function dr_tour_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/dr_tour_rpt_ajax'); 
	}

	/******************************************* */
	/***********Counter Sheet Report************ */
	/******************************************* */
	public function counter_sheet_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Counter Sheet' => 'hrmsc/counter_sheet_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/counter_sheet_main', $data); 
		$this->load->view('admin/footer');
	}

	public function counter_sheet_ajax(){	
		$this->load->view('admin/modules/hrms/counter_sheet_ajax'); 
	}

	public function counter_sheet_det(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Counter Sheet Details' => 'hrmsc/counter_sheet_det',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/counter_sheet_det', $data); 
		$this->load->view('admin/footer');
	}

	/******************************************* */
	/***********PNI Salary Report************ */
	/******************************************* */
	public function pni_sal_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'PNI Counter Sheet(ON)' => 'hrmsc/pni_sal_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pni_sal_main', $data); 
		$this->load->view('admin/footer');
	}

	public function pni_sal_ajax(){	
		$this->load->view('admin/modules/hrms/pni_sal_ajax'); 
	}

	/******************************************* */
	/***********MDPL Salary Sheet Report************ */
	/******************************************* */
	public function mdpl_sal_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MDPL Counter Sheet(ON)' => 'hrmsc/mdpl_sal_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mdpl_sal_main', $data); 
		$this->load->view('admin/footer');
	}

	public function mdpl_sal_ajax(){	
		$this->load->view('admin/modules/hrms/mdpl_sal_ajax'); 
	}

	/******************************************* */
	/***********HK&CL Report************ */
	/******************************************* */
	public function hkcl_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'HKCL Report' => 'hrmsc/hkcl_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/hkcl_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	public function hkcl_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/hkcl_rpt_ajax'); 
	}

	/********************************************** */
	/***********Paper Cup Salary Report************ */
	/********************************************** */
	public function pc_cont_sal_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Paper Cup Salary' => 'hrmsc/pc_cont_sal_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pc_cont_sal_main', $data); 
		$this->load->view('admin/footer');
	}

	public function pc_cont_sal_ajax(){	
		$this->load->view('admin/modules/hrms/pc_cont_sal_ajax'); 
	}

	/************************************************ */
	/***********Paper Blank Salary Report************ */
	/************************************************ */
	public function pb_cont_sal_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Paper Blank Salary' => 'hrmsc/pb_cont_sal_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/pb_cont_sal_main', $data); 
		$this->load->view('admin/footer');
	}

	public function pb_cont_sal_ajax(){	
		$this->load->view('admin/modules/hrms/pb_cont_sal_ajax'); 
	}

	/************************************************ */
	/***********Employee Details********************* */
	/************************************************ */
	public function emp_det_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Employee Details' => 'hrmsc/emp_det_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/emp_det_main', $data); 
		$this->load->view('admin/footer');
	}

	public function emp_det_ajax(){	
		$this->load->view('admin/modules/hrms/emp_det_ajax'); 
	}

	/************************************************ */
	/***********Negative Salary Report ************** */
	/************************************************ */
	public function neg_sal_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Negative Salary Report' => 'hrmsc/neg_sal_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/neg_sal_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	public function neg_sal_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/neg_sal_rpt_ajax'); 
	}

	/************************************************ */
	/***********Leave Balance Report ************** */
	/************************************************ */
	public function lv_bal_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Leave Balance Report' => 'hrmsc/lv_bal_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/lv_bal_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	public function lv_bal_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/lv_bal_rpt_ajax'); 
	}

	/********************************** */
	/*******Arrear Module************** */
	/********************************** */	
	//Arrear Add
	public function arrear_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('arrear','arrear_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Arrear Add' => 'hrmsc/arrear_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/arrear_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Arrear Entry
	public function arrear_entry(){
		$data = array();
		$data['arrear_entry'] = $this->hrmsm->arrear_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/arrear_rpt_main';
		$this->load->view('admin/QueryPage', $data); 	
	}
		
	//Arrear Management Approval
	public function arrear_app_mng(){
		$data = array();
		$data['arrear_app_mng'] = $this->hrmsm->arrear_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/arrear_rpt_main';
		$this->load->view('admin/QueryPage', $data);
	}

	//Arrear Report
	public function arrear_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Arrear Report' => 'hrmsc/arrear_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/arrear_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	//Arrear Report Ajax
	public function arrear_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/arrear_rpt_ajax'); 
	}

	/********************************** */
	/*******Deductions Module********** */
	/********************************** */	
	//Deductions Add
	public function ded_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('deductions','ded_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Deductions Add' => 'hrmsc/ded_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/ded_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Deductions Entry
	public function ded_entry(){
		$data = array();
		$data['ded_entry'] = $this->hrmsm->ded_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/ded_rpt_main';
		$this->load->view('admin/QueryPage', $data); 	
	}
		
	//Deductions Management Approval
	public function ded_app_mng(){
		$data = array();
		$data['ded_app_mng'] = $this->hrmsm->ded_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/ded_rpt_main';
		$this->load->view('admin/QueryPage', $data);
	}

	//Deductions Report
	public function ded_rpt_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Deductions Report' => 'hrmsc/ded_rpt_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/ded_rpt_main', $data); 
		$this->load->view('admin/footer');
	}

	//Deductions Report Ajax
	public function ded_rpt_ajax(){	
		$this->load->view('admin/modules/hrms/ded_rpt_ajax'); 
	}

	/**********************************************/
	/************Salary Slip Main************** */
	/******************************************** */

	//Salary Slip
	public function sal_slip_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Salary Slip' => 'hrmsc/sal_slip_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_slip_main', $data); 
		$this->load->view('admin/footer');
	}

	//Salary Slip Ajax
	public function sal_slip_ajax(){	
		$this->load->view('admin/modules/hrms/sal_slip_ajax'); 
	}


	/**********************************************/
	/************Mahaveer Poly Pack************** */
	/******************************************** */

	public function Att_Card_Mpp(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Attendance Card' => 'hrmsc/Att_Card_Mpp',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/Att_Card_Mpp',$data); 
		$this->load->view('admin/footer');
	}

	public function Att_Card_Mpp_Ajax(){ 
		$this->load->view('admin/modules/hrms/Att_Card_Mpp_Ajax'); 
	}

	//Monthly Attendence Report MPP
	public function monthly_att_rpt_mpp(){ 
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 
			'Monthly Attendence Report' => 'hrmsc/monthly_att_rpt_mpp',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/monthly_att_rpt_mpp',$data); 
		$this->load->view('admin/footer');
	}

	//Monthly Attendence Report Ajax MPP
	public function monthly_att_rpt_ajax_mpp(){ 
		$this->load->view('admin/modules/hrms/monthly_att_rpt_ajax_mpp'); 
	}


	//Salary Sheet Daily MPP
	public function sal_sheet_daily_mpp(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Salary Sheet Daily MPP' => 'hrmsc/sal_sheet_daily_mpp',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_sheet_daily_mpp',$data); 
		$this->load->view('admin/footer');
	}

	//Salary Sheet Monthly Ajax MPP
	public function sal_sheet_daily_ajax_mpp(){
		$this->load->view('admin/modules/hrms/sal_sheet_daily_ajax_mpp'); 
	}

	//Salary Sheet Monthly MPP
	public function sal_sheet_monthly_mpp(){
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard',
			'Salary Sheet Monthly MPP' => 'hrmsc/sal_sheet_monthly_mpp',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_sheet_monthly_mpp',$data); 
		$this->load->view('admin/footer');
	}

	//Salary Sheet Monthly Ajax MPP
	public function sal_sheet_monthly_ajax_mpp(){
		$this->load->view('admin/modules/hrms/sal_sheet_monthly_ajax_mpp'); 
	}

	//Salary Advance Sheet MPP
	public function sal_adv_sheet_mpp(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Salary Advance List' => 'hrmsc/sal_adv_sheet_mpp',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/sal_adv_sheet_mpp', $data); 
		$this->load->view('admin/footer');
	}

	/********************************************************* */
	/***************MPP Production & Others******************* */
	/********************************************************* */
	//Employee Add
	public function mpp_prod_emp_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('mpp_prod_oth_emp_mst','emp_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Prod. Employee Add' => 'hrmsc/mpp_prod_emp_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mpp_prod_emp_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Employee Entry
	public function mpp_prod_emp_entry(){
		$data = array();
		$data['mpp_prod_emp_entry'] = $this->hrmsm->mpp_prod_emp_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mpp_prod_emp_rpt';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Employee Report
	public function mpp_prod_emp_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Production Employees' => 'hrmsc/mpp_prod_emp_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mpp_prod_emp_rpt', $data); 
		$this->load->view('admin/footer');
	}

	//Employee Report Ajax
	public function mpp_prod_emp_rpt_ajax(){		
		$this->load->view('admin/modules/hrms/mpp_prod_emp_rpt_ajax'); 
	}

	public function mpp_prod_sal_adv_add(){
		$id = $_REQUEST['id'];
		if($id != ""){
			$data['get_by_id'] = $this->hrmsm->get_by_id('sal_adv_mpp_prod','sal_adv_id',$id);
		}
		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Prod. Salary Advance Add' => 'hrmsc/mpp_prod_sal_adv_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mpp_prod_sal_adv_add', $data); 
		$this->load->view('admin/footer');	
	}

	//Salary Advance Entry
	public function mpp_prod_sal_adv_entry(){
		$data = array();
		$data['mpp_prod_sal_adv_entry'] = $this->hrmsm->mpp_prod_sal_adv_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mpp_prod_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data); 	
	}

	//Salary Advance HR Approval
	public function mpp_prod_sa_app_hr(){
		$data = array();
		$data['mpp_prod_sa_app_hr'] = $this->hrmsm->mpp_prod_sa_app_hr($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mpp_prod_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}
	
	//Salary Advance Management Approval
	public function mpp_prod_sa_app_mng(){
		$data = array();
		$data['mpp_prod_sa_app_mng'] = $this->hrmsm->mpp_prod_sa_app_mng($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mpp_prod_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//Salary Advance Management Approval
	public function mpp_prod_sa_app_pay(){
		$data = array();
		$data['mpp_prod_sa_app_pay'] = $this->hrmsm->mpp_prod_sa_app_pay($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mpp_prod_sal_adv_rpt';
		$this->load->view('admin/QueryPage', $data);
	}

	//MPP Prod Salary Advance
	public function mpp_prod_sal_adv_rpt(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Prod Salary Advance' => 'hrmsc/mpp_prod_sal_adv_rpt',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mpp_prod_sal_adv_rpt', $data); 
		$this->load->view('admin/footer');
	}

	//MPP Prod Salary Advance Ajax
	public function mpp_prod_sal_adv_rpt_ajax(){		
		$this->load->view('admin/modules/hrms/mpp_prod_sal_adv_rpt_ajax'); 
	}

	//MPP Prod Salary Add
	public function mpp_prod_sal_add(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Prod Salary Add' => 'hrmsc/mpp_prod_sal_add',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mpp_prod_sal_add', $data); 
		$this->load->view('admin/footer');
	}

	//MPP Prod Salary Add Ajax
	public function mpp_prod_sal_add_ajax(){		
		$this->load->view('admin/modules/hrms/mpp_prod_sal_add_ajax'); 
	}

	//MPP Prod Salary Entry
	public function mpp_prod_sal_entry(){
		$data = array();
		$data['mpp_prod_sal_entry'] = $this->hrmsm->mpp_prod_sal_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/mpp_prod_sal_add';
		$this->load->view('admin/QueryPage', $data); 	
	}

	/************************************************ */
	/***********MPP Production Salary Report************ */
	/************************************************ */
	public function mpp_prod_sal_main(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'MPP Production Salary' => 'hrmsc/mpp_prod_sal_main',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/mpp_prod_sal_main', $data); 
		$this->load->view('admin/footer');
	}

	public function mpp_prod_sal_ajax(){	
		$this->load->view('admin/modules/hrms/mpp_prod_sal_ajax'); 
	}

	/******Regular Relaxation******** */
	public function reg_relax(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Regular Relaxation' => 'hrmsc/reg_relax',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/reg_relax', $data); 
		$this->load->view('admin/footer');
	}

	public function reg_relax_entry(){
		$data = array();
		$data['reg_relax_entry'] = $this->hrmsm->reg_relax_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/reg_relax';
		$this->load->view('admin/QueryPage', $data); 	
	}

	/******Occassional Relaxation******** */
	public function occ_relax(){		
		//BreadCrumb
		$data['breadcrumb'] = 
		array(
			'Master Dashboard' => 'welcome/dashboard', 			
			'Occassional Relaxation' => 'hrmsc/occ_relax',
		);

		$this->load->view('admin/header');
		$this->load->view('admin/modules/hrms/occ_relax', $data); 
		$this->load->view('admin/footer');
	}

	public function occ_relax_entry(){
		$data = array();
		$data['occ_relax_entry'] = $this->hrmsm->occ_relax_entry($data);
		$data['message'] = '';
		$data['url'] = 'hrmsc/occ_relax';
		$this->load->view('admin/QueryPage', $data); 	
	}
}
