<?php
class JCalendar extends Model{
  function JCalendar(){
    parent::Model();
  }

  function select_event_by_id($userid, $eventid){
    $query = $this->db->query('select events.*, venues.venue_name from events left join venues using (venueid) inner join permissions p using (eventid), member_of m where ((p.groupid = m.groupid or p.userid = m.userid and m.userid = '.$userid.') or p.userid = -1) and eventid = '.$eventid);

    return($query->row_array());
  }

  function select_events_by_criteria($userid, $event_name, $start_date, $end_date, $venue){
    $query_str = 'select distinct events.*, venues.venue_name from events left join venues using (venueid) inner join permissions p using (eventid), member_of m where (((p.groupid = m.groupid or p.userid = m.userid) and m.userid = '.$userid.') or p.userid = -1)';

    if($event_name)
      $query_str .= " and eventname ilike '%".$event_name."%' ";
    if($start_date)
      $query_str .= " and start_date >= '".$start_date."'";
    if($end_date)
      $query_str .= " and end_date <= '".$end_date."'";
    if($venue)
      $query_str .= ' and venueid = '.$venue;
    
    $query_str .= ' order by start_date asc';

    $query = $this->db->query($query_str);
    return($query->result_array());
  }

  function select_all_events($userid){
    return($this->select_events_by_criteria($userid, null, null, null, null));
  }

  function select_all_venues(){
    $this->db->from('venues');
    $query = $this->db->get();

    return($query->result_array());
  }
  
  function select_courses($college){
	$query_str = "SELECT courses.* FROM courses";
	if($college)
	$query_str .= ",colleges,course_member_of WHERE colleges.collegename ilike '%".$college."%' AND colleges.collegeid = course_member_of.collegeid AND courses.courseid = course_member_of.courseid";
	$res = $this->db->query($query_str);
	return $res->result_array();
  
  }
  function select_courses_byid($college){
	$query_str = "SELECT courses.* FROM courses";
	if($college)
	$query_str .= ",colleges,course_member_of WHERE colleges.collegeid = ".$college." AND colleges.collegeid = course_member_of.collegeid AND courses.courseid = course_member_of.courseid";
	$res = $this->db->query($query_str);
	return $res->result_array();
  }
  function select_colleges($college){
	$query_str = "SELECT colleges.* FROM colleges";
	if($college)
	$query_str .= " WHERE colleges.collegename ilike '%".$college."%'";
	$res = $this->db->query($query_str);
	return $res->result_array();
  }
  function select_colleges_byid($college){
	$query_str = "SELECT colleges.* FROM colleges";
	if($college)
	$query_str .= " WHERE colleges.collegeid = ".$college."";
	$res = $this->db->query($query_str);
	return $res->result_array();
  }
        
  function get_user_from_rss_data($data){
    $this->db->from('users');
    $this->db->where('md5(login || password)', $data);

    $query = $this->db->get();
    return($query->row_array());
  }
  function add_user($login,$password,$studentnumber,$firstname,$middlename,$lastname,$courseid,$registered){
	$this->db->set('login',$login);
	$this->db->set('password',$password);
	$this->db->insert('users');
	$userid = $this->db->query('SELECT userid from users WHERE userid in (SELECT max(userid) FROM USERS)')->row_array();
	$userid = $userid['userid'];
	$this->db->set('userid',$userid);
	$this->db->set('firstname',$firstname);
	if($middlename)
		$this->db->set('middlename',$middlename);
	$this->db->set('lastname',$lastname);
	$this->db->set('courseid',$courseid);
	$year = 2;
	$this->db->set('year',$year);
	$this->db->set('studentnumber',$studentnumber);
	if($registered)
		$this->db->set('registered',$registered);
	$this->db->insert('userdetails');
  }
  function add_event($userid, $event_name, $start_date, $end_date, $event_details = null, $venue = null){
    $this->db->set('eventname', $event_name);
    $this->db->set('start_date', $start_date);
    $this->db->set('end_date', $end_date);
    $this->db->set('eventdetails', $event_details);
    $this->db->set('venueid', $venue);
    $this->db->insert('events');

    $eventid_query = $this->db->query('select eventid from events where eventid in (select max(eventid) from events)');
    $eventid = $eventid_query->row_array();
    $eventid = $eventid['eventid'];
    
    $this->db->set('eventid', $eventid);
    $this->db->set('userid', $userid);
    $this->db->insert('permissions');
  }

  function update_event($eventid, $data){
    $this->db->where('eventid', $eventid);
    $this->db->update('events', $data);
  }

  function delete_event($eventid){
    $this->db->where('eventid', $eventid);
    $this->db->delete('events');
  }
}
?>
