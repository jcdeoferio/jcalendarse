<?php
class Register extends Controller{
  
  function Register(){
    parent::Controller();
    
    $this->load->model('User');
    $this->load->model('JCalendar');
  }
  
  function index(){
	redirect('register/reg');
  }
  
  function reg(){
	$this->load->helper(array('form', 'url'));
	$this->load->library('form_validation');
	
	$this->form_validation->set_error_delimiters('<span id="formError"><b>','<br/></b></span>');
	
	$this->form_validation->set_rules('studentnumber', 'Student number', 'required');
	$this->form_validation->set_rules('firstname', 'First name', 'required');
	#$this->form_validation->set_rules('middlename', 'Middle name', 'required');
	$this->form_validation->set_rules('lastname', 'Last Name', 'required');
	$this->form_validation->set_rules('login', 'Username', 'required|callback_username_check');
	$this->form_validation->set_rules('password1', 'Password', 'required|matches[PasswordConfirmation]');
	$this->form_validation->set_rules('PasswordConfirmation', 'Password Confirmation', 'required');
	$this->form_validation->set_rules('college', 'College', 'required|callback_college_check');
	$this->form_validation->set_rules('course', 'Course', 'required');
	
	if ($this->form_validation->run()){
		$studentnumber = $this->input->post('studentnumber');
		$firstname = $this->input->post('firstname');
		$middlename = $this->input->post('middlename');
		$lastname = $this->input->post('lastname');
		$login = $this->input->post('login');
		$courseid = $this->input->post('course');
		$password = md5($this->input->post('password1'));
		$registered = false;
		$this->JCalendar->add_user($login,$password,$studentnumber,$firstname,$middlename,$lastname,$courseid,$registered);
		$template = array('firstname' => $firstname, 'lastname' => $lastname, 'middlename' => $middlename);
		$template['title'] = 'Registration Successful';
		$template['body'] = $this->load->view('register/success',$template,true);
		$template['sidebar'] = $this->load->view('register/sidebar',null, TRUE);
		$this->load->view('template', $template);
	}else{
		$courses = array('' => '');
		foreach($this->JCalendar->select_courses(null) as $course)
		  $courses[$course['courseid']] = $course['coursename'];
		$colleges = array('' => '');
		foreach($this->JCalendar->select_colleges(null) as $college)
		  $colleges[$college['collegeid']] = $college['collegename'];
		$template['colleges']=$colleges;
		$template['courses']=$courses;
		$template['title'] = 'Register';
		$template['sidebar'] = $this->load->view('register/sidebar',null, TRUE);
		$template['body'] = $this->load->view('register/form',array('courses'=>$courses,'colleges'=>$colleges),TRUE);
		$this->load->view('template', $template);
	}
  }
    
  function college_check($college){
	$course = $this->input->post('course');
	$res = $this->JCalendar->select_courses_byid($college);
	foreach($res as $c){
		if($course == $c['courseid']){
			return true;
		}
	}
	$this->form_validation->set_message('college_check', 'The Course is not in the selected Collage.');
	return false;
  }
  
  function username_check($str){
	$query_str = "SELECT users.login FROM users WHERE users.login = '".$str."'";
	$res = $this->db->query($query_str);
	if($res->result_array()){
		$this->form_validation->set_message('username_check', 'The username is already taken.');
		return false;
	}else{
		return true;
	}
  }
}
?>
