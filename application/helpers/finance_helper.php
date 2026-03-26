<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('finance')){
    
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

	function company_list(){
		$ci =& get_instance();
		$ci->load->database();
			
        $sql="select * from company_mst where company_active = 1";
		
        $query = $ci->db->query($sql);
        
		foreach ($query->result() as $row) {
          $company_id = $row->company_id;
          $company_name = $row->company_name;
          
          $data .= '<option value="'.$company_id.'">'.$company_name.'</option>';

		}
		
		return $data;
    }

    function cash_dino_det($curr_name, $date, $comp_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql="select curr_unit_val from cash_dino_mst 
        inner join cash_dino_dtl on cash_dino_mst.cd_id = cash_dino_dtl.cd_id
        where cash_dino_mst.cd_date = '".$date."' 
        and cash_dino_mst.cd_comp_id = '".$comp_id."' 
        and cash_dino_dtl.curr_unit_name = '".$curr_name."'";

        $query = $ci->db->query($sql)->row();

        $curr_unit_val = $query->curr_unit_val;

        if($curr_unit_val == ""){
            $curr_unit_val = 0;
        }

        return $curr_unit_val;

    }

    function cash_dino_tot($date, $comp_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql="select cd_tot_amt from cash_dino_mst where cd_date = '".$date."' and cd_comp_id = '".$comp_id."' ";

        $query = $ci->db->query($sql)->row();

        $cd_tot_amt = $query->cd_tot_amt;

        if($cd_tot_amt == ""){
            $cd_tot_amt = 0;
        }

        return $cd_tot_amt;

    }

    function cash_dino_det_tot($curr_name, $from_dt, $to_dt, $comp_id){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql="select sum(curr_unit_val) as tot_curr_unit_val from cash_dino_mst 
        inner join cash_dino_dtl on cash_dino_mst.cd_id = cash_dino_dtl.cd_id
        where cash_dino_mst.cd_date between '".$from_dt."' and  '".$to_dt."'
        and cash_dino_mst.cd_comp_id = '".$comp_id."' 
        and cash_dino_dtl.curr_unit_name = '".$curr_name."'";

        $query = $ci->db->query($sql)->row();

        $tot_curr_unit_val = $query->tot_curr_unit_val;

        if($tot_curr_unit_val == ""){
            $tot_curr_unit_val = 0;
        }

        return $tot_curr_unit_val;

    }

    function emp_list(){
        $ci =& get_instance();
        $ci->load->database();
        
        $sql="select * from login where emp_active = 'yes'";
        $query = $ci->db->query($sql);

        foreach ($query->result() as $row) {
            $name = $row->name;
            $id = $row->id;
            
            $data .= '<option value="'.$name.'">'.$name.'</option>';

        }
        
        return $data;
    }	
}