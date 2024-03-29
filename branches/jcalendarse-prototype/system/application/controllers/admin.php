<?php
class Admin extends Controller{
  function Admin(){
    parent::Controller();
    $this->load->model('Administration');
    $this->load->model('JCalendar');

    $this->user = $this->session->userdata('user');
    $this->per_page = 10;
		
    if(!$this->user || !$this->Administration->member_of($this->user['userid'], 1))
      redirect('/login');

    $this->template['user'] = $this->user;
    $this->load->model('JCalendar');
  }

  function index(){
    redirect('/admin/control_center');
  }

  function control_center(){
    $this->template['title'] = 'Admin - Control Center';
    $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);    
    $this->template['body'] = '';
    $this->load->view('template', $this->template);
  }

  function test(){
    echo $this->input->post('box').' '.$this->input->post('box2');

    $this->template['body'] = $this->load->view('test', '', true);
    $this->load->view('template', $this->template);
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
    $data['user_data'] = $this->Administration->select_user($userid);
    if($this->form_validation->run()){
      $studentnumber = $this->input->post('studentnumber');
      $firstname = $this->input->post('firstname');
      $middlename = $this->input->post('middlename');
      $lastname = $this->input->post('lastname');
      $login = $this->input->post('login');
      $courseid = $this->input->post('course');
      $password = md5($this->input->post('password1'));
      $registered = $data['user_data']['registered'];
      $groups = array();
      $i = 0;
      foreach($db_groups as $group){
	$groups[$i]['groupid'] = $group['groupid'];
	if($this->input->post('group-'.$group['groupid'])){
	  $groups[$i]['grouproleid'] = $this->input->post('group-'.$group['groupid'].'_role') ? $this->input->post('group-'.$group['groupid'].'_role') : 1;
	}else{
	  $groups[$i]['grouproleid'] = null;
	}
	//				echo $this->Administration->member_of($userid,$group['groupid']).' '.$group['groupname'].' ROLE:'.$groups[$i]['grouproleid'].' ';
	$i++;
      }
      $this->Administration->update_user($userid, $login, $password, $studentnumber, $firstname, $middlename, $lastname, $courseid, $registered, $groups);
      $data = array('firstname' => $firstname, 'lastname' => $lastname, 'middlename' => $middlename);
      $this->template['title'] = 'Updated User';
      $this->template['body'] = 'User updated.';
      $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', null, true);

      $this->load->view('template', $this->template);      
    }
    else{
      $courses = array('' => '');
      foreach($this->JCalendar->select_courses(null) as $course)
	$courses[$course['courseid']] = $course['coursename'];
      $colleges = array('' => '');
      foreach($this->JCalendar->select_colleges(null) as $college)
	$colleges[$college['collegeid']] = $college['collegename'];

      $member_of = array();
      $member_of_result = $this->Administration->user_member_of($userid);
      foreach ($db_groups as $group)
	$member_of[$group['groupid']] = 0;
      for ($i = 0; $i < count($member_of_result); $i++)
	$member_of[$member_of_result[$i]['groupid']] = $member_of_result[$i]['grouproleid'];
      $data['new_user'] = false;
      $data['groups'] = $db_groups;
      $data['courses'] = $courses;
      $data['colleges'] = $colleges;
      $data['member_of'] = $member_of;
      $data['submit_url'] = 'admin/update_user/'.$userid;
			$data['roles'] = $this->Administration->select_all_roles();
      $this->template['title'] = 'Update User';
      $this->template['body'] = $this->load->view('register/form', $data ,TRUE);
      $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', null, true);      $this->load->view('template', $this->template);
    }
  }

  function delete_user($userid, $page = 0){
    $this->Administration->delete_user($userid);
    redirect('/admin/manage_users/'.$page);
  }

  function manage_users($page = 0){
    $this->form_validation->set_rules('studentid', 'Student Number', 'trim|callback__studentnumber_check');
    $this->form_validation->set_rules('userid', 'User ID', 'integer');

    $userid = $studentid = $login = $lastname = $firstname = $middlename = '';

    if($this->form_validation->run()){
      $userid = $this->input->post('userid');
      $studentid = $this->_validify_studentnumber($this->input->post('studentid'));
      $login = $this->input->post('login');
      $lastname = $this->input->post('lastname');
      $firstname = $this->input->post('firstname');
      $middlename = $this->input->post('middlename');
      $data['users'] = $this->Administration->search_all_users($userid, $studentid, $login, $lastname, $firstname, $middlename);
      $data['pagination'] = false;
    }
    else{
#edited this function to use the pagination class in splitting the users  
      $data['users'] = $this->Administration->select_all_users($this->per_page, $page);
      $config['total_rows'] = $this->Administration->count_all_users();
      #		$data['pages'] = $this->Administration->count_all_users() / $this->per_page;
      $data['pagination'] = true;
#pagination
    $config['base_url'] = site_url('/admin/manage_users/');
    $config['per_page'] = $this->per_page; 
    $config['num_links'] = 3;
    $this->pagination->initialize($config);
#pagination
    }
    $data['userid'] = $userid;
    $data['studentid'] = $studentid;
    $data['login'] = $login;
    $data['lastname'] = $lastname;
    $data['firstname'] = $firstname;
    $data['middlename'] = $middlename;
    $this->template['title'] = 'Admin - Manage Users';
    $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
    $this->template['body'] = $this->load->view('admin/manage_users', $data, true);
    $this->load->view('template', $this->template);
  }

  function flip_activation($userid, $page=0){
    $this->Administration->flip_activation($userid);
    redirect('/admin/manage_users/'.$page);
  }

  function add_group(){
    $this->form_validation->set_rules('groupname', 'Group Name', 'required|trim|callback__groupname_check');
		$users = $this->Administration->select_all_users(null);
    if($this->form_validation->run()){
      $members = array();
      $i = 0;	
      foreach($users as $user)
				if($this->input->post('user-'.$user['userid'])){
					$members[$i][0] = $user['userid'];
					$members[$i][1] = $this->input->post('grouprole-'.$user['userid']);
					$i++;
				}

      $this->Administration->add_group($this->input->post('groupname'), $members);
			redirect('admin/manage_groups');
    }
    else{
      $this->template['title'] = 'Add Group';
      $data['submit_url'] = 'admin/add_group/';
      $data['new_group'] = true;
      $data['users'] = $users;
      $data['roles'] = $this->Administration->select_all_roles();
      $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
      $this->template['body'] = $this->load->view('admin/add_group', $data, true);
      $this->load->view('template', $this->template);
    }
  }

  function update_group($groupid){
    $this->form_validation->set_rules('groupname', 'Group Name', 'required|trim');
    $users = $this->Administration->select_all_users(null);
    if($this->form_validation->run()){
      $members = array();
      $i = 0;
      foreach($users as $user)
				if($this->input->post('user-'.$user['userid'])){
					$members[$i][0] = $user['userid'];
					$members[$i][1] = $this->input->post('grouprole-'.$user['userid']);
					$i++;
				}

      $this->Administration->update_group($groupid, $this->input->post('groupname'), $members);
			redirect('admin/manage_groups');
    }
    else{
      $data['submit_url'] = 'admin/update_group/'.$groupid;
      $data['new_group'] = false;
      $data['member_of'] = $this->Administration->group_member_of($groupid);
      $data['users'] = $users;
      $data['roles'] = $this->Administration->select_all_roles();
      $data['groupname'] = $this->db->query('SELECT groupname FROM groups WHERE groupid = '.$groupid)->row_array();
      $data['groupname'] = $data['groupname']['groupname'];
      $this->template['title'] = 'Manage Group - '.$data['groupname'];
      $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
      $this->template['body'] = $this->load->view('admin/add_group', $data, true);
      $this->load->view('template', $this->template);
    }
  }

  function manage_groups($page = 0){
    $data['groups'] = $this->Administration->select_all_groups($this->per_page, $page);
#pagination
    $config['base_url'] = site_url('/admin/manage_groups/');
    $config['total_rows'] = $this->Administration->count_all_groups();
    $config['per_page'] = $this->per_page; 
    $config['num_links'] = 3;
    $this->pagination->initialize($config);
#pagination
    $this->template['title'] = 'Admin - Manage Groups';
    $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
    $this->template['body'] = $this->load->view('admin/manage_groups', $data, true);
    $this->load->view('template', $this->template);    
  }

  function delete_group($groupid){
    $this->Administration->delete_group($groupid);
    redirect('/admin/manage_groups/success');
  }

  function db_maintenance(){
    $this->Administration->db_maintenance();
    $this->template['title'] = 'Admin - Database Maintenance';
    $this->template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
    $this->template['body'] = 'Removed dangling events.';
    $this->load->view('template', $this->template);
  }

  function _studentnumber_check($studentnumber){
    if($studentnumber && !preg_match('/^\d{4}\D?\d{5}$/', $studentnumber)){
      $this->form_validation->set_message('_studentnumber_check', 'Invalid student number format.');
      return(false);
    }
    return (true);
  }

  function _validify_studentnumber($studentnumber){
    return(preg_replace('/\D/', '', $studentnumber));
  }

  function _groupname_check($groupname){
    if($this->Administration->select_group_by_name($groupname)){
      $this->form_validation->set_message('_groupname_check', 'There is already a group with that name.');
      return(false);
    }
    else{
      return(true);
    }
  }

}
?>
