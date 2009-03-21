<?php
class User extends Model{
  function User(){
    parent::Model();
  }

  function authenticate($login, $password){
    $this->db->from('users');
    $this->db->join('userdetails', 'users.userid = userdetails.userid');
    $this->db->where(array('login'=>$login, 'password'=>$password));  

    $query = $this->db->get();
    return($query->row_array());
  }

  function is_unique_login($login){
    $this->db->from('users');
    $this->db->where('login', $login);

    return($this->db->count_all_results() == 0);
  }
}
?>
