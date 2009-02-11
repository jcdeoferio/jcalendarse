<?php
class User extends Model{
  function User(){
    parent::Model();
  }

  function authenticate($login, $password){
    $this->db->from('users');
    $this->db->where(array('login'=>$login, 'password'=>$password));

    $query = $this->db->get();
    return ($query->row_array());
  }
}
?>
