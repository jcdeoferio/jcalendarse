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
    $template['title'] = 'JCalendar';
    $template['body'] = $this->load->view('/jcalendar/index', $data, TRUE);
    $this->load->view('template', $template);
  }

  function add(){
    $this->validation->set_error_delimiters('<font color=red><b>','</b></font>');
    $rules['event_name'] = 'required';
    $rules['end_year'] = 'callback__date_check';
    $this->validation->set_rules($rules);

    $data = array('success' => FALSE);

    if($this->validation->run()){
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

      $this->JCalendar->add_event($event_name, $start_date, $end_date);
      $data['event_name']= $event_name;
      $data['success'] = TRUE;
    }
    else{
      if (!empty($_POST)){
	$data['error'] = TRUE;
      }
    }

    $data['user'] = $this->user;
    $template['title'] = 'Add Event';
    $template['body'] = $this->load->view('/jcalendar/add', $data, TRUE);
    $this->load->view('template', $template);
  }

  function update($id){
    $this->validation->set_error_delimiters('<font color=red><b>', '</b></font>');
    $rules['event_name'] = 'required';
    $rules['end_year'] = 'callback__date_check';
    $this->validation->set_rules($rules);

    $data['id'] = $id;
    if ($this->validation->run()){
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
    $template['body'] = $this->load->view('/jcalendar/event', $data, TRUE);
    $this->load->view('template', $template);
  }

  function _date_check(){      	       
    return TRUE;
  }
}
?>
