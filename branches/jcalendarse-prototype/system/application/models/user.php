<?php
class User extends Model{
	function User(){
		parent::Model();
	}

	function authenticate($login, $password){
		$this->db->from('users');
		$this->db->where(array('login'=>$login, 'password'=>$password));  
		$query = $this->db->get();
		$temp = $query->row_array();
	
		$query_str = "SELECT userdetails.registered FROM userdetails,users WHERE users.login = '".$login."' AND users.userid = userdetails.userid";
		$register = $this->db->query($query_str);
		$register = $register->row_array();
		
		extract($register);
		if(isset($registered))
			$temp['registered'] = $registered;
		return ($temp);
	}
}
?>
