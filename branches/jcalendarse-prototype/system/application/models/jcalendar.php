<?php
class JCalendar extends Model{
  function JCalendar(){
    parent::Model();
  }

  function select_event_by_id($userid, $eventid){
    $this->db->select('events.*, venues.venue_name');
    //events with venues with permissions X group membership table
    $this->db->from('events left join venues using (venueid) inner join permissions p using (eventid), member_of m');
    //selecting from that table
    $this->db->where('p.groupid = m.groupid or p.userid = m.userid');
    $this->db->where('eventid', $eventid);
    //check permissions
    $this->db->where('m.userid', $userid);

    $query = $this->db->get();
    return($query->row_array());
  }

  function select_events_by_criteria($userid, $event_name, $start_date, $end_date, $venue){
    $this->db->from('events left join venues using (venueid) inner join permissions p using (eventid), member_of m');
    $this->db->where('p.groupid = m.groupid or p.userid = m.userid');
    $this->db->where('m.userid', $userid);
    if($event_name)
      $this->db->like('eventname', $event_name);
    if($start_date)
      $this->db->where('start_date >= '.$start_date);
    if($end_date)
      $this->db->where('end_date <= '.$end_date);
    if($venue)
      $this->db->where('venueid', $venue);
    $this->db->order_by('start_date', 'asc');

    $query = $this->db->get();
    return($query->result_array());
  }

  function select_all_events($userid){
    return($this->select_events_by_criteria($userid, null, null, null, null));
  }
      
  function select_events_by_name($userid, $name){
    return ($this->select_events_by_criteria($userid, $name, null, null, null));
  }

  function select_events_by_range($userid, $start_date, $end_date){
    return($this->select_events_by_criteria($userid, null, $start_date, $end_date, null));
  }

  function select_events_by_venue($userid, $venue){
    return($this->select_events_by_criteria($userid, null, null, null, $venue));
  }

  function check_rss_data($data){
    $this->db->from('users');
    $this->db->where('md5(login || password)', $data);

    return($this->db->count_all_results() > 0);
  }

  function check_permissions_rss($eventid, $data){
    $this->db->from('users');
    $this->db->where('md5(login || password)', $data);
	
    $user = $this->db->get();
    $user = $result->row_array();
	
    return($this->check_permissions($eventid, $result['userid']));
  }

  function check_permissions($eventid, $userid){
    //events with their permissions X group membership table
    $this->db->from('events inner join permissions p using (eventid), member_of m');
    //selecting from that table
    $this->db->where('p.groupid = m.groupid or p.userid = m.userid');
    $this->db->where('eventid', $eventid);
    //does this user have permissions
    $this->db->where('m.userid', $userid);
	
    return($this->db->count_all_results() > 0);
  }

  function add_event($event_name, $start_date, $end_date, $venue = null){
    $data = array('eventname' => $event_name,
		  'start_date' => $start_date,
		  'end_date' => $end_date,
		  'venueid' => $venue);

    $this->db->insert('events', $data);
  }

  function update_event($eventid, $data){
    $this->db->where('eventid', $eventid);
    $this->db->update('events', $data);
  }

  function delete_event($eventid){
    $this->db->where('eventid', $eventid);
    $this->db->delete('events');
  }

  function add_user($login, $password){
    
  }
}
?>
