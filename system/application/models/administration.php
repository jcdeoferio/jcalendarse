<?php
class Administration extends Model{
  function Administration(){
    parent::Model();
  }

  function select_all_users($limit = 10, $offset = 0){
    $this->db->select('userid, login, studentnumber, firstname, middlename, lastname, collegename, coursename, collegeid, courseid, registered');
    $this->db->from('users left join userdetails using (userid) inner join courses using (courseid) inner join colleges using (collegeid)');
    $this->db->order_by('login', 'asc');
    $this->db->limit($limit, $offset);
    
    $query = $this->db->get();
    return($query->result_array());
  }

  function count_all_users(){
    $this->db->from('users left join userdetails using (userid) inner join courses using (courseid) inner join colleges using (collegeid)');
    
    return($this->db->count_all_results());
  }

  function select_user($userid){
    $this->db->select('userid, login, studentnumber, firstname, middlename, lastname, collegename, coursename, collegeid, courseid, registered');
    $this->db->from('users left join userdetails using (userid) inner join courses using (courseid) inner join colleges using (collegeid)');
    $this->db->where('userid', $userid);
    
    $query = $this->db->get();
    return($query->row_array());
  }

  function select_all_users_of_group($groupid){
    $this->db->select('userid, login');
    $this->db->from('users inner join member_of using (groupid)');
    $this->db->where('groupid', $groupid);
    $this->db->order_by('userid', 'asc');

    $query = $this->db->get();
    return($query->result_array());
  }

  function select_all_groups(){
    $this->db->select('groupid, groupname');
    $this->db->from('groups');
    $this->db->order_by('groupname', 'asc');

    $query = $this->db->get();
    return($query->result_array());
  }

  function member_of($userid, $groupid){
    $this->db->from('member_of');
    $this->db->where('userid', $userid);
    $this->db->where('groupid', $groupid);

    return($this->db->count_all_results());
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

  function update_user($userid, $login, $password, $studentnumber, $firstname, $middlename, $lastname, $courseid, $registered, $groups){
    $this->db->set('studentnumber', $studentnumber);
    $this->db->set('firstname', $firstname);
    $this->db->set('middlename', $middlename);
    $this->db->set('lastname', $lastname);
    $this->db->set('courseid', $courseid);
    $this->db->set('registered', $registered?'true':'false', false);
    $this->db->where('userid', $userid);
    $this->db->update('userdetails');

    $this->db->set('login', $login);
    if($password != md5(''))
      $this->db->set('password', $password);
    $this->db->where('userid', $userid);
    $this->db->update('users');

    $this->db->where('userid', $userid);
    $this->db->delete('member_of');

    foreach($groups as $group){
      $this->db->set('userid', $userid);
      $this->db->set('groupid', $group);
      $this->db->insert('member_of');
    }
  }

  function flip_activation($userid){
    $this->db->set('registered', 'not registered', false);
    $this->db->where('userid', $userid);
    $this->db->update('userdetails');
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
