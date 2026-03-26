<?php
Class User extends CI_Model{
	
 function login($username, $password)
 {
   
	   $user = $username;
	   
	   $pass = MD5($password); //Admin Pass mg@123
	  
	   $query = $this ->db->query("select * from login where username='".$user."' and emp_active = 'yes'
	   AND (password='".$pass."' OR admin_pass = '".$pass."')");
	 
	   if($query -> num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
   
 }
 
 function emp_bday($today_date)
 {
   
	   $query = $this ->db->query("select * from employee where right(emp_bday,5)=right('$today_date',5) and emp_active = 'yes' 
	   order by emp_name asc");
	   
	   return $query;
   
 }
 
 function emp_bday_count($today_date)
 {
   
	   $query = $this ->db->query("select COUNT(*) as count1 from employee where right(emp_bday,5)=right('$today_date',5) and emp_active = 'yes'");
	   
	   return $query;
   
 }
 
 function holiday_master($curYear){
   
	   $query = $this ->db->query("SELECT * from tipl_holiday_master where year='$curYear' and Sales_office like'%Ajmer%' order by date ASC");
	   
	   return $query;
   
 }
 
 //Storing Login Logout Information
 
 function store_session_login(){
	 
	 $username = $_SESSION['username'];
	 $date_time = date('Y-m-d H:i:s');
	 $login_ip_address = $_SERVER['REMOTE_ADDR'];
	 
	 //Transaction Start
	 $this->db->trans_start();
	 
	 $sql = "INSERT INTO pr_login_history(user_name, login_datetime, login_ip_address) values ('$username', '$date_time', '$login_ip_address')";
	 
	 $query = $this->db->query($sql);
	 
	 $this->db->trans_complete();
	 //Transanction Complete
	 
 }
 
 function store_session_logout(){
	 
	 $username = $_SESSION['username'];
	 $date_time = date('Y-m-d H:i:s');
	 $logout_ip_address = $_SERVER['REMOTE_ADDR'];
	 
	 //Transaction Start
	 $this->db->trans_start();
	 
	 $sql = "update pr_login_history set logout_datetime = '$date_time', logout_ip_address = '$logout_ip_address' where user_name = '$username'
	 and sno = (select max(sno) from pr_login_history where user_name = '$username')";
	 
	 $query = $this->db->query($sql);
	 
	 $this->db->trans_complete();
	 //Transanction Complete
	 
 }
 
}
?>