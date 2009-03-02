<?php
class Admin extends Controller{
  
  function Admin(){
    parent::Controller();

    $this->load->model('Administration');

    $this->user = $this->session->userdata('user');
    $this->per_page = 10;
    
    if(!$this->user || !$this->Administration->member_of($this->user['userid'], 1))
      redirect('/login');

    $this->load->model('JCalendar');
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

  function update_user($userid){
    $this->form_validation->set_error_delimiters('<span id="formError"><b>','<br/></b></span>');

    $this->form_validation->set_rules('studentnumber', 'Student Number', 'required|trim|callback__studentnumber_check|callback__validify_studentnumber');
    $this->form_validation->set_rules('firstname', 'First Name', 'required');
    $this->form_validation->set_rules('middlename', 'Middle Name', '');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required');
    $this->form_validation->set_rules('login', 'Username', 'required|callback__username_check');
    $this->form_validation->set_rules('password1', 'Password', 'matches[PasswordConfirmation]');
    $this->form_validation->set_rules('PasswordConfirmation', 'Password Confirmation', '');
    $this->form_validation->set_rules('college', 'College', 'required|callback__college_check');
    $this->form_validation->set_rules('course', 'Course', 'required');
	
    $data = array();
    $db_groups = $this->Administration->select_all_groups();

    if($this->form_validation->run()){
      $studentnumber = $this->input->post('studentnumber');
      $firstname = $this->input->post('firstname');
      $middlename = $this->input->post('middlename');
      $lastname = $this->input->post('lastname');
      $login = $this->input->post('login');
      $courseid = $this->input->post('course');
      $password = md5($this->input->post('password1'));
      $registered = $this->input->post('registered');
      $groups = array();
      foreach($db_groups as $group){
	if($this->input->post('group-'.$group['groupid']))
	  $groups += $group['groupid'];
      }
      
      $this->Administration->update_user($userid, $login, $password, $studentnumber, $firstname, $middlename, $lastname, $courseid, $registered, $groups);
      $data = array('firstname' => $firstname, 'lastname' => $lastname, 'middlename' => $middlename);
      $template['title'] = 'Updated User';
      $template['body'] = 'User updated.';
      $template['sidebar'] = $this->load->view('admin/control_center_sidebar', null, true);

      $this->load->view('template', $template);      
    }
    else{
      $courses = array('' => '');
      foreach($this->JCalendar->select_courses(null) as $course)
	$courses[$course['courseid']] = $course['coursename'];
      $colleges = array('' => '');
      foreach($this->JCalendar->select_colleges(null) as $college)
	$colleges[$college['collegeid']] = $college['collegename'];

      $data['new_user'] = false;
      $data['user_data'] = $this->Administration->select_user($userid);
      $data['groups'] = $db_groups;
      $data['courses'] = $courses;
      $data['colleges'] = $colleges;
      $data['submit_url'] = 'admin/update_user/'.$userid;
      $template['title'] = 'Update User';
      $template['body'] = $this->load->view('register/form', $data ,TRUE);
      $template['sidebar'] = $this->load->view('admin/control_center_sidebar', null, true);
      $this->load->view('template', $template);
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
