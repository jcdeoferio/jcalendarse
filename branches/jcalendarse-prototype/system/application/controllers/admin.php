<?php
class Admin extends Controller{
  
  function Admin(){
    parent::Controller();

    $this->load->model('Administration');

    $this->user = $this->session->userdata('user');
    $this->per_page = 10;
    
    if(!$this->user || !$this->Administration->member_of($this->user['userid'], 1))
      redirect('/login');
  }

  function index(){
    redirect('/admin/control_center');
  }

  function control_center(){
    $template['title'] = 'Admin - Control Center';
    $template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);    
    $template['body'] = $this->load->view('admin/control_center', '', true);
    $this->load->view('template', $template);
  }

  function add_user(){
    redirect('/register/reg');
  }

  function update_user($userid = null){
    if($userid){
      $courses = array('' => '');
      foreach($this->JCalendar->select_courses(null) as $course)
	$courses[$course['courseid']] = $course['coursename'];
      $colleges = array('' => '');
      foreach($this->JCalendar->select_colleges(null) as $college)
	$colleges[$college['collegeid']] = $college['collegename'];

      $data['new_user'] = true;
      $data['user_data'] = $this->Administration->select_user($userid);
      $data['courses'] = $courses;
      $data['colleges'] = $colleges;
      $data['submit_url'] = 'register/reg';
      $template['title'] = 'Register';
      $template['body'] = $this->load->view('register/form', $data ,TRUE);
      $template['sidebar'] = '';
      $this->load->view('template', $template);
    }
    else{
      
    }
  }

  function manage_users($page = 1){
    $data['users'] = $this->Administration->select_all_users($this->per_page, $this->per_page*($page-1));
    $data['pages'] = $this->Administration->count_all_users() / $this->per_page;

    $template['title'] = 'Admin - Manage Users';
    $template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
    $template['body'] = $this->load->view('admin/manage_users', $data, true);
    $this->load->view('template', $template);
  }

  function flip_activation($userid){
    $this->Administration->flip_activation($userid);

    redirect('/admin/manage_users');
  }

  function add_group(){

  }

  function update_group(){

  }

  function manage_groups(){
    $data['groups'] = $this->Administration->select_all_groups();

    $template['title'] = 'Admin - Manage Groups';
    $template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
    $template['body'] = $this->load->view('admin/manage_groups', $data, true);
    $this->load->view('template', $template);    
  }
}
?>
