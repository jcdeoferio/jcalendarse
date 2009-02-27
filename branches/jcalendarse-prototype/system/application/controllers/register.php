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
?>
