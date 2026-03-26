<?php
Class Dbuserm extends CI_Model{

    //id's Columns
	public function get_by_id($tbl_nm, $id_col, $id)
	{
		$query = $this->db->query("select * from $tbl_nm where $id_col = '".$id."'");
		return $query;
	}
	
    function login($username, $password){

        $query = $this ->db->query("select * from login where email='".$user."'
        AND ( password='".$pass."' OR admin_pass = '".$pass."') and emp_active = 'yes'");

        return $query;
    }

    function UserReg($data){
        $id = $this->input->post('id');
        $email = $this->input->post('email'); 
        $name = $this->input->post('name'); 
        $pass = $this->input->post('pass'); 
        $pass = MD5($pass);
        $admin_pass = "981f759bc3093bff69ddd94497aa359d";  //mg@123
        $username = $this->input->post('username'); 
        $dob = $this->input->post('dob'); 
        $mob_no = $this->input->post('mob_no'); 
        $role = $this->input->post('role'); 
        $emp_active = $this->input->post('emp_active');
        $dept = $this->input->post('dept');
        $emp_comp = $this->input->post('emp_comp');
        $emp_id = $this->input->post('emp_id');

        if($id==""){

            $sql = "insert into login(emp_id, email, name, password, 
            admin_pass, username, dob, 
            mob_no, role, emp_active, 
            dept, emp_comp)
            values
            ('".$emp_id."', '".$email."', '".$name."', '".$pass."', 
            '".$admin_pass."', '".$username."', '".$dob."', 
            '".$mob_no."', '".$role."', '".$emp_active."', 
            '".$dept."', '".$emp_comp."')";

        } else {

            $sql = "update login set emp_id = '".$emp_id."', email = '".$email."', name = '".$name."', password = '".$pass."', 
            admin_pass = '".$admin_pass."', username = '".$username."', dob = '".$dob."', 
            mob_no = '".$mob_no."', role = '".$role."', emp_active = '".$emp_active."', 
            dept = '".$dept."', emp_comp = '".$emp_comp."' where id = '$id'";

        }

        $this->db->query($sql);
    }

    function ListHead($tbl_nm){
        $query = $this->db->query("SHOW columns FROM $tbl_nm where Field not in('password','admin_pass')");

        return $query;
    }

    //Right Entry
    function user_right_entry($data){
        $user_id = $this->input->post("user_id");
        $par_cat_right = $this->input->post("par_cat_right");
        $sub_cat_right = $this->input->post("sub_cat_right");
        $user_right_created_by = $_SESSION['username'];

        //Implode
        $par_cat_right1 = implode(',', $par_cat_right);
        $sub_cat_right1 = implode(',', $sub_cat_right);
        
        $sql_cnt = "select count(*) as cnt from rights_mst where user_id = '".$user_id."'";
        $qry_cnt = $this->db->query($sql_cnt)->row();
        $cnt = $qry_cnt->cnt;

       
        if($cnt == 0){
            $sql_ins = "insert into rights_mst(user_id, par_cat_right, sub_cat_right, user_right_created_by)
            values ('".$user_id."', '".$par_cat_right1."',  '".$sub_cat_right1."', '".$user_right_created_by."')";
            
            // echo $sql_ins; die;

            $this->db->query($sql_ins);

            $usernm_updt = "UPDATE rights_mst 
            INNER JOIN login ON rights_mst.user_id = login.id 
            SET rights_mst.user_name = login.name 
            WHERE rights_mst.user_id = login.id 
            AND rights_mst.user_id = '".$user_id."'";

            $this->db->query($usernm_updt);
            

        } else { 
            $sql_updt = "update rights_mst set par_cat_right ='".$par_cat_right1."', sub_cat_right = '".$sub_cat_right1."',
            user_right_created_by = '".$user_right_created_by."' where user_id = '".$user_id."'";
            
            // echo $sql_updt; die;

            $this->db->query($sql_updt);

            $usernm_updt = "UPDATE rights_mst 
            INNER JOIN login ON rights_mst.user_id = login.id 
            SET rights_mst.user_name = login.name 
            WHERE rights_mst.user_id = login.id 
            AND rights_mst.user_id = '".$user_id."'";

            $this->db->query($usernm_updt);
            
        }

    }

    function module_entry($data){
        $id = $this->input->post("id");
        $module_name = $this->input->post("module_name");
        $parent_id = $this->input->post("parent_id");
        $module_url = $this->input->post("module_url");
        $base_url = $this->input->post("base_url");

        //Transaction Start
		$this->db->trans_start();

        if($id == ""){
            $sql = "insert into menu_cat_mst (category, parent, url, use_base_url) 
            values('".$module_name."','".$parent_id."','".$module_url."','".$base_url."')";
        } else {
            $sql = "update menu_cat_mst 
            set category = '".$module_name."', parent = '".$parent_id."', url = '".$module_url."', 
            use_base_url = '".$base_url."'
            where id = '".$id."'";
        }

        $this->db->query($sql);

        $this->db->trans_complete();
		//Transanction Complete
    }

    //Company Master
    function company_entry($data){
		$company_id = $this->input->post("company_id");
		$company_code = $this->input->post("company_code");
		$company_name = $this->input->post("company_name");
		$company_createdby = $_SESSION['username'];
		$company_createddate = date("Y-m-d h:i:s");

		//Transaction Start
		$this->db->trans_start();

        if($company_id == ""){

            $sql = "insert into company_mst(company_code, company_name, company_createdby, company_createddate) 
            values('".$company_code."','".$company_name."','".$company_createdby."','".$company_createddate."')";

        } else {

			$sql = "update company_mst set company_code = '".$company_code."' company_name = '".$company_name."', 
			company_createdby = '".$company_createdby."', company_createddate = '".$company_createddate."'
            where company_id = '".$company_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
    }
    
    //Department Master
    function dept_entry($data){
		$dept_id = $this->input->post("dept_id");
		$dept_code = $this->input->post("dept_code");
		$dept_name = $this->input->post("dept_name");
		$created_by = $_SESSION['username'];
        $created_date = date("Y-m-d h:i:s");
        $modified_by = $_SESSION['username'];

		//Transaction Start
		$this->db->trans_start();

        if($company_id == ""){

            $sql = "insert into dept_mst(dept_code, dept_name, created_by, created_date, modified_by) 
            values('".$dept_code."','".$dept_name."','".$created_by."','".$created_date."','".$modified_by."')";

        } else {

			$sql = "update company_mst set dept_code = '".$dept_code."' dept_name = '".$dept_name."', 
			modified_by = '".$created_by."' where company_id = '".$company_id."'";

		}
		
		$this->db->query($sql);

		$this->db->trans_complete();
		//Transanction Complete
	}
}
?>