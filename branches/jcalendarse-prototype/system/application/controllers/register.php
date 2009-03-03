<?php
class Register extends Controller{
  private $user;
  function Register(){
    parent::Controller();

    $this->load->model('Administration');

    $this->user = $this->session->userdata('user');

    if($this->user && !$this->Administration->member_of($this->user['userid'], 1))
      redirect('/jcalendar2');
    
    $this->load->model('User');
    $this->load->model('JCalendar');
  }
  
  function index(){
	redirect('register/reg');
  }
  
  function reg(){
	$this->form_validation->set_error_delimiters('<span id="formError"><b>','<br/></b></span>');

	$this->form_validation->set_rules('studentnumber', 'Student Number', 'required|trim|callback__studentnumber_check|callback__validify_studentnumber');
	$this->form_validation->set_rules('firstname', 'First Name', 'required');
	$this->form_validation->set_rules('middlename', 'Middle Name', '');
	$this->form_validation->set_rules('lastname', 'Last Name', 'required');
	$this->form_validation->set_rules('login', 'Username', 'required|callback__username_check');
	$this->form_validation->set_rules('password1', 'Password', 'required|matches[PasswordConfirmation]');
	$this->form_validation->set_rules('PasswordConfirmation', 'Password Confirmation', 'required');
	$this->form_validation->set_rules('college', 'College', 'required|callback__college_check');
	$this->form_validation->set_rules('course', 'Course', 'required');
	
	$data = array();
	
	if ($this->form_validation->run('register')){
		$studentnumber = $this->input->post('studentnumber');
		$firstname = $this->input->post('firstname');
		$middlename = $this->input->post('middlename');
		$lastname = $this->input->post('lastname');
		$login = $this->input->post('login');
		$courseid = $this->input->post('course');
		$password = md5($this->input->post('password1'));
		$registered = false;
		$this->JCalendar->add_user($login,$password,$studentnumber,$firstname,$middlename,$lastname,$courseid,$registered);
		$data = array('firstname' => $firstname, 'lastname' => $lastname, 'middlename' => $middlename);
		$template['title'] = 'Registration Successful';
		$template['body'] = $this->load->view('register/success', $data, true);
		$template['sidebar'] = '';
		if(!$this->user)
		  $template['sidebar'] = $this->load->view('register/sidebar',null, true);
		else
		  $template['sidebar'] = $this->load->view('admin/control_center_sidebar', null, true);

		$this->load->view('template', $template);
	}else{
		$courses = array('' => '');
		foreach($this->JCalendar->select_courses(null) as $course)
		  $courses[$course['courseid']] = $course['coursename'];
		$colleges = array('' => '');
		foreach($this->JCalendar->select_colleges(null) as $college)
		  $colleges[$college['collegeid']] = $college['collegename'];

		$data['new_user'] = true;
		$data['user_data'] = null;
		$data['courses'] = $courses;
		$data['colleges'] = $colleges;
		$data['submit_url'] = 'register/reg';
		$data['fieldname'] = 'register';
		$template['title'] = 'Register';
		$template['body'] = $this->load->view('register/form', $data ,TRUE);
		$template['sidebar'] = '';
		if(!$this->user)
		  $template['sidebar'] = $this->load->view('register/sidebar',null, true);
		else
		  $template['sidebar'] = $this->load->view('admin/control_center_sidebar',null, true);

		$this->load->view('template', $template);
	}
  }

  function _studentnumber_check($studentnumber){
    if(!preg_match('/^\d{4}.?\d{5}$/', $studentnumber)){
      $this->form_validation->set_message('_studentnumber_check', 'Invalid student number format.');
      return(false);
    }

    return (true);
  }

  function _validify_studentnumber($studentnumber){
    return(preg_replace('/\D/', '', $studentnumber));
  }
    
  function _college_check($college){
	$course = $this->input->post('course');
	$res = $this->JCalendar->select_courses_byid($college);
	foreach($res as $c){
		if($course == $c['courseid']){
			return true;
		}
	}
	$this->form_validation->set_message('_college_check', 'The Course is not in the selected Collage.');
	return false;
  }
  
  function _username_check($str){
	$query_str = "SELECT users.login FROM users WHERE users.login = '".$str."'";
	$res = $this->db->query($query_str);
	if($res->result_array()){
		$this->form_validation->set_message('_username_check', 'The username is already taken.');
		return false;
	}else{
		return true;
	}
  }
}
?>
