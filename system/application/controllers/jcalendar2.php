<?php
class jcalendar2 extends Controller{
  private $template;

  function jcalendar2(){
    parent::Controller();
    $this->load->model('JCalendar');
    $this->load->model('Administration');

    if($this->session->userdata('user'))
      $this->user = $this->session->userdata('user');
    else
      redirect('/login/logg');

    $this->template['user'] = $this->user;
    $this->months_array_reverse = months_array_reverse();
    $this->days_array_reverse = days_array_reverse();
    $this->months_array = months_array();
    $this->current_date = getdate(time());
    define('CURRENT_YEAR', $this->current_date['year']);
    define('CURRENT_MONTH', $this->months_array_reverse[$this->current_date['month']]);
  }

  function index(){
    redirect('/jcalendar2/calendar');
  }

  function test(){
    $A = $this->JCalendar->select_events_by_criteria($this->user['userid'], 'to be', null, null, null, null, null);
    $B = $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], 'to be', null, null, null, null, null);
    print_r($A);
    echo br(1);
    print_r($B);
    echo br(1);
    print_r(array_unique(array_merge_recursive($A, $B)));
  }

  function calendar($mode = 'M', $year = CURRENT_YEAR, $month = CURRENT_MONTH, $day = null, $group = 'A', $sortby = 'eventid'){
    $events = array();
    if(!$day){
      $day = getdate();
      $day = $day['mday'];
    }
    $date = getdate(mktime(null,null,null,$month,$day,$year));
    $groups = $this->JCalendar->get_group_by_userid($this->user['userid']);
    switch($mode){
    case 'L':
			if($group == 'P')
				$events = $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,null);
			else if($group == 'A')
			  $events = array_merge_recursive($this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, null, null), $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,null));
			else
				$events = $this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, $group?array(''=>$group):null, null);
			$permissions = array();
			foreach($events as $event)
				$permissions[$event['eventid']] = count($this->JCalendar->get_permissions($this->user['userid'],$event['eventid']));
			$data['permissions'] = isset($permissions)?$permissions:null;
