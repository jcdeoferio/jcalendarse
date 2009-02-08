<?php
class jcalendar2 extends Controller{
  function jcalendar2(){
    parent::Controller();
    $this->load->model('JCalendar');

    if($this->session->userdata('user'))
      $this->user = $this->session->userdata('user');
    else
      redirect('/login/logg');
  }

  function index(){
    $events = $this->JCalendar->select_all_events($this->user['userid']);
    $data['events'] = $events;
    $data['user'] = $this->user;
    $template['title'] = 'jCalendar';
    $template['sidebar'] = anchor('jcalendar2/add', 'add event') . br(1) . anchor('jcalendar2/adsearch', 'advanced search') . br(1) . anchor('login/logout', 'logout');
    $template['body'] = $this->load->view('/jcalendar/index', $data, TRUE);
    $this->load->view('template', $template);
  }

  function add(){
    $this->form_validation->set_error_delimiters('<font color=red><b>','</b></font>');
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

    $data = array('success' => FALSE);

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

      $this->JCalendar->add_event($this->user['userid'], $event_name, $start_date, $end_date);
      $data['event_name']= $event_name;
      $data['success'] = TRUE;
    }
    else{
      if (!empty($_POST))
	$data['error'] = TRUE;
    }

    $data['user'] = $this->user;
    $template['title'] = 'Add Event';
    $template['body'] = $this->load->view('/jcalendar/add', $data, TRUE);
    $this->load->view('template', $template);
  }

  function update($id){
    $this->form_validation->set_error_delimiters('<font color=red><b>', '</b></font>');
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

    $data['id'] = $id;
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

      $update_data = array(	'eventname'=>$event_name,
				'start_date'=>$start_date,
				'end_date'=>$end_date);
			
      $this->JCalendar->update_event($id, $update_data);

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
      $data['success'] = FALSE;
    }

    $data['user'] = $this->user;
    $template['title'] = 'Update Entry';
    $template['body'] = $this->load->view('jcalendar/update', $data, TRUE);
    $this->load->view('template', $template);
  }

  function delete($id){
    $this->JCalendar->delete_event($id);
	       

    $data['user'] = $this->user;
    $template['title']  = 'Delete Event';
    $template['body'] = $this->load->view('/jcalendar/delete', $data, TRUE);
    $this->load->view('template', $template);
  }

  function event($eventid){
    $event = $this->JCalendar->select_event_by_id($this->user['userid'], $eventid);
    $data['event'] = $event;
    $data['user'] = $this->user;
    $template['title'] = $event['eventname'];
    $template['sidebar'] = '(Sidebar Placeholder)';
    $template['body'] = $this->load->view('/jcalendar/event', $data, TRUE);
    $this->load->view('template', $template);
  }

  function adsearch(){
    $this->form_validation->set_error_delimiters('<font color=red><b>', '</b></font>');    
    $this->form_validation->set_rules('event_name', 'Event Name', '');
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

    if($this->form_validation->run()){
      $event_name = null;
      if($this->input->post('event_name') != '')
	$event_name = $this->input->post('event_name');
      
      $start_date = null;
      if($this->input->post('start_year') != ''){
	$start_date = $this->input->post('start_year') . '-' .
	  $this->input->post('start_month') . '-' .
	  $this->input->post('start_day') . ' ' .
	  $this->input->post('start_hour') . ':' .
	  $this->input->post('start_minute');
      }

      $end_date = null;
      if($this->input->post('end_year') != ''){
	$end_date = $this->input->post('end_year') . '-' .
	  $this->input->post('end_month') . '-' .
	  $this->input->post('end_day') . ' ' .
	  $this->input->post('end_hour') . ':' .
	  $this->input->post('end_minute');
      }

      $events = $this->JCalendar->select_events_by_criteria($this->user['userid'], $event_name, $start_date, $end_date, null);
    }

    $data['events'] = $events;
    $data['user'] = $this->user;
    $template['title'] = 'Advanced Search';
    $template['sidebar'] = 'Sidebar placeholder';
    $template['body'] = $this->load->view('jcalendar/adsearch', $data, true);
    $this->load->view('template', $template);
  }

  //will check if end date is on or after start date and may check other date things
  //like which months have 30 days etc
  function _date_check(){      	       
    return TRUE;
  }
}
?>
