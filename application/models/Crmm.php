<?php
class Crmm extends CI_Model{  
	function __construct(){   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm where Field not in('password','admin_pass')");
		return $query;
	}

	public function get_inq_by_id($inq_no){
		$query = $this->db->query("select * from crm_inq_mst where inq_no = '".$inq_no."'");
		return $query;
	}

	//Inquiry Entry
	public function inquiry_entry($data, $NewFileName2){    
		$username = $_SESSION['username'];
		$inq_no = $this->input->post("inq_no");
		$inq_no1 = $this->input->post("inq_no");

		if($inq_no == ""){
			$sql_enq_cnt = "select count(*) as count from crm_inq_mst where substring(inq_no,11,4) = '".date("Y")."'";
			$qry_enq_cnt = $this->db->query($sql_enq_cnt)->row();
			$count = $qry_enq_cnt->count;

			if($count == 0){
				//SVIPL-INQ-2020-00001;
				$inq_no = "SVIPL-INQ-".date("Y")."-".sprintf('%05d', 1);
			} else {
				$sql_enq_max = "select max(substring(inq_no,16,5)) as prev_no from crm_inq_mst 
				where substring(inq_no,11,4) = '".date("Y")."'";
				
				$qry_enq_max = $this->db->query($sql_enq_max)->row();
				$prev_no = $qry_enq_max->prev_no;
				$new_no = $prev_no+1;
				
				$inq_no = "SVIPL-INQ-".date("Y")."-".sprintf('%05d', $new_no);
			}
		}

		$inq_rec_by = $this->input->post("inq_rec_by");
		$inq_rec_on = $this->input->post("inq_rec_on");
		$inq_source = $this->input->post("inq_source");
		$inq_cust_nm  = $this->input->post("inq_cust_nm");
		$inq_cust_type = $this->input->post("inq_cust_type");
		$inq_add = $this->input->post("inq_add");
		$inq_add_dist  = $this->input->post("inq_add_dist");
		$inq_add_state = $this->input->post("inq_add_state");
		$inq_add_pin = $this->input->post("inq_add_pin");
		$inq_folup_date = $this->input->post("inq_folup_date");
		$inq_status = "Fresh Inquiry";

		$inq_contact_person = $this->input->post("inq_contact_person");
		$inq_email1 = $this->input->post("inq_email1");
		$inq_email2 = $this->input->post("inq_email2");
		$inq_mob1 = $this->input->post("inq_mob1");
		$inq_mob2 = $this->input->post("inq_mob2");
		$inq_landline = $this->input->post("inq_landline");
		$inq_turnky_sol = $this->input->post("inq_turnky_sol");
		$inq_turnky_sol_pkg = $this->input->post("inq_turnky_sol_pkg");
		$inq_turnky_sol_rmk = $this->input->post("inq_turnky_sol_rmk");
		$inq_spares = $this->input->post("inq_spares");
		$inq_lead_priority = $this->input->post("inq_lead_priority");
		$inq_lead_owner = $this->input->post("inq_lead_owner");
		$inq_lead_rmk = $this->input->post("inq_lead_rmk");
		
		//Turnkey Solutions
		$inq_plant_spec = $this->input->post("inq_plant_spec");
		$inq_max_cap = $this->input->post("inq_max_cap");
		$wheat_atta = $this->input->post("wheat_atta");
		$wheat_daliya = $this->input->post("wheat_daliya");
		$wheat_maida = $this->input->post("wheat_maida");
		$spice_chilly = $this->input->post("spice_chilly");
		$spice_turmeric = $this->input->post("spice_turmeric");
		$spice_coriander = $this->input->post("spice_coriander");
		$gram_besan = $this->input->post("gram_besan");
		$custom_req = $this->input->post("custom_req");
		$inq_tksol_rmks = $this->input->post("inq_tksol_rmks");

		//Items Details
		$inq_itm_id = $this->input->post("inq_itm_id");
		$inq_itm_qty = $this->input->post("inq_itm_qty");
		$arr_cnt = count($inq_itm_id);

		//Conversations
		$inq_last_conv = $this->input->post("inq_last_conv");
		$inq_conv_date = $this->input->post("inq_conv_date");
		$arr_cnt_conv = count($inq_last_conv);
		
		//Transaction Start
		$this->db->trans_start();

		if($inq_no1 == ""){
			//Item Details Main
			$sql = $this->db->query("insert into crm_inq_mst(inq_no, inq_rec_by, inq_rec_on, inq_source, 
			inq_cust_nm, inq_cust_type, inq_add, inq_add_dist, inq_add_state, inq_add_pin, 
			inq_folup_date, inq_status, 
			inq_contact_person, inq_email1, inq_email2, inq_mob1, 
			inq_mob2, inq_landline, inq_turnky_sol, inq_turnky_sol_pkg, 
			inq_turnky_sol_rmk, inq_spares, inq_lead_priority, inq_lead_owner, 
			inq_lead_rmk, inq_last_conv, inq_conv_date, inq_file_att,
			inq_plant_spec, inq_max_cap, wheat_atta, wheat_daliya, 
			wheat_maida, spice_chilly, spice_turmeric, spice_coriander, 
			gram_besan, custom_req, inq_tksol_rmks) 
			values 
			('".$inq_no."', '".$inq_rec_by."', '".$inq_rec_on."', '".$inq_source."', 
			'".$inq_cust_nm."', '".$inq_cust_type."', '".$inq_add."', '".$inq_add_dist."', '".$inq_add_state."', '".$inq_add_pin."', 
			'".$inq_folup_date."', '".$inq_status."',
			'".$inq_contact_person."','".$inq_email1."','".$inq_email2."','".$inq_mob1."',
			'".$inq_mob2."','".$inq_landline."','".$inq_turnky_sol."','".$inq_turnky_sol_pkg."',
			'".$inq_turnky_sol_rmk."','".$inq_spares."','".$inq_lead_priority."','".$inq_lead_owner."',
			'".$inq_lead_rmk."','".$inq_last_conv."','".$inq_conv_date."','".$NewFileName2."',
			'".$inq_plant_spec."', '".$inq_max_cap."', '".$wheat_atta."', '".$wheat_daliya."', 
			'".$wheat_maida."', '".$spice_chilly."', '".$spice_turmeric."', '".$spice_coriander."', 
			'".$gram_besan."', '".$custom_req."', '".$inq_tksol_rmks."')");

			//Item Details
			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = $this->db->query("insert into crm_inq_itm_details(inq_no, inq_itm_id, inq_itm_qty, inq_itm_createdby) 
				values ('".$inq_no."', '".$inq_itm_id[$i]."', '".$inq_itm_qty[$i]."', '".$inq_rec_by."')");
			}

			//Conversation Details
			for($j=0; $j<$arr_cnt_conv; $j++){
				$sql_conv_ins = $this->db->query("insert into crm_inq_conv(inq_no, inq_conv, inq_conv_date) 
				values('".$inq_no."','".$inq_last_conv[$j]."', '".$inq_conv_date[$j]."')");
			}


		} else {

			$sql = $this->db->query("update crm_inq_mst set inq_source = '".$inq_source."', inq_cust_nm = '".$inq_cust_nm."', 
			inq_cust_type = '".$inq_cust_type."', inq_add = '".$inq_add."', inq_add_dist = '".$inq_add_dist."', 
			inq_add_state = '".$inq_add_state."', inq_add_pin = '".$inq_add_pin."', inq_folup_date = '".$inq_folup_date."',
			inq_status = '".$inq_status."', inq_contact_person = '".$inq_contact_person."',inq_email1 = '".$inq_email1."',
			inq_email2 = '".$inq_email2."', inq_mob1 = '".$inq_mob1."', inq_mob2 = '".$inq_mob2."', inq_landline = '".$inq_landline."',
			inq_turnky_sol = '".$inq_turnky_sol."', inq_turnky_sol_pkg = '".$inq_turnky_sol_pkg."', inq_turnky_sol_rmk = '".$inq_turnky_sol_rmk."',
			inq_spares = '".$inq_spares."',inq_lead_priority = '".$inq_lead_priority."', inq_lead_owner = '".$inq_lead_owner."', 
			inq_lead_rmk = '".$inq_lead_rmk."',inq_last_conv = '".$inq_last_conv."', inq_file_att = '".$NewFileName2."',
			inq_plant_spec = '".$inq_plant_spec."', inq_max_cap = '".$inq_max_cap."', wheat_atta = '".$wheat_atta."', wheat_daliya = '".$wheat_daliya."', 
			wheat_maida = '".$wheat_maida."', spice_chilly = '".$spice_chilly."', spice_turmeric = '".$spice_turmeric."', spice_coriander = '".$spice_coriander."', 
			gram_besan = '".$gram_besan."', custom_req = '".$custom_req."', inq_tksol_rmks = '".$inq_tksol_rmks."'
			where inq_no = '".$inq_no."'");

			//Item Details
			$sql_itm_cnt = "select count(*) as cnt from crm_inq_itm_details where inq_no = '".$inq_no."'";
			$qry_itm_cnt = $this->db->query($sql_itm_cnt)->row();
			$cnt = $qry_itm_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = $this->db->query("delete from crm_inq_itm_details where inq_no = '".$inq_no."'");

				for($i=0; $i<$arr_cnt; $i++){
					$sql_itm_ins = $this->db->query("insert into crm_inq_itm_details(inq_no, inq_itm_id, inq_itm_qty, inq_itm_createdby) 
					values ('".$inq_no."', '".$inq_itm_id[$i]."', '".$inq_itm_qty[$i]."', '".$inq_rec_by."')");
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){
					$sql_itm_ins = $this->db->query("insert into crm_inq_itm_details(inq_no, inq_itm_id, inq_itm_qty, inq_itm_createdby) 
					values ('".$inq_no."', '".$inq_itm_id[$i]."', '".$inq_itm_qty[$i]."', '".$inq_rec_by."')");

				}
			}

			//Conversation Details
			$sql_itm_cnt = "select count(*) as cnt from crm_inq_conv where inq_no = '".$inq_no."'";
			$qry_itm_cnt = $this->db->query($sql_itm_cnt)->row();
			$cnt = $qry_itm_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = $this->db->query("delete from crm_inq_conv where inq_no = '".$inq_no."'");

				for($j=0; $j<$arr_cnt_conv; $j++){
					$sql_conv_ins = $this->db->query("insert into crm_inq_conv(inq_no, inq_conv, inq_conv_date) 
					values('".$inq_no."','".$inq_last_conv[$j]."', '".$inq_conv_date[$j]."')");
				}
			} else {
				for($j=0; $j<$arr_cnt_conv; $j++){
					$sql_conv_ins = $this->db->query("insert into crm_inq_conv(inq_no, inq_conv, inq_conv_date) 
					values('".$inq_no."','".$inq_last_conv[$j]."', '".$inq_conv_date[$j]."')");
				}
			}
		}

		$this->db->trans_complete();
		//Transanction Complete
	}

	//First Lvl Quote Entry
	public function fst_lvl_entry($data, $NewFileName2){    
		$inq_no = $this->input->post("inq_no");
		$fst_lvl_quoteby = $_SESSION['username'];
		$fst_lvl_quotedate = date("Y-m-d h:i:s");
		$inq_status = "First Level Quotation Approval L1";
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set fst_lvl_quote = '".$NewFileName2."', fst_lvl_quoteby = '".$fst_lvl_quoteby."',
		fst_lvl_quotedate = '".$fst_lvl_quotedate."', inq_status = '".$inq_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$sql_quote = "insert into crm_inq_quote_att(inq_no, quote_lvl, file_name, quote_by, quote_date)
		values('".$inq_no."','First Level','".$NewFileName2."','".$fst_lvl_quoteby."','".$fst_lvl_quotedate."')";

		$qry_quote = $this->db->query($sql_quote);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//CRM Quote Approval L1
	public function quote_app_l1_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$quote_app_rmks_l1 = $this->input->post("app_rmks");
		$quote_app_l1_inst = $this->input->post("quote_app_l1_inst");
		$quote_app_l1_by = $_SESSION['username'];
		$quote_app_l1_date = date("Y-m-d h:i:s");

		//Get Previous Status
		$sql_status = "select * from crm_inq_mst where inq_no = '".$inq_no."'";
		$qry_status = $this->db->query($sql_status)->row();

		$prev_status = $qry_status->inq_status;

		//Transaction Start
		$this->db->trans_start();

		if($quote_app_l1_inst == "Approve"){

			if($prev_status == "First Level Quotation Approval L1"){
			
				$inq_status = "First Level Quotation Approval L2";
	
				$sql = "update crm_inq_mst set fst_lvl_quote_app_rmks_l1 = '".$quote_app_rmks_l1."', 
				fst_lvl_quote_app_l1_inst = '".$quote_app_l1_inst."', fst_lvl_quote_app_l1_by = '".$quote_app_l1_by."',
				fst_lvl_quote_app_l1_date = '".$quote_app_l1_date."', inq_status = '".$inq_status."'
				where inq_no = '".$inq_no."'";
	
			} else if($prev_status == "Second Level Quotation Approval L1"){
				
				$inq_status = "Second Level Quotation Approval L2";
	
				$sql = "update crm_inq_mst set second_lvl_quote_app_rmks_l1 = '".$quote_app_rmks_l1."', 
				second_lvl_quote_app_l1_inst = '".$quote_app_l1_inst."', second_lvl_quote_app_l1_by = '".$quote_app_l1_by."',
				second_lvl_quote_app_l1_date = '".$quote_app_l1_date."', inq_status = '".$inq_status."'
				where inq_no = '".$inq_no."'";
	
			} else {
				
				$inq_status = "Third Level Quotation Approval L2";
	
				$sql = "update crm_inq_mst set third_lvl_quote_app_rmks_l1 = '".$quote_app_rmks_l1."', 
				third_lvl_quote_app_l1_inst = '".$quote_app_l1_inst."', third_lvl_quote_app_l1_by = '".$quote_app_l1_by."',
				third_lvl_quote_app_l1_date = '".$quote_app_l1_date."', inq_status = '".$inq_status."'
				where inq_no = '".$inq_no."'";
			}

		} else {

			if($prev_status == "First Level Quotation Approval L1"){
			
				$inq_status = "First Level Quotation Disapproved L1";
	
				$sql = "update crm_inq_mst set fst_lvl_quote_app_rmks_l1 = '".$quote_app_rmks_l1."', 
				fst_lvl_quote_app_l1_inst = '".$quote_app_l1_inst."', fst_lvl_quote_app_l1_by = '".$quote_app_l1_by."',
				fst_lvl_quote_app_l1_date = '".$quote_app_l1_date."', inq_status = '".$inq_status."'
				where inq_no = '".$inq_no."'";
	
			} else if($prev_status == "Second Level Quotation Approval L1"){
				
				$inq_status = "Second Level Quotation Disapproved L1";
	
				$sql = "update crm_inq_mst set second_lvl_quote_app_rmks_l1 = '".$quote_app_rmks_l1."', 
				second_lvl_quote_app_l1_inst = '".$quote_app_l1_inst."', second_lvl_quote_app_l1_by = '".$quote_app_l1_by."',
				second_lvl_quote_app_l1_date = '".$quote_app_l1_date."', inq_status = '".$inq_status."'
				where inq_no = '".$inq_no."'";
	
			} else {
				
				$inq_status = "Third Level Quotation Disapproved L1";
	
				$sql = "update crm_inq_mst set third_lvl_quote_app_rmks_l1 = '".$quote_app_rmks_l1."', 
				third_lvl_quote_app_l1_inst = '".$quote_app_l1_inst."', third_lvl_quote_app_l1_by = '".$quote_app_l1_by."',
				third_lvl_quote_app_l1_date = '".$quote_app_l1_date."', inq_status = '".$inq_status."'
				where inq_no = '".$inq_no."'";
			}

		}

		$this->db->query($sql);
		$this->db->trans_complete();
		//Transanction Complete
	}

	//CRM Quote Approval L2
	public function quote_app_l2_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$quote_app_rmks_l2 = $this->input->post("app_rmks");
		$quote_app_l2_inst = $this->input->post("quote_app_l2_inst");;
		$quote_app_l2_by = $_SESSION['username'];
		$quote_app_l2_date = date("Y-m-d h:i:s");

		//Get Previous Status
		$sql_status = "select * from crm_inq_mst where inq_no = '".$inq_no."'";
		$qry_status = $this->db->query($sql_status)->row();

		$prev_status = $qry_status->inq_status;

		//Transaction Start
		$this->db->trans_start();

		if($quote_app_l2_inst == "Approve"){

			if($prev_status == "First Level Quotation Approval L2"){
			
				$inq_status = "Technical Discussion";
	
				$sql = "update crm_inq_mst set fst_lvl_quote_app_rmks_l2 = '".$quote_app_rmks_l2."', 
				fst_lvl_quote_app_l2_inst = '".$quote_app_l2_inst."', fst_lvl_quote_app_l2_by = '".$quote_app_l2_by."',
				fst_lvl_quote_app_l2_date = '".$quote_app_l2_date."', inq_status = '".$inq_status."' where inq_no = '".$inq_no."'";
	
			} else if($prev_status == "Second Level Quotation Approval L2"){
				
				$inq_status = "Third Level Quotation";
	
				$sql = "update crm_inq_mst set second_lvl_quote_app_rmks_l2 = '".$quote_app_rmks_l2."', 
				second_lvl_quote_app_l2_inst = '".$quote_app_l2_inst."', second_lvl_quote_app_l2_by = '".$quote_app_l2_by."',
				second_lvl_quote_app_l2_date = '".$quote_app_l2_date."', inq_status = '".$inq_status."' where inq_no = '".$inq_no."'";
	
			} else {
				
				$inq_status = "PO Received";
	
				$sql = "update crm_inq_mst set third_lvl_quote_app_rmks_l2 = '".$quote_app_rmks_l2."', 
				third_lvl_quote_app_l2_inst = '".$quote_app_l2_inst."', third_lvl_quote_app_l2_by = '".$quote_app_l2_by."',
				third_lvl_quote_app_l2_date = '".$quote_app_l2_date."', inq_status = '".$inq_status."' where inq_no = '".$inq_no."'";
	
			}

		} else {

			if($prev_status == "First Level Quotation Approval L2"){
			
				$inq_status = "First Level Quotation Disapproved L2";
	
				$sql = "update crm_inq_mst set fst_lvl_quote_app_rmks_l2 = '".$quote_app_rmks_l2."', 
				fst_lvl_quote_app_l2_inst = '".$quote_app_l2_inst."', fst_lvl_quote_app_l2_by = '".$quote_app_l2_by."',
				fst_lvl_quote_app_l2_date = '".$quote_app_l2_date."', inq_status = '".$inq_status."' where inq_no = '".$inq_no."'";
	
			} else if($prev_status == "Second Level Quotation Approval L2"){
				
				$inq_status = "Second Level Quotation Disapproved L2";
	
				$sql = "update crm_inq_mst set second_lvl_quote_app_rmks_l2 = '".$quote_app_rmks_l2."', 
				second_lvl_quote_app_l2_inst = '".$quote_app_l2_inst."', second_lvl_quote_app_l2_by = '".$quote_app_l2_by."',
				second_lvl_quote_app_l2_date = '".$quote_app_l2_date."', inq_status = '".$inq_status."' where inq_no = '".$inq_no."'";
	
			} else {
				
				$inq_status = "Third Level Quotation Disapproved L2";
	
				$sql = "update crm_inq_mst set third_lvl_quote_app_rmks_l2 = '".$quote_app_rmks_l2."', 
				third_lvl_quote_app_l2_inst = '".$quote_app_l2_inst."', third_lvl_quote_app_l2_by = '".$quote_app_l2_by."',
				third_lvl_quote_app_l2_date = '".$quote_app_l2_date."', inq_status = '".$inq_status."' where inq_no = '".$inq_no."'";
	
			}

		}

		

		$this->db->query($sql);
		$this->db->trans_complete();
		//Transanction Complete
	}

	//CRM Quote Technical Discussion Entry
	public function quote_tech_dis_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$tech_dis_rmks = $this->input->post("tech_dis_rmks");;
		$tech_dis_by = $_SESSION['username'];
		$tech_dis_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set tech_dis_rmks = '".$tech_dis_rmks."', tech_dis_by = '".$tech_dis_by."',
		tech_dis_date = '".$tech_dis_date."', inq_status = '".$change_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//CRM Quote Initiation Facility Visit Entry
	public function quote_iffv_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$quote_iffv_rmks = $this->input->post("quote_iffv_rmks");;
		$quote_iffv_by = $_SESSION['username'];
		$quote_iffv_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set quote_iffv_rmks = '".$quote_iffv_rmks."', quote_iffv_by = '".$quote_iffv_by."',
		quote_iffv_date = '".$quote_iffv_date."', inq_status = '".$change_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//CRM Quote Initiation Facility Visit Entry
	public function visit_awaited_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$visit_awaited_rmks = $this->input->post("visit_awaited_rmks");;
		$visit_awaited_by = $_SESSION['username'];
		$visit_awaited_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set visit_awaited_rmks = '".$visit_awaited_rmks."', visit_awaited_by = '".$visit_awaited_by."',
		visit_awaited_date = '".$visit_awaited_date."', inq_status = '".$change_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Second Lvl Quote Entry
	public function second_lvl_entry($data, $NewFileName2){    
		$inq_no = $this->input->post("inq_no");
		$second_lvl_quoteby = $_SESSION['username'];
		$second_lvl_quotedate = date("Y-m-d h:i:s");
		$inq_status = "Second Level Quotation Approval L1";
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set second_lvl_quote = '".$NewFileName2."', second_lvl_quoteby = '".$second_lvl_quoteby."',
		second_lvl_quotedate = '".$second_lvl_quotedate."', inq_status = '".$inq_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$sql_quote = "insert into crm_inq_quote_att(inq_no, quote_lvl, file_name, quote_by, quote_date)
		values('".$inq_no."','Second Level','".$NewFileName2."','".$second_lvl_quoteby."','".$second_lvl_quotedate."')";

		$qry_quote = $this->db->query($sql_quote);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Third Lvl Quote Entry
	public function third_lvl_entry($data, $NewFileName2){    
		$inq_no = $this->input->post("inq_no");
		$third_lvl_quoteby = $_SESSION['username'];
		$third_lvl_quotedate = date("Y-m-d h:i:s");
		$inq_status = "Third Level Quotation Approval L1";
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set third_lvl_quote = '".$NewFileName2."', third_lvl_quoteby = '".$third_lvl_quoteby."',
		third_lvl_quotedate = '".$third_lvl_quotedate."', inq_status = '".$inq_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$sql_quote = "insert into crm_inq_quote_att(inq_no, quote_lvl, file_name, quote_by, quote_date)
		values('".$inq_no."','Third Level','".$NewFileName2."','".$third_lvl_quoteby."','".$third_lvl_quotedate."')";

		$qry_quote = $this->db->query($sql_quote);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//PO Received
	public function po_received_entry($data, $NewFileName2){    
		$inq_no = $this->input->post("inq_no");
		$po_rec_by = $_SESSION['username'];
		$po_rec_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$po_rec_rmks = $this->input->post("po_rec_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set att_po = '".$NewFileName2."', po_rec_rmks = '".$po_rec_rmks."', 
		po_rec_by = '".$po_rec_by."', po_rec_date = '".$po_rec_date."', inq_status = '".$change_status."'
		where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Lead On Hold Entry
	public function lead_on_hold_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$lead_hold_by = $_SESSION['username'];
		$lead_hold_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$lead_hold_rmks = $this->input->post("lead_hold_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set lead_hold_rmks = '".$lead_hold_rmks."', 
		lead_hold_by = '".$lead_hold_by."', lead_hold_date = '".$lead_hold_date."', 
		inq_status = '".$change_status."' where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Closed Lost Entry
	public function closed_lost_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$closed_lost_by = $_SESSION['username'];
		$closed_lost_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$closed_lost_rmks = $this->input->post("closed_lost_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set closed_lost_rmks = '".$closed_lost_rmks."', 
		closed_lost_by = '".$closed_lost_by."', closed_lost_date = '".$closed_lost_date."', 
		inq_status = '".$change_status."' where inq_no = '".$inq_no."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Closed Lost Entry
	public function lead_recycled_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$lead_recycled_by = $_SESSION['username'];
		$lead_recycled_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$lead_recycled_rmks = $this->input->post("lead_recycled_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set lead_recycled_rmks = '".$lead_recycled_rmks."', 
		lead_recycled_by = '".$lead_recycled_by."', lead_recycled_date = '".$lead_recycled_date."', 
		inq_status = '".$change_status."' where inq_no = '".$inq_no."'";
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Lead Dropped Entry
	public function lead_dropped_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$lead_dropped_by = $_SESSION['username'];
		$lead_dropped_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$lead_dropped_rmks = $this->input->post("lead_dropped_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set lead_dropped_rmks = '".$lead_dropped_rmks."', 
		lead_dropped_by = '".$lead_dropped_by."', lead_dropped_date = '".$lead_dropped_date."', 
		inq_status = '".$change_status."' where inq_no = '".$inq_no."'";
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Refer To Dealer Entry
	public function ref_to_dealer_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$ref_to_dealer_by = $_SESSION['username'];
		$ref_to_dealer_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$ref_to_dealer_rmks = $this->input->post("ref_to_dealer_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set ref_to_dealer_rmks = '".$ref_to_dealer_rmks."', 
		ref_to_dealer_by = '".$ref_to_dealer_by."', ref_to_dealer_date = '".$ref_to_dealer_date."', 
		inq_status = '".$change_status."' where inq_no = '".$inq_no."'";
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	//Interested In Dealership Entry
	public function inst_dealership_entry($data){    
		$inq_no = $this->input->post("inq_no");
		$inst_dealership_by = $_SESSION['username'];
		$inst_dealership_date = date("Y-m-d h:i:s");
		$change_status = $this->input->post("change_status");
		$inst_dealership_rmks = $this->input->post("inst_dealership_rmks");
		
		
		//Transaction Start
		$this->db->trans_start();

		$sql = "update crm_inq_mst set inst_dealership_rmks = '".$inst_dealership_rmks."', 
		inst_dealership_by = '".$inst_dealership_by."', inst_dealership_date = '".$inst_dealership_date."', 
		inq_status = '".$change_status."' where inq_no = '".$inq_no."'";
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	public function api_det_entry($resp){
		$this->load->helper('crm');

		$arr_cnt = count($resp);
		$date = date("Y-m-d");

		//Transaction Start
		//$this->db->trans_start();

		for($i=0;$i<$arr_cnt;$i++){
			$inq_no = get_max_inqno();

			//Fetching Data From API
			$qry_ins = "insert into api_resp_im(inq_no,QUERY_ID, QTYPE, SENDERNAME, 
			SENDEREMAIL, SUBJECT, DATE_RE, DATE_R, 
			DATE_TIME_RE, GLUSR_USR_COMPANYNAME, READ_STATUS, SENDER_GLUSR_USR_ID, 
			MOB, COUNTRY_FLAG, QUERY_MODID, LOG_TIME, 
			QUERY_MODREFID, DIR_QUERY_MODREF_TYPE, ORG_SENDER_GLUSR_ID, ENQ_MESSAGE, 
			ENQ_ADDRESS, ENQ_CALL_DURATION, ENQ_RECEIVER_MOB, ENQ_CITY, 
			ENQ_STATE, PRODUCT_NAME, COUNTRY_ISO, EMAIL_ALT, 
			MOBILE_ALT, PHONE, PHONE_ALT, IM_MEMBER_SINCE, 
			TOTAL_COUNT)
			values('".$inq_no."', '".$resp[$i]['QUERY_ID']."','".$resp[$i]['QTYPE']."','".$resp[$i]['SENDERNAME']."',
			'".$resp[$i]['SENDEREMAIL']."','".$resp[$i]['SUBJECT']."','".$resp[$i]['DATE_RE']."','".$resp[$i]['DATE_R']."',
			'".$resp[$i]['DATE_TIME_RE']."','".$resp[$i]['GLUSR_USR_COMPANYNAME']."','".$resp[$i]['READ_STATUS']."','".$resp[$i]['SENDER_GLUSR_USR_ID']."',
			'".$resp[$i]['MOB']."','".$resp[$i]['COUNTRY_FLAG']."','".$resp[$i]['QUERY_MODID']."','".$resp[$i]['LOG_TIME']."',
			'".$resp[$i]['QUERY_MODREFID']."','".$resp[$i]['DIR_QUERY_MODREF_TYPE']."','".$resp[$i]['ORG_SENDER_GLUSR_ID']."','".$resp[$i]['ENQ_MESSAGE']."',
			'".$resp[$i]['ENQ_ADDRESS']."','".$resp[$i]['ENQ_CALL_DURATION']."','".$resp[$i]['ENQ_RECEIVER_MOB']."','".$resp[$i]['ENQ_CITY']."',
			'".$resp[$i]['ENQ_STATE']."','".$resp[$i]['PRODUCT_NAME']."','".$resp[$i]['COUNTRY_ISO']."','".$resp[$i]['EMAIL_ALT']."',
			'".$resp[$i]['MOBILE_ALT']."','".$resp[$i]['PHONE']."','".$resp[$i]['PHONE_ALT']."','".$resp[$i]['IM_MEMBER_SINCE']."',
			'".$resp[$i]['TOTAL_COUNT']."')";

			$this->db->query($qry_ins);

			$sql_ins_crm = "insert into crm_inq_mst(query_id, inq_no, inq_rec_by, 
			inq_source, inq_status,
			inq_rec_on, inq_contact_person, inq_email1, 
			inq_cust_nm, inq_mob1, inq_cust_type, 
			inq_lead_rmk, inq_add, inq_add_dist, 
			inq_add_state, inq_email2, inq_mob2, inq_landline)
			values('".$resp[$i]['QUERY_ID']."', '".$inq_no."', 'CHOYAL GROUP', 
			'Indiamart', 'Fresh Inquiry',
			'".$date."', '".$resp[$i]['SENDERNAME']."', '".$resp[$i]['SENDEREMAIL']."',
			'".$resp[$i]['GLUSR_USR_COMPANYNAME']."', '".$resp[$i]['MOB']."', '".$resp[$i]['QUERY_MODID']."',
			'".$resp[$i]['ENQ_MESSAGE']."', '".$resp[$i]['ENQ_ADDRESS']."', '".$resp[$i]['ENQ_CITY']."',
			'".$resp[$i]['ENQ_STATE']."', '".$resp[$i]['EMAIL_ALT']."', '".$resp[$i]['MOBILE_ALT']."', '".$resp[$i]['PHONE']."')";

			$this->db->query($sql_ins_crm);
		}

		//Deleting Duplicate Entries api_resp_im
		$sql_del = "DELETE t1 FROM api_resp_im t1 INNER JOIN api_resp_im t2 
		WHERE t1.id < t2.id AND t1.QUERY_ID = t2.QUERY_ID AND t1.QUERY_ID != ''";
		
		$this->db->query($sql_del);

		//Deleting Duplicate Entries crm_inq_mst
		$sql_del1 = "DELETE t1 FROM crm_inq_mst t1 INNER JOIN crm_inq_mst t2 
		WHERE t1.id < t2.id AND t1.QUERY_ID = t2.QUERY_ID AND t1.QUERY_ID != ''";
		
		$this->db->query($sql_del1);

		//Updating Actual Date
		$sql_updt_dt = "update crm_inq_mst 
		inner join api_resp_im on api_resp_im.query_id = crm_inq_mst.query_id
		set crm_inq_mst.inq_rec_on = DATE_FORMAT(STR_TO_DATE(api_resp_im.DATE_R, '%d-%M-%y'), '%Y-%m-%d')";

		$this->db->query($sql_updt_dt);

		//$this->db->trans_complete();
		//Transanction Complete
	}

	public function ti_api_entry($resp){
		$this->load->helper('crm');

		$arr_cnt = count($resp);
		$date = date("Y-m-d");

		//Transaction Start
		//$this->db->trans_start();

		for($i=0;$i<$arr_cnt;$i++){
			$inq_no = get_max_inqno();

			//Fetching Data From API
			$qry_ins = "insert into api_resp_ti(inq_no, query_id, receiver_uid, sender, generated_time, 
			sender_state, generated, sender_city, message, 
			sender_country, sender_mobile, view_status, receiver_name, 
			ago_time, sender_co, receiver_co, sender_name, 
			inquiry_type, generated_date, source, sender_uid, 
			subject, receiver_mobile, sender_email, month_slot, 
			rfi_id)
			values('".$inq_no."','".$resp[$i]['sender_uid']."','".$resp[$i]['receiver_uid']."', '".$resp[$i]['sender']."', '".$resp[$i]['generated_time']."',
			'".$resp[$i]['sender_state']."', '".$resp[$i]['generated']."', '".$resp[$i]['sender_city']."', '".$resp[$i]['message']."',
			'".$resp[$i]['sender_country']."', '".$resp[$i]['sender_mobile']."', '".$resp[$i]['view_status']."', '".$resp[$i]['receiver_name']."',
			'".$resp[$i]['ago_time']."', '".$resp[$i]['sender_co']."', '".$resp[$i]['receiver_co']."', '".$resp[$i]['sender_name']."',
			'".$resp[$i]['inquiry_type']."', '".$resp[$i]['generated_date']."', '".$resp[$i]['source']."', '".$resp[$i]['sender_uid']."',
			'".$resp[$i]['subject']."', '".$resp[$i]['receiver_mobile']."', '".$resp[$i]['sender_email']."', '".$resp[$i]['month_slot']."',
			'".$resp[$i]['rfi_id']."')";

			$this->db->query($qry_ins);

			//Inserting Records in CRM Inq Mst
			$sql_ins_crm = "insert into crm_inq_mst(inq_no, inq_rec_by, query_id,
			inq_source, inq_status,
			inq_rec_on, inq_contact_person, inq_email1, 
			inq_cust_nm, inq_mob1, 
			inq_lead_rmk, inq_add, inq_add_dist, 
			inq_add_state)
			values('".$inq_no."', 'CHOYAL GROUP', '".$resp[$i]['sender_uid']."',  
			'Tradeindia', 'Fresh Inquiry',
			'".$date."', '".$resp[$i]['sender_name']."', '".$resp[$i]['sender_email']."',
			'".$resp[$i]['sender_co']."', '".$resp[$i]['sender_mobile']."',
			'".$resp[$i]['message']."', '".$resp[$i]['ENQ_ADDRESS']."', '".$resp[$i]['sender_city']."',
			'".$resp[$i]['sender_state']."')";

			$this->db->query($sql_ins_crm);
		}

		//Deleting Duplicate Entries api_resp_ti
		$sql_del = "DELETE t1 FROM api_resp_ti t1 INNER JOIN api_resp_ti t2 
		WHERE t1.id < t2.id AND t1.query_id = t2.query_id AND t1.query_id != ''";
		
		$this->db->query($sql_del);

		//Deleting Duplicate Entries crm_inq_mst
		$sql_del1 = "DELETE t1 FROM crm_inq_mst t1 INNER JOIN crm_inq_mst t2 
		WHERE t1.id < t2.id AND t1.query_id = t2.query_id AND t1.query_id != ''";
		
		$this->db->query($sql_del1);

		//$this->db->trans_complete();
		//Transanction Complete
	}

	//Pending Follow Up Details
	public function follow_up_inq($date){
		$query = $this->db->query("select * from crm_inq_mst where inq_folup_date = '".$date."'");
		
		return $query;
	}
}  
?>