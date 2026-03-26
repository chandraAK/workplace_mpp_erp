<?php
class Financem extends CI_Model
{  
	function __construct()
	{   
		parent::__construct();  
	}

	function ListHead($tbl_nm){
		$query = $this->db->query("SHOW columns FROM $tbl_nm");
		return $query;
	}

	//id's Columns
	public function get_by_id($tbl_nm, $id_col, $id)
	{
		$query = $this->db->query("select * from $tbl_nm where $id_col = '".$id."'");
		return $query;
	}

	/************************************************ */
	/*******************Masters********************** */
	/************************************************ */

	function company_entry($data){
		$company_id = $this->input->post("company_id");
		$company_name = $this->input->post("company_name");
		$company_createdby = $_SESSION['username'];
		$company_createddate = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($company_id == ""){

            $sql = "insert into company_mst(company_name, company_createdby, company_createddate) 
            values('$company_name','$company_createdby','$company_createddate')";

        } else {

			$sql = "update company_mst set company_name = '$company_name', 
			company_createdby = '$company_createdby', company_createddate = '$company_createddate'
            where company_id = '$company_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	function dino_entry($data){
		$curr_id = $this->input->post("curr_id");
		$curr_name = $this->input->post("curr_name");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($curr_id == ""){

            $sql = "insert into curr_unit_mst(curr_name, created_by, created_date) 
            values('$curr_name','$created_by','$created_date')";

        } else {

			$sql = "update curr_unit_mst set curr_name = '$curr_name', 
			created_by = '$created_by', created_date = '$created_date'
            where curr_id = '$curr_id'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}

	/************************************************ */
	/*******************Masters********************** */
	/************************************************ */

	function cash_dino_entry($data){
		$cd_id = $this->input->post("cd_id");
		$cd_comp_id = $this->input->post("cd_comp_id");
		$cd_date = $this->input->post("cd_date");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");

		$curr_unit_id = $this->input->post("curr_unit_id");
		$curr_unit_name = $this->input->post("curr_unit_name");
		$curr_unit_val = $this->input->post("curr_unit_val");

		$arr_cnt = count($curr_unit_val);

		//Transaction Start
		$this->db->trans_start();

        if($cd_id == ""){
			//Master Table Entry
            $sql_mst = "insert into cash_dino_mst(cd_comp_id, cd_comp_name, cd_date, created_by, created_date) 
			values('".$cd_comp_id."','".$cd_comp_name."','".$cd_date."','".$created_by."','".$created_date."')";
			
			$this->db->query($sql_mst);

			//Updating Company Name
			$updt_comp_nm = $this->db->query("update cash_dino_mst inner join company_mst 
			on cash_dino_mst.cd_comp_id = company_mst.company_id 
			set cash_dino_mst.cd_comp_name = company_mst.company_name
			where cash_dino_mst.cd_comp_id = '".$cd_comp_id."'");

			//Getting Max Id
			$sql_max_id = "select max(cd_id) as cd_id_max from cash_dino_mst";
			$qry_max_id = $this->db->query($sql_max_id)->row();
			$cd_id_max = $qry_max_id->cd_id_max;

			//Previous Entries Chk & Delete
			$sql_prev_ent = "select count(*) as count from cash_dino_dtl where cd_id = '".$cd_id_max."'";
			$qry_prev_ent = $this->db->query($sql_prev_ent)->row();
			$count = $qry_prev_ent->count;

			if($count > 0){
				$sql_del_prev = $this->db->query("delete from cash_dino_dtl where cd_id = '".$cd_id_max."'");
			}

			$curr_amt = 0;
			for($i=0;$i<$arr_cnt;$i++){
				$curr_amt = $curr_unit_name[$i] * $curr_unit_val[$i];
				//Detail Table Entry
				$sql_det = "insert into cash_dino_dtl(cd_id, curr_unit_id, curr_unit_name, curr_unit_val, curr_amt)
				values('".$cd_id_max."','".$curr_unit_id[$i]."','".$curr_unit_name[$i]."','".$curr_unit_val[$i]."','".$curr_amt."')";

				$this->db->query($sql_det);
			}

			//Updating Total Value  Mst
			$updt_tot_val = $this->db->query("update cash_dino_mst 
			set cash_dino_mst.cd_tot_amt = (select sum(curr_amt) from cash_dino_dtl 
			where cash_dino_dtl.cd_id = cash_dino_mst.cd_id)
			where cash_dino_mst.cd_tot_amt = 0");


        } else {
			//Master Table Entry
			$sql_mst = "update cash_dino_mst set cd_comp_id = '".$curr_name."', 
			cd_comp_name = '".$cd_comp_name."', cd_date = '".$cd_date."',
			created_by = '".$created_by."', created_date = '".$created_date."'
			where curr_id = '".$curr_id."'";
			
			$this->db->query($sql_mst);

			//Updating Company Name
			$updt_comp_nm = $this->db->query("update cash_dino_mst inner join company_mst 
			on cash_dino_mst.cd_comp_id = company_mst.company_id 
			set cash_dino_mst.cd_comp_name = company_mst.company_name
			where cash_dino_mst.cd_comp_id = '".$cd_comp_id."'");


			//Previous Entries Chk & Delete
			$sql_prev_ent = "select count(*) as count from cash_dino_dtl where cd_id = '".$cd_id."'";
			$qry_prev_ent = $this->db->query($sql_prev_ent)->row();
			$count = $qry_prev_ent->count;

			if($count > 0){
				$sql_del_prev = $this->db->query("delete from cash_dino_dtl where cd_id = '".$cd_id."'");
			}

			$curr_amt = 0;
			for($i=0;$i<$arr_cnt;$i++){
				$curr_amt = $curr_unit_name[$i] * $curr_unit_val[$i];
				//Detail Table Entry
				$sql_det = "insert into cash_dino_dtl(cd_id, curr_unit_id, curr_unit_name, curr_unit_val, curr_amt)
				values('".$cd_id."','".$curr_unit_id[$i]."','".$curr_unit_name[$i]."','".$curr_unit_val[$i]."','".$curr_amt."')";

				$this->db->query($sql_det);
			}

			//Updating Total Value  Mst
			$updt_tot_val = $this->db->query("update cash_dino_mst 
			set cash_dino_mst.cd_tot_amt = (select sum(curr_amt) from cash_dino_dtl 
			where cash_dino_dtl.cd_id = cash_dino_mst.cd_id)
			where cash_dino_mst.cd_tot_amt = 0");

		}

		$this->db->trans_complete();
		//Transanction Complete
	}
	
	/************************* */
	/*******Petty Cash******** */
	/************************* */
	function pc_adv_entry(){
		$pc_adv_id = $this->input->post("pc_adv_id");
		$pc_emp_name = $this->input->post("pc_emp_name");
		$pc_adv_date = $this->input->post("pc_adv_date");
		$pc_adv_bal_amt = $this->input->post("pc_adv_bal_amt");
		$pc_adv_hot = $this->input->post("pc_adv_hot");
		$pc_adv_amt = $this->input->post("pc_adv_amt");
		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];
		$pc_adv_status = "Fresh";

		if($pc_adv_id == ""){

			$sql_ins = $this->db->query("insert into petty_cash_adv(pc_emp_name, pc_adv_date, 
			pc_adv_bal_amt, pc_adv_hot, pc_adv_amt, created_by, created_date, modified_by, pc_adv_status)
			values('".$pc_emp_name."', '".$pc_adv_date."', '".$pc_adv_bal_amt."', '".$pc_adv_hot."', '".$pc_adv_amt."', 
			'".$created_by."', '".$created_date."', '".$modified_by."', '".$pc_adv_status."')");

		} else {

			$sql_ins = $this->db->query("update petty_cash_adv set 
			pc_emp_name = '".$pc_emp_name."', pc_adv_date = '".$pc_adv_date."', 
			pc_adv_bal_amt = '".$pc_adv_bal_amt."', pc_adv_hot = '".$pc_adv_hot."', 
			pc_adv_amt = '".$pc_adv_amt."', modified_by = '".$modified_by."',
			pc_adv_status = '".$pc_adv_status."' 
			where pc_adv_id = '".$pc_adv_id."'");
		}
		
	}

	function pc_adv_app_entry(){
		$pc_adv_id = $this->input->post("pc_adv_id");
		$pc_emp_name = $this->input->post("pc_emp_name");
		$app_rmks = $this->input->post("app_rmks");
		$pc_adv_status = $this->input->post("pc_adv_status");
		$app_by = $_SESSION['username'];
		$app_date = date("Y-m-d h:i:s");

		$sql_ins = $this->db->query("update petty_cash_adv set 
		app_rmks = '".$app_rmks."', pc_adv_status = '".$pc_adv_status."', 
		app_by = '".$app_by."', app_date = '".$app_date."'
		where pc_adv_id = '".$pc_adv_id."'");

		if($pc_adv_status == 'Approved'){

			$updt_balance_amt = $this->db->query("update petty_cash_adv as t1
			inner join (
			select sum(pc_adv_amt) as pc_adv_amt_tot from petty_cash_adv where pc_emp_name = '".$pc_emp_name."') as t2
			set t1.pc_adv_bal_amt = t2.pc_adv_amt_tot
			where t1.pc_adv_id = $pc_adv_id");

		}
	}

	function pc_exp_entry($data, $file_name_arr){
		$pcexp_id = $this->input->post("pcexp_id");
		$pcexp_empname = $this->input->post("pcexp_empname");
		$pcexp_balamt = $this->input->post("pc_adv_bal_amt");
		$pcexp_dtl_date = $this->input->post("pcexp_dtl_date");
		$pcexp_dtl_amt = $this->input->post("pcexp_dtl_amt");
		$pcexp_dtl_com = $this->input->post("pcexp_dtl_com");
		$pcexp_dtl_bill = $this->input->post("pcexp_dtl_bill");

		$arr_cnt = count($pcexp_dtl_date);

		$created_by = $_SESSION['username'];
		$created_date = date("Y-m-d h:i:s");
		$modified_by = $_SESSION['username'];

		$pcexp_status = "Fresh";

		if($pcexp_id == ""){

			$sql_ins = $this->db->query("insert into petty_cash_exp_mst(pcexp_empname, pcexp_balamt, 
			created_by, created_date, modified_by, pcexp_status)
			values('".$pcexp_empname."', '".$pcexp_balamt."', 
			'".$created_by."', '".$created_date."', '".$modified_by."', '".$pcexp_status."')");

			//Getting Max Exp Id
			$sql_max_exp_id = "select max(pcexp_id) as max_id from petty_cash_exp_mst";
			$qry_max_exp_id = $this->db->query($sql_max_exp_id)->row();
			$max_id = $qry_max_exp_id->max_id;

			for($i=0;$i<$arr_cnt;$i++){
				$sql_dtl_ins = $this->db->query("insert into petty_cash_exp_dtl(pcexp_id, pcexp_dtl_date, 
				pcexp_dtl_amt, pcexp_dtl_com, pcexp_dtl_bill, 
				created_by, created_date, modified_by) 
				values ('".$max_id."', '".$pcexp_dtl_date[$i]."', 
				'".$pcexp_dtl_amt[$i]."', '".$pcexp_dtl_com[$i]."', '".$file_name_arr[$i]."', 
				'".$created_by."', '".$created_date."', '".$modified_by."')");
			}

			//Updating Total Amount
			$sql_updt_totamt = $this->db->query("update petty_cash_exp_mst 
			set pcexp_tot_amt = (select sum(pcexp_dtl_amt) from petty_cash_exp_dtl where pcexp_id = '".$max_id."')
			where pcexp_id = '".$max_id."'");

		} else {

			$sql_ins = $this->db->query("update petty_cash_exp_mst set 
			pcexp_empname = '".$pcexp_empname."', pcexp_balamt = '".$pcexp_balamt."',  modified_by = '".$modified_by."',
			pcexp_status = '".$pcexp_status."'
			where pcexp_id = '".$pcexp_id."'");

			//Getting Previous Entries
			$sql_prev = "select count(*) as cnt from petty_cash_exp_dtl where pcexp_id = '".$pcexp_id."'";
			$qry_prev = $this->db->query($sql_prev)->row();
			$cnt = $qry_prev->cnt;

			if($cnt > 0){
				//Deleting Previous Entries
				$sql_del_prev = $this->db->query("delete from petty_cash_exp_dtl where pcexp_id='".$pcexp_id."'");
			}

			for($i=0;$i<$arr_cnt;$i++){
				$sql_dtl_ins = $this->db->query("insert into petty_cash_exp_dtl(pcexp_id, pcexp_dtl_date, 
				pcexp_dtl_amt, pcexp_dtl_com, pcexp_dtl_bill, 
				created_by, created_date, modified_by) 
				values ('".$pcexp_id."', '".$pcexp_dtl_date[$i]."', 
				'".$pcexp_dtl_amt[$i]."', '".$pcexp_dtl_com[$i]."', '".$file_name_arr[$i]."', 
				'".$created_by."', '".$created_date."', '".$modified_by."')");
			}

			//Updating Total Amount
			$sql_updt_totamt = $this->db->query("update petty_cash_exp_mst 
			set pcexp_tot_amt = (select sum(pcexp_dtl_amt) from petty_cash_exp_dtl where pcexp_id = '".$pcexp_id."')");

		}
		
	}

	public function pc_exp_app_entry(){
		$pcexp_id = $this->input->post("pcexp_id");
		$pcexp_empname = $this->input->post("pcexp_empname");
		$app_rmks = $this->input->post("app_rmks");
		$pcexp_status = $this->input->post("pcexp_status");

		$app_by = $_SESSION['username'];
		$app_date = date("Y-m-d h:i:s");

		$sql_ins = $this->db->query("update petty_cash_exp_mst set 
		app_rmks = '".$app_rmks."', pcexp_status = '".$pcexp_status."',  app_by = '".$app_by."', app_date = '".$app_date."'
		where pcexp_id = '".$pcexp_id."'");

	}
}  
?>