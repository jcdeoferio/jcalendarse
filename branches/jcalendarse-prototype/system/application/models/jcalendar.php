<?php
class JCalendar extends Model{
  function JCalendar(){
    parent::Model();
    $this->load->helper('string');
  }

  function select_event_by_id($userid, $eventid){
    $query = $this->db->query('select events.*, venues.venue_name from events left join venues using (venueid) inner join permissions p using (eventid), member_of m where ((p.groupid = m.groupid or p.userid = m.userid and m.userid = '.$userid.') or p.userid = -1) and eventid = '.$eventid);

    return($query->row_array());
  }

  function select_events_by_criteria($userid, $event_name, $start_date, $end_date, $venue, $groups = null, $date = null){
    $this->db->select('events.*, venues.venue_name');
    $this->db->distinct();
    $this->db->from('events left join venues using (venueid) inner join permissions p using (eventid), member_of m');
    $this->db->where('(((p.groupid = m.groupid or p.userid = m.userid) and m.userid = '.$userid.') or p.userid = -1)', null, false);

    if($event_name)
      $this->db->where('eventname ilike', '%'.$event_name.'%');
    if($start_date)
      $this->db->where('start_date >=', $start_date);
    if($end_date)
      $this->db->where('end_date <=', $end_date);
    if($venue)
      $this->db->where('venueid', $venue);

    if($groups){
      $where_str = '(';
      $i = 0;
      foreach($groups as $group){
	$where_str .= ($i != 0 ? ' or ':'').'p.groupid = '.$group;
	$i++;
      }
      $where_str .= ' )';
			
      $this->db->where($where_str, null, false);
    }
		
    if($date){
      $this->db->where('start_date <=',$date);
      $this->db->where('end_date >=',$date);
    }

    $this->db->order_by('start_date', 'asc');

    $query = $this->db->get();
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
	
  function select_courses($college = null){
    $query_str = "SELECT courses.* FROM courses";
    if($college)
      $query_str .= ",colleges,course_member_of WHERE colleges.collegename ilike '%".$college."%' AND colleges.collegeid = course_member_of.collegeid AND courses.courseid = course_member_of.courseid";
    $res = $this->db->query($query_str);
    return $res->result_array();
  }
	
  function select_courses_byid($college = null){
    $query_str = "SELECT courses.* FROM courses";
    if($college)
      $query_str .= ",colleges WHERE colleges.collegeid = ".$college." AND colleges.collegeid = courses.collegeid";
    $res = $this->db->query($query_str);
    return $res->result_array();
  }
	
  function select_colleges($college = null){
    $query_str = "SELECT colleges.* FROM colleges";
    if($college)
      $query_str .= " WHERE colleges.collegename ilike '%".$college."%'";
    $res = $this->db->query($query_str);
    return $res->result_array();
  }
	
  function select_colleges_byid($college = null){
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
	
  function add_event($userid = null, $event_name, $start_date, $end_date, $event_details = null, $venue = null, $groupids = null){
    $this->db->set('eventname', $event_name);
    $this->db->set('start_date', $start_date);
    $this->db->set('end_date', $end_date);
    $this->db->set('eventdetails', $event_details);
    $this->db->set('venueid', $venue == '' ? null: $venue);
    $this->db->insert('events');
    $eventid_query = $this->db->query('select eventid from events where eventid in (select max(eventid) from events)');
    $eventid = $eventid_query->row_array();
    $eventid = $eventid['eventid'];    
    if($userid != null){
      $this->db->set('eventid', $eventid);
      $this->db->set('userid', $userid);
      $this->db->insert('permissions');
    }
    if($groupids != null){
      foreach($groupids as $groupid){
	$this->db->set('eventid', $eventid);
	$this->db->set('groupid', $groupid);
	$this->db->insert('permissions');
      }
    }
  }

  function update_event($eventid, $data){
    $this->db->where('eventid', $eventid);
    $this->db->update('events', $data);
  }

  function delete_event($eventid){
    $this->db->where('eventid', $eventid);
    $this->db->delete('permissions');
    $this->db->where('eventid', $eventid);
    $this->db->delete('events');
  }
  function get_group_by_userid($userid){
    $this->db->select('groups.groupid,groupname,grouproleid');
    $this->db->distinct();
    $this->db->from('member_of left join groups using (groupid)');
    $this->db->where('userid', $userid);
    $q = $this->db->get();
    return $q->result_array();
  }
  }
?>
