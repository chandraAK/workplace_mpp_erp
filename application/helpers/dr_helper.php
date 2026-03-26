<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('dr')){	

	function dr_lead_name(){
		$ci =& get_instance();
		$ci->load->database();
		$data="";	
		$sql="select name from login where dept = '3' and username is not null";
		$query = $ci->db->query($sql);

		foreach ($query->result() as $row) {
			$name = $row->name;
			$data .= '<option value="'.$name.'">'.$name.'</option>';
		}

		return $data;
	}
		

	function dr_sales_name(){
		$ci =& get_instance();
		$ci->load->database();
		$data="";	
		$sql="select * from login where username is not null and dept in('1','2','3','4','5','6','7','8','10','12','13','14')";
		$query = $ci->db->query($sql);

		foreach ($query->result() as $row) {
			$username1 = $row->username;
			$name = $row->name;
			$data .= '<option value="'.$username1.'">'.$name.'</option>';
		}

		return $data;
	}

	function dr_dept(){
		$ci=& get_instance();
		$ci->load->database();
		$data="";
		$sql="select * from dept_mst";
		$query=$ci->db->query($sql);

		foreach ($query->result() as $row) {
			$dept_name = $row->dept_name;
			$dept_id = $row->dept_id;
			$data .= '<option value="'.$dept_id.'">'.$dept_name.'</option>';

		}

		return $data;
	}

	function cust_name(){
		$ci =& get_instance();
		$db2 = $ci->load->database('db2',TRUE);
		$data="";
		//$data = array();
		$sql = "select * from tabCustomer";
		$query = $db2->query($sql);

		foreach($query->result() as $row){
			$data .= '<option value="'.$row->customer_name.'">'.$row->customer_name.'</option>';
		}

		return $data;
	}  
	function customer_name(){
		$ci =& get_instance();
		 $ci->load->database();
		$data="";
		//$data = array();
		$sql = "select * from erp_cust_name";
		$query = $ci->db->query($sql);

		foreach($query->result() as $row){
			$data .= '<option value="'.$row->customer_name.'">'.$row->customer_name.'</option>';
		}

		return $data;
	}  
	

	function prod_name(){
		$ci =& get_instance();
		 $ci->load->database();
		$response = array();
		$sql = "select item_name from tab_sales_inv_item" ;
		$query = $ci->db->query($sql);
		foreach($query->result() as $row){
			$data .= '<option value="'.$row->item_name.'">'.$row->item_name.'</option>';
		}
	
		return $data;
	  }

	  function sales_order(){
		$ci =& get_instance();
		 $ci->load->database();
		$response = array();
		$sql = "select parent from tab_sales_ord_item" ;
		$query = $ci->db->query($sql);
		foreach($query->result() as $row){
			$data .= '<option value="'.$row->parent.'">'.$row->parent.'</option>';
		}
	
		return $data;
	  }
	
		function dr_date_wise($dr_created_by,$dr_date){
			$ci=& get_instance();
			$ci->load->database();

			$sql = "select count(*) as count from dr_mst where dr_created_by ='".$dr_created_by."'
			and dr_date ='".$dr_date."'";
			$query = $ci->db->query($sql)->row();

			 $count = $query->count;

			 if($count > 0){
				 $count1 = 1;?>
				 <a href= "<?php echo base_url(); ?>index.php/<?php echo $edit_url; ?>?id=<?php echo $row->{$primary_col}; ?>">
				 <i class="fa fa-pencil"><?php echo $count1;?></i> </a>
			<?php }
			 else {

				$count1 = 0;
			 }

			 return $count1;

		}
		

	//Get All The Dates Between The Date Range
    function getDatesFromRange($start, $end, $format = 'Y-m-d'){     
        // Declare an empty array 
        $array = array(); 
          
        // Variable that store the date interval 
        // of period 1 day 
        $interval = new DateInterval('P1D'); 
      
        $realEnd = new DateTime($end); 
        $realEnd->add($interval); 
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
      
        // Use loop to store date into array 
        foreach($period as $date) {                  
            $array[] = $date->format($format);  
        } 
      
        // Return the array elements 
        return array_reverse($array); 
    }

}
?>