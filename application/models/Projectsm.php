<?php
class Projectsm extends CI_Model{  
      function __construct(){   
         parent::__construct();  
      }

	  //Inquiry Entry
	  public function inquiry_entry($data){    
		$username = $_SESSION['username'];

		$sql_enq_cnt = "select count(*) as count from inq_mst";
		$qry_enq_cnt = $this->db->query($sql_enq_cnt)->row();
		$count = $qry_enq_cnt->count;

		if($count == 0){
			//SVIPL-INQ-2020-00001;
			$inq_no = "SVIPL-INQ-".date("Y")."-".sprintf('%05d', 1);
		} else {
			$sql_enq_max = "select max(substring(inq_no,16,5)) as prev_no from inq_mst";
			$qry_enq_max = $this->db->query($sql_enq_max)->row();
			$prev_no = $qry_enq_max->prev_no;
			$new_no = $prev_no+1;
			
			$inq_no = "SVIPL-INQ-".date("Y")."-".sprintf('%05d', $new_no);
		}

		$inq_rec_by = $this->input->post("inq_rec_by");
		$inq_rec_on = $this->input->post("inq_rec_on");
		$inq_source = $this->input->post("inq_source");
		$inq_comp = $this->input->post("inq_comp");
		$inq_type = $this->input->post("inq_type");
		$inq_cust_type = $this->input->post("inq_cust_type");
		$inq_add_line1 = $this->input->post("inq_add_line1");
		$inq_add_line2 = $this->input->post("inq_add_line2");
		$inq_add_dist  = $this->input->post("inq_add_dist");
		$inq_add_pin = $this->input->post("inq_add_pin");
		$inq_add_state = $this->input->post("inq_add_state");
		$inq_cust_nm  = $this->input->post("inq_cust_nm");
		$inq_cust_email1 = $this->input->post("inq_cust_email1");
		$inq_cust_email2 = $this->input->post("inq_cust_email2");
		$inq_cust_mob1 = $this->input->post("inq_cust_mob1");
		$inq_cust_mob2 = $this->input->post("inq_cust_mob2");
		$inq_landline = $this->input->post("inq_landline");
		$inq_turnkey_sol = $this->input->post("inq_turnkey_sol");
		$inq_turnkey_package = $this->input->post("inq_turnkey_package");
		$inq_prod_rmk = $this->input->post("inq_prod_rmk");
		$inq_lead_prior = $this->input->post("inq_lead_prior");
		$inq_lead_owner = $this->input->post("inq_lead_owner");
		$inq_lead_rmk  = $this->input->post("inq_lead_rmk");

		//Transaction Start
		$this->db->trans_start();

		$sql = "insert into inq_mst(inq_no, inq_rec_by, inq_rec_on, inq_source, 
		inq_comp, inq_type, inq_cust_type, inq_add_line1, inq_add_line2, inq_add_dist, 
		inq_add_pin, inq_add_state, inq_cust_nm, inq_cust_email1, inq_cust_email2, inq_cust_mob1, 
		inq_cust_mob2, inq_landline, inq_turnkey_sol, inq_turnkey_package, inq_prod_rmk, inq_lead_prior, 
		inq_lead_owner, inq_lead_rmk) 
		values 
		('".$inq_no."', '".$inq_rec_by."', '".$inq_rec_on."', '".$inq_source."', 
		'".$inq_comp."', '".$inq_type."', '".$inq_cust_type."', '".$inq_add_line1."', '".$inq_add_line2."', '".$inq_add_dist."', 
		'".$inq_add_pin."', '".$inq_add_state."', '".$inq_cust_nm."', '".$inq_cust_email1."', '".$inq_cust_email2."', '".$inq_cust_mob1."', 
		'".$inq_cust_mob2."', '".$inq_landline."', '".$inq_turnkey_sol."', '".$inq_turnkey_package."', '".$inq_prod_rmk."', '".$inq_lead_prior."', 
		'".$inq_lead_owner."', '".$inq_lead_rmk."')";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function get_inq_by_id($inq_no){
		 $query = $this->db->query("select * from inq_mst where inq_no = '".$inq_no."'");
		 return $query;
	 }

	 public function get_inq_conby_id($inq_no){
		$query = $this->db->query("select * from inq_contacts where inquiry_id = '".$inq_no."'");
		return $query;
	 }

	 public function inquiry_contact_entry(){
		$inquiry_id = $this->input->post("inq_no");
		$created_by = $this->input->post("created_by");
		$name = $this->input->post("name");
		$department = $this->input->post("dept");
		$phone = $this->input->post("phone");
		$count_arr = count($name);

		//Transaction Start
		$this->db->trans_start();

		
		$sql_prev_ent = "select count(*) as cnt1 from inq_contacts inq_contacts where inquiry_id = '$inquiry_id'";
		$qry_prev_ent = $this->db->query($sql_prev_ent)->row();
		$cnt1 = $qry_prev_ent->cnt1;

		if($cnt1 > 0){
			$sql_del_prev = "delete from inq_contacts where inquiry_id = '$inquiry_id'";
			$this->db->query($sql_del_prev);
		}
		

		if($count_arr > 0){
			for($i=0; $i<$count_arr; $i++){
				$sql = "insert into inq_contacts(inquiry_id, name, department, phone, created_by) values 
				('".$inquiry_id."', '".$name[$i]."', '".$department[$i]."', '".$phone[$i]."', '".$created_by."')";
	
				$this->db->query($sql);
			}
		}

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 function ListHead($tbl_nm){
        $query = $this->db->query("SHOW columns FROM $tbl_nm where Field not in('password','admin_pass')");

        return $query;
	}
	
	//Machines
	public function get_mac_by_id($mac_id){
		$query = $this->db->query("select * from machine_mst where machine_id = '".$mac_id."'");
		return $query;
	}

	//Mac Entry
	public function mac_entry($data){

		$machine_name = $this->input->post("pr_mac_name");
		$machine_desc = $this->input->post("pr_mac_desc");
		$machine_active = 1;

		//Transaction Start
		$this->db->trans_start();

		$sql = "insert into machine_mst(machine_name, machine_desc, machine_active) 
		values 
		('".$machine_name."', '".$machine_desc."', '".$machine_active."')";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	

	//Manpower
	public function get_mp_by_id($mp_id){
		$query = $this->db->query("select * from manpower_mst where mp_id = '".$mp_id."'");
		return $query;
	}

	//Manpower Entry
	public function mp_entry($data, $NewFileName2, $NewFileName22){
		$mp_id = $this->input->post("mp_id");
		$mp_name = $this->input->post("pr_mp_name");
		$mp_desc = $this->input->post("pr_mp_desc");
		$mp_active = 1;

		//Transaction Start
		$this->db->trans_start();

		if($mp_id != ""){

			$sql = "update manpower_mst set mp_name = '".$mp_name."', mp_desc = '".$mp_desc."', mp_pan = '".$NewFileName2."',
			mp_adhar = '".$NewFileName22."'
			where mp_id = '".$mp_id."'";

		} else {

			$sql = "insert into manpower_mst(mp_name, mp_desc, mp_pan, mp_adhar, mp_active) values 
			('".$mp_name."', '".$mp_desc."', '".$NewFileName2."', '".$NewFileName22."', '".$mp_active."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Manpower Entry
	public function pqm_entry($data, $NewFileName2){
		$pqm_id = $this->input->post("pqm_id");
		$pqm_name = $this->input->post("pqm_name");
		$username = $_SESSION['username'];
		$pqm_status = "1";

		//Transaction Start
		$this->db->trans_start();

		if($pqm_id != ""){

			$sql = "update pqm_mst set pqm_name = '".$pqm_name."', pqm_attachment = '".$pqm_attachment."',
			pqm_createdby = '".$pqm_createdby."', pqm_status = '".$pqm_status."'
			where pqm_id = '".$pqm_id."'";

		} else {

			$sql = "insert into pqm_mst(pqm_name, pqm_attachment, pqm_createdby, pqm_status) values 
			('".$pqm_name."', '".$NewFileName2."', '".$username."', '".$pqm_status."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function get_pqm_by_id($pqm_id){
		$query = $this->db->query("select * from pqm_mst where pqm_id = '".$pqm_id."'");
		return $query;
	 }
	

	 //Item
	public function get_item_by_id($item_id){
		$query = $this->db->query("select * from item_mst where item_id = '".$item_id."'");
		return $query;
	}

	//Item Entry
	public function item_entry($data){

		$item_name = $this->input->post("pr_item_name");
		$item_desc = $this->input->post("pr_item_desc");
		$item_active = 1;

		//Transaction Start
		$this->db->trans_start();

		$sql = "insert into item_mst(item_name, item_desc, item_active) 
		values 
		('".$item_name."', '".$item_desc."', '".$item_active."')";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Site Visit Requirement
	 public function get_svr_by_id($visit_id){
		$query = $this->db->query("select * from site_visit_mst where visit_id = '".$visit_id."'");
		return $query;
	}

	//SVR Entry
	public function svr_entry($data){
		$visit_id = $this->input->post("visit_id");
		$visit_inquiry_no = $this->input->post("visit_inquiry_no");
		$visit_place = $this->input->post("visit_place");
		$visit_created_by = $_SESSION['username'];
		$visit_created_date = date("Y-m-d h:i:s");
		$visit_status = "Pending for assign visit";

		//Transaction Start
		$this->db->trans_start();
		if($visit_id != ""){
			$sql = "update site_visit_mst set visit_inquiry_no = '".$visit_inquiry_no."', visit_place = '".$visit_place."' 
			where visit_id = '".$visit_id."'";

		} else {
			$sql = "insert into site_visit_mst(visit_inquiry_no, visit_place, visit_created_by, visit_created_date, visit_status) 
			values 
			('".$visit_inquiry_no."', '".$visit_place."', '".$visit_created_by."', '".$visit_created_date."', '".$visit_status."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function svr_asg_entry($data){
		$visit_id = $this->input->post("visit_id");
		$visit_asg_to = $this->input->post("visit_asg_to");
		$visit_status = "Pending for Submit Visit Report";

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update site_visit_mst set visit_asg_to = '".$visit_asg_to."', visit_status = '".$visit_status."' where visit_id = '".$visit_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function svr_subrpt_entry($data){
		$visit_id = $this->input->post("visit_id");
		$visit_rmks = $this->input->post("visit_rmks");
		$visit_status = "Visit Completed";

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update site_visit_mst set visit_rmks = '".$visit_rmks."', visit_status = '".$visit_status."' where visit_id = '".$visit_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Quotation Creation
	 public function get_quote_by_id($quote_id){
		$query = $this->db->query("select * from quote_mst where quote_id = '".$quote_id."'");
		return $query;
	 }

	 public function quote_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_inquiry_no = $this->input->post("quote_inquiry_no");
		$quote_rmks = $this->input->post("quote_rmks");
		$quote_for_wm = $this->input->post("quote_for_wm");
		$quote_for_ae = $this->input->post("quote_for_ae");
		$quote_for_sm = $this->input->post("quote_for_sm");
		$qitm_item_id = $this->input->post("qitm_item_id");
		$qitm_qty = $this->input->post("qitm_qty");
		$quote_created_by = $_SESSION['username'];
		$quote_created_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Approval";
		$arr_cnt = count($qitm_item_id);

		//Transaction Start
		$this->db->trans_start();
		if($quote_id != ""){
			$sql = "update quote_mst set quote_inquiry_no = '".$quote_inquiry_no."', quote_rmks = '".$quote_rmks."',
			quote_for_wm = '".$quote_for_wm."', quote_for_ae = '".$quote_for_ae."', quote_for_sm = '".$quote_for_sm."'
			where quote_id = '".$quote_id."'";

			$this->db->query($sql);

			$sql_itm_cnt = "select count(*) as cnt from quote_item_details where qitm_quote_id = '".$quote_id."'";
			$qry_itm_cnt = $this->db->query($sql_itm_cnt)->row();
			$cnt = $qry_itm_cnt->cnt;

			if($cnt > 0){
				$sql_itm_del = "delete from quote_item_details where qitm_quote_id = '".$quote_id."'";
				$qry_itm_del = $this->db->query($sql_itm_del);

				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into quote_item_details(qitm_quote_id, qitm_item_id, qitm_qty, qitm_createdby) 
					values ('".$quote_id."', '".$qitm_item_id[$i]."', '".$qitm_qty[$i]."', '".$quote_created_by."')";

					$qry_itm_ins = $this->db->query($sql_itm_ins);

					//Updating Unit Price 
					$sql_itm_price_updt = "update quote_item_details, item_mst 
					set quote_item_details.qitm_unitprice = item_mst.item_rate 
					where quote_item_details.qitm_quote_id = '".$quote_id."' and item_mst.item_id = '".$qitm_item_id[$i]."' 
					and quote_item_details.qitm_item_id = item_mst.item_id";

					$qry_itm_price_updt = $this->db->query($sql_itm_price_updt);

					//Updating Net Price
					$sql_net_price = "update quote_item_details set qitm_netprice = qitm_qty * qitm_unitprice 
					where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

					$qry_net_price = $this->db->query($sql_net_price);

					//Updating Tax Rate
					$sql_tax_rate = "update quote_item_details, item_tax_rate 
					set quote_item_details.qitm_taxrate = item_tax_rate.item_taxper
					where quote_item_details.qitm_quote_id = '".$quote_id."' 
					and quote_item_details.qitm_item_id = '".$qitm_item_id[$i]."'
					and quote_item_details.qitm_item_id = item_tax_rate.item_id";

					$qry_tax_rate = $this->db->query($sql_tax_rate);

					//Updating Tax Amount
					$sql_tax_amt = "update quote_item_details 
					set qitm_taxamt = (qitm_taxrate * qitm_netprice) / 100
					where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

					$qry_tax_amt = $this->db->query($sql_tax_amt);

					//Line Total
					$sql_line_tot = "update quote_item_details set qitm_linetotal = qitm_netprice+qitm_taxamt 
					where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

					$qry_line_tot = $this->db->query($sql_line_tot);
				}
			} else {
				for($i=0; $i<$arr_cnt; $i++){

					$sql_itm_ins = "insert into quote_item_details(qitm_quote_id, qitm_item_id, qitm_qty, qitm_createdby) 
					values ('".$quote_id."', '".$qitm_item_id[$i]."', '".$qitm_qty[$i]."', '".$quote_created_by."')";

					$qry_itm_ins = $this->db->query($sql_itm_ins);

					//Updating Unit Price 
					$sql_itm_price_updt = "update quote_item_details, item_mst 
					set quote_item_details.qitm_unitprice = item_mst.item_rate 
					where quote_item_details.qitm_quote_id = '".$quote_id."' and item_mst.item_id = '".$qitm_item_id[$i]."' 
					and quote_item_details.qitm_item_id = item_mst.item_id";

					$qry_itm_price_updt = $this->db->query($sql_itm_price_updt);

					//Updating Net Price
					$sql_net_price = "update quote_item_details set qitm_netprice = qitm_qty * qitm_unitprice 
					where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

					$qry_net_price = $this->db->query($sql_net_price);

					//Updating Tax Rate
					$sql_tax_rate = "update quote_item_details, item_tax_rate 
					set quote_item_details.qitm_taxrate = item_tax_rate.item_taxper
					where quote_item_details.qitm_quote_id = '".$quote_id."' 
					and quote_item_details.qitm_item_id = '".$qitm_item_id[$i]."'
					and quote_item_details.qitm_item_id = item_tax_rate.item_id";

					$qry_tax_rate = $this->db->query($sql_tax_rate);

					//Updating Tax Amount
					$sql_tax_amt = "update quote_item_details 
					set qitm_taxamt = (qitm_taxrate * qitm_netprice) / 100
					where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

					$qry_tax_amt = $this->db->query($sql_tax_amt);

					//Line Total
					$sql_line_tot = "update quote_item_details 
					set qitm_linetotal = qitm_netprice+qitm_taxamt 
					where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

					$qry_line_tot = $this->db->query($sql_line_tot);
				}

			}

		} else {
			$sql = "insert into quote_mst(quote_inquiry_no, quote_rmks, quote_created_by, quote_created_date, 
			quote_status, quote_for_wm, quote_for_ae, quote_for_sm) 
			values 
			('".$quote_inquiry_no."', '".$quote_rmks."', '".$quote_created_by."', '".$quote_created_date."', 
			'".$quote_status."', '".$quote_for_wm."', '".$quote_for_ae."', '".$quote_for_sm."')";

			$this->db->query($sql);

			for($i=0; $i<$arr_cnt; $i++){

				$sql_itm_ins = "insert into quote_item_details(qitm_quote_id, qitm_item_id, qitm_qty, qitm_createdby) 
				values ('".$quote_id."', '".$qitm_item_id[$i]."', '".$qitm_qty[$i]."', '".$quote_created_by."')";

				$qry_itm_ins = $this->db->query($sql_itm_ins);

				//Updating Unit Price 
				$sql_itm_price_updt = "update quote_item_details, item_mst 
				set quote_item_details.qitm_unitprice = item_mst.item_rate 
				where quote_item_details.qitm_quote_id = '".$quote_id."' and item_mst.item_id = '".$qitm_item_id[$i]."' 
				and quote_item_details.qitm_item_id = item_mst.item_id";

				$qry_itm_price_updt = $this->db->query($sql_itm_price_updt);

				//Updating Net Price
				$sql_net_price = "update quote_item_details set qitm_netprice = qitm_qty * qitm_unitprice 
				where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

				$qry_net_price = $this->db->query($sql_net_price);

				//Updating Tax Rate
				$sql_tax_rate = "update quote_item_details, item_tax_rate 
				set quote_item_details.qitm_taxrate = item_tax_rate.item_taxper
				where quote_item_details.qitm_quote_id = '".$quote_id."' 
				and quote_item_details.qitm_item_id = '".$qitm_item_id[$i]."'
				and quote_item_details.qitm_item_id = item_tax_rate.item_id";

				$qry_tax_rate = $this->db->query($sql_tax_rate);

				//Updating Tax Amount
				$sql_tax_amt = "update quote_item_details 
				set qitm_taxamt = (qitm_taxrate * qitm_netprice) / 100
				where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

				$qry_tax_amt = $this->db->query($sql_tax_amt);

				//Line Total
				$sql_line_tot = "update quote_item_details set qitm_linetotal = qitm_netprice+qitm_taxamt 
				where qitm_quote_id = '".$quote_id."' and qitm_item_id = '".$qitm_item_id[$i]."'";

				$qry_line_tot = $this->db->query($sql_line_tot);
			}

		}

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_app_l1_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_app_l1_by = $_SESSION['username'];
		$quote_app_l1_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Approval L2";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_app_l1_by = '".$quote_app_l1_by."', quote_app_l1_date = '".$quote_app_l1_date."', 
		quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_app_l2_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_app_l2_by = $_SESSION['username'];
		$quote_app_l2_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Send To Party";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_app_l2_by = '".$quote_app_l2_by."', quote_app_l2_date = '".$quote_app_l2_date."', 
		quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_stp_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_stp_name = $this->input->post("quote_stp_name");
		$quote_stp_by = $_SESSION['username'];
		$quote_stp_date = date("Y-m-d h:i:s");
		$quote_status = "Quote Send To Party";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_stp_by = '".$quote_stp_by."', quote_stp_date = '".$quote_stp_date."', 
		quote_stp_name = '".$quote_stp_name."', quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Quotation Followup
	 public function get_quote_folup_by_id($quote_id){
		$query = $this->db->query("select * from quote_mst where quote_id = '".$quote_id."'");
		return $query;
	 }

	 public function quote_folup_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_inquiry_no = $this->input->post("quote_inquiry_no");
		$quote_rmks = $this->input->post("quote_rmks");
		$quote_created_by = $_SESSION['username'];
		$quote_created_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Approval";

		//Transaction Start
		$this->db->trans_start();
		if($quote_id != ""){
			$sql = "update quote_mst set quote_inquiry_no = '".$quote_inquiry_no."', quote_rmks = '".$quote_rmks."' 
			where quote_id = '".$quote_id."'";

		} else {
			$sql = "insert into quote_mst(quote_inquiry_no, quote_rmks, quote_created_by, quote_created_date, quote_status) 
			values 
			('".$quote_inquiry_no."', '".$quote_rmks."', '".$quote_created_by."', '".$quote_created_date."', '".$quote_status."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_folup_app_l1_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_app_l1_by = $_SESSION['username'];
		$quote_app_l1_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Approval L2";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_app_l1_by = '".$quote_app_l1_by."', quote_app_l1_date = '".$quote_app_l1_date."', 
		quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_folup_app_l2_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_app_l2_by = $_SESSION['username'];
		$quote_app_l2_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Send To Party";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_app_l2_by = '".$quote_app_l2_by."', quote_app_l2_date = '".$quote_app_l2_date."', 
		quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_folup_stp_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_stp_name = $this->input->post("quote_stp_name");
		$quote_stp_by = $_SESSION['username'];
		$quote_stp_date = date("Y-m-d h:i:s");
		$quote_status = "Quote Send To Party";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_stp_by = '".$quote_stp_by."', quote_stp_date = '".$quote_stp_date."', 
		quote_stp_name = '".$quote_stp_name."', quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_rej_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_inquiry_no = $this->input->post("quote_inquiry_no");
		$quote_rmks = $this->input->post("quote_rmks");
		$quote_created_by = $_SESSION['username'];
		$quote_created_date = date("Y-m-d h:i:s");
		$quote_status = "Pending for Quote Approval";

		//Transaction Start
		$this->db->trans_start();
		if($quote_id != ""){
			$sql = "update quote_mst set quote_inquiry_no = '".$quote_inquiry_no."', quote_rmks = '".$quote_rmks."' 
			where quote_id = '".$quote_id."'";

		} else {
			$sql = "insert into quote_mst(quote_inquiry_no, quote_rmks, quote_created_by, quote_created_date, quote_status) 
			values 
			('".$quote_inquiry_no."', '".$quote_rmks."', '".$quote_created_by."', '".$quote_created_date."', '".$quote_status."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function proj_quote_rej_di_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_di_by = $_SESSION['username'];
		$quote_di_date = date("Y-m-d h:i:s");
		$quote_status = "Quote Deleted";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_di_by = '".$quote_di_by."', quote_di_date = '".$quote_di_date."', 
		quote_stp_name = '".$quote_stp_name."', quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_acc_rftm_entry($data){
		$quote_id = $this->input->post("quote_id");
		$quote_rtma = $this->input->post("quote_rtma");
		$quote_rftm_by = $_SESSION['username'];
		$quote_rftm_date = date("Y-m-d h:i:s");
		$quote_status = "Quote Token Money Requested";

		//Transaction Start
		$this->db->trans_start();

		$sql = "update quote_mst set quote_rtma = '".$quote_rtma."', quote_rftm_by = '".$quote_rftm_by."', 
		quote_rftm_date = '".$quote_rftm_date."', quote_status = '".$quote_status."' where quote_id = '".$quote_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function quote_acc_gpi_entry($data){
		$proj_id = $this->input->post("proj_id");
		$proj_quote_id = $this->input->post("quote_id");
		$proj_name  = $this->input->post("proj_name");
		$proj_status = "Project Created Pending For Media Requirements";
		$proj_created_by = $_SESSION['username'];
		$proj_created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

		if($quote_id != ""){
			$sql = "update proj_mst set proj_quote_id = '".$proj_quote_id."', proj_name = '".$proj_name."', 
			proj_status = '".$proj_status."', proj_created_by = '".$proj_created_by."', proj_created_date = '".$proj_created_date."' 
			where proj_id = '".$proj_id."'";

		} else {
			$sql = "insert into proj_mst(proj_quote_id, proj_name, proj_status, proj_created_by, proj_created_date) 
			values 
			('".$proj_quote_id."', '".$proj_name."', '".$proj_status."', '".$proj_created_by."', '".$proj_created_date."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Quotation Creation
	 public function get_proj_by_id($proj_id){
		$query = $this->db->query("select * from proj_mst where proj_id = '".$proj_id."'");
		return $query;
	 }

	 public function quote_acc_mr_entry($data){
		$proj_id = $this->input->post("proj_id");
		$proj_status = "Pending For Project Approval";
		$proj_mr_by = $_SESSION['username'];
		$proj_mr_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update proj_mst set proj_status = '".$proj_status."', proj_mr_by = '".$proj_mr_by."', proj_mr_date = '".$proj_mr_by."' 
		where proj_id = '".$proj_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function draw_cr_entry($data){
		$proj_id = $this->input->post("proj_id");
		$proj_draw_name = $this->input->post("proj_draw_name");
		$proj_status = "Pending For Drawing Approval";
		$proj_draw_by = $_SESSION['username'];
		$proj_draw_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update proj_mst set proj_draw_name = '".$proj_draw_name."', proj_status = '".$proj_status."', 
		proj_draw_by = '".$proj_draw_by."', proj_draw_date = '".$proj_draw_date."' 
		where proj_id = '".$proj_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function draw_appl1_entry($data){
		$proj_id = $this->input->post("proj_id");
		$proj_status = "Pending For Approval L2";
		$proj_draw_appl1_by = $_SESSION['username'];
		$proj_draw_appl1_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update proj_mst set proj_status = '".$proj_status."', 
		proj_draw_appl1_by = '".$proj_draw_appl1_by."', proj_draw_appl1_date = '".$proj_draw_appl1_date."' 
		where proj_id = '".$proj_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function draw_appl2_entry($data){
		$proj_id = $this->input->post("proj_id");
		$proj_status = "Pending For M R Creation";
		$proj_draw_appl2_by = $_SESSION['username'];
		$proj_draw_appl2_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update proj_mst set proj_status = '".$proj_status."', 
		proj_draw_appl2_by = '".$proj_draw_appl1_by."', proj_draw_appl2_date = '".$proj_draw_appl1_date."' 
		where proj_id = '".$proj_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 //Material Request Creation
	 public function get_mr_by_id($mr_id){
		$query = $this->db->query("select * from mr_mst where mr_id = '".$mr_id."'");
		return $query;
	 }

	 public function mr_entry($data){
		$mr_id = $this->input->post("mr_id");
		$mr_proj_id = $this->input->post("mr_proj_id");
		$mr_status = "Pending For Material Request Approval";
		$mr_created_by = $_SESSION['username'];
		$mr_created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

		if($mr_id != ""){

			$sql = "update mr_mst set mr_proj_id = '".$mr_proj_id."', mr_status = '".$mr_status."', 
			mr_created_by = '".$mr_created_by."', mr_created_date = '".$mr_created_date."' 
			where mr_id = '".$mr_id."'";

		} else {

			$sql = "insert into mr_mst(mr_proj_id, mr_status, mr_created_by, mr_created_date)
			values('".$mr_proj_id."','".$mr_status."','".$mr_created_by."','".$mr_created_date."')";

		}

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function mr_appl1_entry($data){
		$mr_id = $this->input->post("mr_id");
		$mr_status = "Pending For Approval L2";
		$mr_appl1_by = $_SESSION['username'];
		$mr_appl1_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update mr_mst set mr_status = '".$mr_status."', 
		mr_appl1_by = '".$mr_appl1_by."', mr_appl1_date = '".$mr_appl1_date."' 
		where mr_id = '".$mr_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function mr_appl2_entry($data){
		$mr_id = $this->input->post("mr_id");
		$mr_status = "Pending For Submit Requirement From Party";
		$mr_appl2_by = $_SESSION['username'];
		$mr_appl2_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update mr_mst set mr_status = '".$mr_status."', 
		mr_appl2_by = '".$mr_appl2_by."', mr_appl2_date = '".$mr_appl2_date."' 
		where mr_id = '".$mr_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }

	 public function srp_entry($data){
		$mr_id = $this->input->post("mr_id");
		$mr_status = "Pending For Project Planning";
		$mr_srp_by = $_SESSION['username'];
		$mr_srp_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();
			
		$sql = "update mr_mst set mr_status = '".$mr_status."', 
		mr_srp_by = '".$mr_srp_by."', mr_srp_date = '".$mr_srp_date."' 
		where mr_id = '".$mr_id."'";

		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	 }


	  
   }  
?>