//      $events = $this->JCalendar->select_all_events($this->user['userid']);
      break;
    case 'M':
      for($i = 1; $i <= cal_days_in_month(0, $month, $year); $i++){
				if($group == 'P')
					$events[$i] = $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,$year.'-'.$month.'-'.$i);
				else if($group == 'A')
				  $events[$i] = array_merge_recursive($this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, null, $year.'-'.$month.'-'.$i), $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,$year.'-'.$month.'-'.$i));
				else
					$events[$i] = $this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, $group?array(''=>$group):null, $year.'-'.$month.'-'.$i);
      }
      break;
    case 'W':
      for($i = $date['mday']-$date['wday']<1?1:$date['mday']-$date['wday']; $i <= $date['mday']-$date['wday']+6 && $i <= cal_days_in_month(0,$month,$year); $i++){
				if($group == 'P')
					$events[$i] = $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,$year.'-'.$month.'-'.$i);
				else if($group == 'A')
				  $events[$i] = array_merge_recursive($this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, null, $year.'-'.$month.'-'.$i), $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,$year.'-'.$month.'-'.$i));
				else
					$events[$i] = $this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, $group?array(''=>$group):null, $year.'-'.$month.'-'.$i);
      }
      break;
    case 'D':
			if($group == 'P')
				$events[$day] = $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,$year.'-'.$month.'-'.$day);
			else if($group == 'A')
			  $events[$day] = array_merge_recursive($this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, null, $year.'-'.$month.'-'.$day), $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], null, null, null, null,$year.'-'.$month.'-'.$day));
			else
				$events[$day] = $this->JCalendar->select_events_by_criteria($this->user['userid'], null, null, null, null, $group?array(''=>$group):null, $year.'-'.$month.'-'.$day);
      break;
    }
    $data['firstday'] = date_create($year.'-'.$month.'-'.'01');
    $data['firstday'] = $this->days_array_reverse[$data['firstday']->format('D')];
    $data['events'] = $mode == 'L' ? sorty($events,$sortby):$events;
    $data['year'] = $year;
    $data['month'] = $month;
		$data['day'] = $day;
		$data['date'] = $date;
		$data['monthstr'] = $this->months_array[substr($month, 0, 1)=='0'?substr($month, 1, 1):$month];
    $data['user'] = $this->user;
    $data['mode'] = $mode;
		$data['group_arg'] = $group;
		$data['today'] = getdate();
	
    $this->db->from('userdetails');
    $this->db->where('userid', $this->user['userid']);
    $userdetails = $this->db->get()->row_array();
    $sidedata = $data;
    $sidedata['rss'] = $userdetails['rssfeed'];
    $sidedata['groups'] = $groups;
    $this->template['title'] = 'jCalendar';
    $this->template['sidebar'] = $this->load->view('/jcalendar/index_sidebar', $sidedata+$data, true);
    $this->template['body'] = $this->load->view('/jcalendar/index', $data, true);
    $this->load->view('template', $this->template);
  }

  function add(){
    $this->form_validation->set_error_delimiters('<span id="formError"><b>','<br/></b></span>');
    $this->form_validation->set_rules('event_name', 'Event Name', 'required');
    $this->form_validation->set_rules('start_year', 'Start Year', 'required');
    $this->form_validation->set_rules('start_month', 'Start Month', 'required');
    $this->form_validation->set_rules('start_day', 'Start Day', 'required');
    $this->form_validation->set_rules('start_hour', 'Start Hour', 'required');
    $this->form_validation->set_rules('start_minute', 'Start Minute', 'required');
    $this->form_validation->set_rules('end_year', 'End Year', 'required');
    $this->form_validation->set_rules('end_month', 'End Month', 'required');    
    $this->form_validation->set_rules('end_day', 'End Day', 'required');
    $this->form_validation->set_rules('end_hour', 'End Hour', 'required');
    $this->form_validation->set_rules('end_day', 'End Minute', 'required|callback__date_check');
    $this->form_validation->set_rules('event_details', 'Event Details', '');
    $this->form_validation->set_rules('venue', 'Venue', '');
    $this->form_validation->set_rules('userid', '', 'callback__group_check');
    $data = array('success' => FALSE);
    $groups = $this->JCalendar->get_group_by_userid($this->user['userid']);
    if($this->form_validation->run()){
      $start_date = $this->input->post('start_year') . '-' .
	$this->input->post('start_month') . '-' .
	$this->input->post('start_day') . ' ' .
	$this->input->post('start_hour') . ':' .
	$this->input->post('start_minute');
      $end_date = $this->input->post('end_year') . '-' .
	$this->input->post('end_month') . '-' .
	$this->input->post('end_day') . ' ' .
	$this->input->post('end_hour') . ':' .
	$this->input->post('end_minute');
      $event_name = $this->input->post('event_name');
      $event_details = $this->input->post('event_details');
      $venue = $this->input->post('venue');
      $group = array();
      $i = 0;
      foreach($groups as $grp){
	if($this->input->post('group-'.$grp['groupid']))
	  $group[$i++] = $grp['groupid'];
      }
      $this->JCalendar->add_event($this->input->post('personal_event')?$this->user['userid']:null, $event_name, $start_date, $end_date, $event_details, $venue, $group);
      $data['event_name']= $event_name;
      $data['success'] = true;
    }
    else{
      if (!empty($_POST))
	$data['error'] = true;
    }
    $venues = array('' => '');
    foreach($this->JCalendar->select_all_venues() as $venue)
      $venues[$venue['venueid']] = $venue['venue_name'];

    $data['venues'] = $venues;
    $data['user'] = $this->user;
    $data['groups'] = $groups;
    $this->template['title'] = 'Add Event';
    $this->template['sidebar'] = $this->load->view('/jcalendar/add_sidebar', '', true);
    $this->template['body'] = $this->load->view('/jcalendar/add', $data, true);
    $this->load->view('template', $this->template);
  }

  function update($id){
    $permissions = $this->JCalendar->get_permissions($this->user['userid'], $id);

    if(!$permissions){
      $data['user'] = $this->user;
      $this->template['title'] = 'Update Entry';
      $this->template['sidebar'] = $this->load->view('jcalendar/update_sidebar', '', true);
      $this->template['body'] = '<div style="color:red">You do not have permission to edit this event</div>';
      $this->load->view('template', $this->template);      
    }
    else{
      $this->form_validation->set_error_delimiters('<span id="formError"><b>','<br/></b></span>');
      $this->form_validation->set_rules('event_name', 'Event Name', 'required');
      $this->form_validation->set_rules('start_year', 'Start Year', 'required');
      $this->form_validation->set_rules('start_month', 'Start Month', 'required');
      $this->form_validation->set_rules('start_day', 'Start Day', 'required');
      $this->form_validation->set_rules('start_hour', 'Start Hour', 'required');
      $this->form_validation->set_rules('start_minute', 'Start Minute', 'required');
      $this->form_validation->set_rules('end_year', 'End Year', 'required');
      $this->form_validation->set_rules('end_month', 'End Month', 'required');    
      $this->form_validation->set_rules('end_day', 'End Day', 'required');
      $this->form_validation->set_rules('end_hour', 'End Hour', 'required');
      $this->form_validation->set_rules('end_day', 'End Minute', 'required|callback__date_check');
      $this->form_validation->set_rules('event_details', 'Event Details', '');
      $this->form_validation->set_rules('venue', 'Venue', '');
      $this->form_validation->set_rules('userid', '', 'callback__group_check');

      $data['id'] = $id;
      $groups = $this->JCalendar->get_group_by_userid($this->user['userid']);
      if ($this->form_validation->run()){
	$start_date = $this->input->post('start_year') . '-' .
	  $this->input->post('start_month') . '-' .
	  $this->input->post('start_day') . ' ' .
	  $this->input->post('start_hour') . ':' .
	  $this->input->post('start_minute');
	$end_date = $this->input->post('end_year') . '-' .
	  $this->input->post('end_month') . '-' .
	  $this->input->post('end_day') . ' ' .
	  $this->input->post('end_hour') . ':' .
	  $this->input->post('end_minute');
	$event_name = $this->input->post('event_name');
	$event_details = $this->input->post('event_details');
	$venue = $this->input->post('venue');
	$group = array();
	$i = 0;
	foreach ($groups as $grp)
	  if($this->input->post('group-'.$grp['groupid']))
	    $group[$i++] = $grp['groupid'];

	$update_data = array(	'eventname'=>$event_name,
				'start_date'=>$start_date,
				'end_date'=>$end_date,
				'eventdetails'=>$event_details,
				'venueid'=>$venue==''?null:$venue);
			
	$this->JCalendar->update_event($id, $update_data, $this->input->post('personal_event')?$this->user['userid']:null, $group);

	$data['success'] = TRUE;
	$data['event_name'] = $event_name;
	$data['start_year'] = $this->input->post('start_year');
	$data['start_month'] = $this->input->post('start_month');
	$data['start_day'] = $this->input->post('start_day');
	$data['start_hour'] = $this->input->post('start_hour');
	$data['start_minute'] = $this->input->post('start_minute');
	$data['end_year'] = $this->input->post('end_year');
	$data['end_month'] = $this->input->post('end_month');
	$data['end_day'] = $this->input->post('end_day');
	$data['end_hour'] = $this->input->post('end_hour');
	$data['end_minute'] = $this->input->post('end_minute');
	$data['event_details'] = $this->input->post('event_details');
	$data['venue'] = $this->input->post('venue');
	$permissions = $this->JCalendar->get_permissions($this->user['userid'], $id);
      }
      else{
	$event = $this->JCalendar->select_event_by_id($this->user['userid'], $id);
	$data['event_name'] = $event['eventname'];
	$start_timestamp = explode(' ', $event['start_date']);
	$start_date = explode('-', $start_timestamp[0]);
	$data['start_year'] = $start_date[0];
	$data['start_month'] = $start_date[1];
	$data['start_day'] = $start_date[2];
	$start_time = explode(':', $start_timestamp[1]);
	$data['start_hour'] = $start_time[0];
	$data['start_minute'] = $start_time[1];
	$end_timestamp = explode(' ', $event['end_date']);
	$end_date = explode('-', $end_timestamp[0]);
	$data['end_year'] = $end_date[0];
	$data['end_month'] = $end_date[1];
	$data['end_day'] = $end_date[2];
	$end_time = explode(':', $end_timestamp[1]);
	$data['end_hour'] = $end_time[0];
	$data['end_minute'] = $end_time[1];      
	$data['event_details'] = $event['eventdetails'];
	$data['venue'] = $event['venueid'];
	$data['success'] = FALSE;
      }

      $venues = array('' => '');
      foreach($this->JCalendar->select_all_venues() as $venue)
	$venues[$venue['venueid']] = $venue['venue_name'];

      $data['venues'] = $venues;
      $data['groups'] = $groups;
      $data['permissions'] = isset($permissions)?$permissions:null;
      $data['user'] = $this->user;
      $this->template['title'] = 'Update Entry';
      $this->template['sidebar'] = $this->load->view('jcalendar/update_sidebar', '', true);
      $this->template['body'] = $this->load->view('jcalendar/update', $data, true);
      $this->load->view('template', $this->template);
    }
  }

  function delete($id){
    $permissions = $this->JCalendar->get_permissions($this->user['userid'], $id);

    if(!$permissions){
      $this->template['body'] = '<div style="color:red">You do not have permission to delete this event</div>';
    }
    else{
      $this->JCalendar->delete_event($id);
      $this->template['body'] = $this->load->view('/jcalendar/delete', '', true);
    }
    $this->template['sidebar'] = $this->load->view('jcalendar/update_sidebar', '', true);
    $this->template['title']  = 'Delete Event';
    $this->load->view('template', $this->template);
  }

  function event($eventid){
    $event = $this->JCalendar->select_event_by_id($this->user['userid'], $eventid);
    $data['event'] = $event;
    $data['user'] = $this->user;
    $this->template['title'] = $event['eventname'];
    $this->template['sidebar'] = 
			(count($this->JCalendar->get_permissions($this->user['userid'],$eventid)) ?
			        anchor('jcalendar2/update/'. $event['eventid'], 'update event').br(1).
				anchor('jcalendar2/delete/' . $event['eventid'], 'delete event', array('onClick'=>"return (confirm('Are you sure you want to delete this event?'))")).br(1) : '').
      anchor('jcalendar2/index', 'back to calendar');
    $this->template['body'] = $this->load->view('/jcalendar/event', $data, TRUE);
    $this->load->view('template', $this->template);
  }

  function adsearch(){
    $this->form_validation->set_error_delimiters('<span id="formError"><b>','<br/></b></span>');  
    $this->form_validation->set_rules('event_name', 'Event Name', 'xss_clean');
    $this->form_validation->set_rules('start_year', 'Start Year', '');
    $this->form_validation->set_rules('start_month', 'Start Month', '');
    $this->form_validation->set_rules('start_day', 'Start Day', '');
    $this->form_validation->set_rules('start_hour', 'Start Hour', '');
    $this->form_validation->set_rules('start_minute', 'Start Minute', '');
    $this->form_validation->set_rules('end_year', 'End Year', '');
    $this->form_validation->set_rules('end_month', 'End Month', '');    
    $this->form_validation->set_rules('end_day', 'End Day', '');
    $this->form_validation->set_rules('end_hour', 'End Hour', '');
    $this->form_validation->set_rules('end_day', 'End Minute', 'callback__date_check');

    $events = null;
    $groups = $this->JCalendar->get_group_by_userid($this->user['userid']);
    
    if($this->form_validation->run()){
      $event_name = null;
      if($this->input->post('event_name') != '')
				$event_name = $this->input->post('event_name');
      
      $start_date = null;
      if($this->input->post('start_month') != '')
				$start_date = $this->input->post('start_year') . '-' .
					$this->input->post('start_month') . '-' .
					$this->input->post('start_day') . ' ' .
					(strlen($this->input->post('start_hour'))?($this->input->post('start_hour') . ':' .
					(strlen($this->input->post('start_minute'))?$this->input->post('start_minute'):'00')):'');
      $end_date = null;
      if($this->input->post('end_month') != '')
				$end_date = $this->input->post('end_year') . '-' .
					$this->input->post('end_month') . '-' .
					$this->input->post('end_day') . ' ' .
					(strlen($this->input->post('end_hour'))?($this->input->post('end_hour') . ':' .
					(strlen($this->input->post('end_minute'))?$this->input->post('end_minute'):'00')):'');
			$group = array();
			$i = 0;
			foreach($groups as $grp)
				if($this->input->post('group-'.$grp['groupid']))
					$group[$i++] = $grp['groupid'];
			if(count($group) == 0 && !$this->input->post('personal_event'))
				$events = $this->JCalendar->select_events_by_criteria($this->user['userid'],$event_name,$start_date,$end_date);
			else{
				if($this->input->post('personal_event'))
					$events = $this->JCalendar->select_personal_events_by_criteria($this->user['userid'], $event_name,$start_date,$end_date,null,null);
				if(count($group) != 0){
					$add_events = $this->JCalendar->select_events_by_criteria($this->user['userid'], $event_name, $start_date, $end_date, null, $group);
					$i = count($events);
					foreach($add_events as $x){
						$t = false;
						if(isset($events))
							foreach($events as $e)
								if($e['eventid'] == $x['eventid'])
									$t = true;
						if(!$t)
							$events[$i++] = $x;
					}
				}
			}
			
			foreach($events as $event)
				$permissions[$event['eventid']] = count($this->JCalendar->get_permissions($this->user['userid'],$event['eventid']));
			$data['permissions'] = isset($permissions)?$permissions:null;
    }
		$groups = count($groups) == 0 ? null:$groups;
//    $newgroups = array(''=>'');
//    if(count($groups) == 0)
//      $newgroups = null;
//    else
//      $newgroups = $groups;
    //		foreach ($groups as $dat)
    //			$newgroups[$dat['groupid']] = $dat['groupname'];		#should the public events be contained in a group instead as a user?
    $data['groups'] = $groups;
    $data['events'] = $events;
    $data['user'] = $this->user;
    $this->template['title'] = 'Advanced Search';
    $this->template['sidebar'] = anchor('jcalendar2/index', 'back to calendar');
    $this->template['body'] = $this->load->view('jcalendar/adsearch', $data, true);
    $this->load->view('template', $this->template);
  }

  //will check if end date is on or after start date and may check other date things
  //like which months have 30 days etc
  function _date_check(){ 
    $this->form_validation->set_message('_date_check', 'End date must come after Start date.');
    return $this->input->post('end_year') >= $this->input->post('start_year') && $this->input->post('end_month') >= $this->input->post('start_month') && $this->input->post('end_day') >= $this->input->post('start_day') && $this->input->post('end_hour') >= $this->input->post('start_hour') && $this->input->post('end_minute') >= $this->input->post('start_minute');
  }

  function _group_check($userid){
    if($this->input->post('personal_event'))
      return(true);
    else{
      foreach($this->JCalendar->get_group_by_userid($userid) as $group)
				if($this->input->post('group-'.$group['groupid']))
					return(true);
      $this->form_validation->set_message('_group_check', 'You must check personal or at least one group otherwise the event will be unviewable.');
      return (false);
    }
  }
  
  function getcal($feed){
    $this->load->helper('file');
    $this->load->helper('download');
		
    $userid = $this->db->query("SELECT userid from userdetails WHERE rssfeed = '".$feed."'")->row_array();
    $userid = $userid['userid'];
				
    $events = $this->JCalendar->select_all_events($userid);
    write_file('files/temp',"BEGIN:VCALENDAR\nVERSION:2.0\n");
    foreach($events as $event){
      write_file('files/temp',"\nBEGIN:VEVENT",'a');
      write_file('files/temp',"\nUID:{".random_string('unique')."}",'a');
      $startdate = substr($event['start_date'], 0, strlen('yyyy')).substr($event['start_date'], 5, strlen('mm')).substr($event['start_date'], 8, strlen('dd')).'T'.substr($event['start_date'], 11, strlen('hh')).substr($event['start_date'], 14, strlen('mm')).'00Z';
			
      $enddate = substr($event['end_date'], 0, strlen('yyyy')).substr($event['end_date'], 5, strlen('mm')).substr($event['end_date'], 8, strlen('dd')).'T'.substr($event['end_date'], 11, strlen('hh')).substr($event['end_date'], 14, strlen('mm')).'00Z';
      write_file('files/temp',"\nSUMMARY:".$event['eventname'],'a');
      write_file('files/temp',"\nDESCRIPTION:".str_replace(array("\r\n", "\n", "\r"),'\\n',$event['eventdetails']),'a');		
      write_file('files/temp',"\nDTSTART:".$startdate,'a');
      write_file('files/temp',"\nDTEND:".$enddate,'a');
      write_file('files/temp',"\nEND:VEVENT\n",'a');
    }
    write_file('files/temp',"\nEND:VCALENDAR",'a');
		
    $data = file_get_contents("files/temp"); // Read the file's contents
    $name = 'calendar.ics';
    force_download($name, $data); 
		
  }
  }
?>
