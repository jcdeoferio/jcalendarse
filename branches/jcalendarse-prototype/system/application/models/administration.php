<?php
class Administration extends Model{
  function Administration(){
    parent::Model();
  }

  function select_all_users(){
    $this->db->select('userid, login');
    $this->db->from('users');
    
    $query = $this->db->get();
    return($query->result_array());
  }

  function select_all_users_of_group($groupid){
    $this->db->select('userid, login');
    $this->db->from('users inner join member_of using (groupid)');
    $this->db->where('groupid', $groupid);

    $query = $this->db->get();
    return($query->result_array());
  }

  function select_all_groups(){
    $this->db->select('groupid, groupname');
    $this->db->from('groups');

    $query = $this->db->get();
    return($query->result_array());
  }
  
  function add_user($login, $password, $groups = null){
    $this->db->set('login', $login);
    $this->db->set('password', $password);
    $this->db->insert('users');

    if($groups){
      $this->db->select('userid');
      $this->db->from('users');
      $this->db->where('userid = (select max(userid) from users)');

      $userid = $this->db->get();
      $userid = $userid->row_array();
      $userid = $userid['userid'];

      foreach($groups as $group){
	$this->db->set('userid', $userid);
	$this->db->set('groupid', $group);
	$this->db->insert('member_of');
      }
    }
  }
  
  function delete_user($userid){
    $this->db->where('userid', $userid);
    $this->db->delete('permissions');
    
    $this->db->where('userid', $userid);
    $this->db->delete('member_of');
    
    $this->db->where('userid', $userid);
    $this->db->delete('users');
    
    $this->db_maintenance();
  }
  
  function add_group($groupname){
    
  }

  function delete_group($groupid){
    $this->db->where('groupid', $groupid);
    $this->db->delete('permissions');

    $this->db->where('groupid', $groupid);
    $this->db->delete('member_of');

    $this->db->where('groupid', $groupid);
    $this->db->delete('groups');

    $this->db_maintenance();
  }
  
  function db_maintenance(){
    //when no one can see an event
    $query = $this->db->query('select e.eventid from events e where (select count(p.eventid) from permissions p where p.eventid = e.eventid) = 0');
    
    //delete it
    foreach($query->row_array() as $eventid){
      $this->db->where('eventid', $eventid);
      $this->db->delete('events');
    }
  }
}
?>
