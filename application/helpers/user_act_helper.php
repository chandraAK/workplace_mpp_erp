<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('user_act'))
{
	//Start of helper functions
	function user_act(){
		
		$ci =& get_instance();
		$ci->load->database();
		$ci->load->library('user_agent');
		
		$data['browser'] = $ci->agent->browser();
		
		$user_name = $_SESSION['username'];
		$datetime = date('Y-m-d H:i:s');
		$data['browser'] = $ci->agent->browser();
		$data['os'] = $ci->agent->platform();
		
		//GET IP & HOST NAME
		$ip=$_SERVER["REMOTE_ADDR"];
		$host_name=gethostbyaddr($ip);
		
		//GET FULL URL 
		$host13=$_SERVER['HTTP_HOST'];
		$url13 = $_SERVER['REQUEST_URI'];
		$full_url13= $host13.$url13;
		
		$url = base_url()."index.php/login";
		
		
		$user_nik_agent = $_SERVER['HTTP_USER_AGENT'];

    	$browser_array  =   array(
							'/FxiOS/i'      =>  'Firefox'
                        );
						
		foreach ($browser_array as $regex => $value) {
			if (preg_match($regex, $user_nik_agent)) {
				$data['browser']    =   $value;
			}
		}
		
		
		//Recommended Browser Lock
		if($data['browser'] != 'Firefox'){
			echo "Please Run the Purchase Module In Browser Mozila Firefox";
			die;
		}
		
		$sql_user_det = "select id,user_type,name,email from tipldb..login where email like '$user_name%' and  emp_active = 'Yes'";
		$qry_user_det = $ci->db->query($sql_user_det);
		
		foreach($qry_user_det->result() as $row){
			$user_id =  $row->id;
			$user_type = $row->user_type;
			$name = $row->name;
			$email = $row->email;
		} 
		
		if($user_name != ''){
			
			$sql="insert into tipldb..user_act_pur(session_name,session_usr_type,session_usr_id,
			user_id,user_name,user_type,user_email,login_date_time,ip,host_name,operating_system,browser,url)
			values('".$user_name."','".$user_type."','".$user_id."','".$user_id."','".$user_name."','".$user_type."',
			'".$email."','".$datetime."','".$ip."','".$host_name."','".$data['os']."','".$data['browser']."','".$full_url13."')";
			
			$query = $ci->db->query($sql);
			
			return $query;
			
		} else {
			echo "Session Expire!! Please Re-login In the Purchase Module";
			//header('Location:'.$url);
			die;
		}
		
    }
	//End of helper functions		
}