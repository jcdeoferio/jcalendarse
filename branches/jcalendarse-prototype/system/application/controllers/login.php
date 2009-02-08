<?php
class Login extends Controller{
  
  function Login(){
    parent::Controller();
    
    $this->load->model('User');
    $this->load->model('JCalendar');
  }
  
  function index(){
    redirect('/login/logg');
  }
      
  function logg(){
    if ($this->session->userdata('user')){
      redirect('/jcalendar2/index');
    }
    $this->form_validation->set_error_delimiters('<font color=red><b>','</b></font>');

    $this->form_validation->set_rules('login', 'Login', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required|callback__login');

    if ($this->form_validation->run()){
      $login = $this->input->post('login');
      $this->session->set_userdata(array('login'=>$login));
      redirect('/jcalendar2/index');
    }
    else{
      if(!empty($_POST)){
	$data['error'] = TRUE;
      }
      else{
	$data = array();
      }
    }
	
    $events = $this->JCalendar->select_all_events(-1);
    $data['events'] = $events;
    $template['title'] = 'Login';
    $template['sidebar'] = $this->load->view('login/login', $data, TRUE);
    $template['body'] = $this->load->view('jcalendar/public',$data,TRUE);
    $this->load->view('template', $template);
  }

  function logout(){
    $this->session->sess_destroy();
    redirect('/login/logg');
  }

  function _login(){
    $login = $this->input->post('login');
    $password = md5($this->input->post('password'));

    if ($user = $this->User->authenticate($login, $password)){
      unset($user['password']);
      $this->session->set_userdata('user', $user);
      return (TRUE);
    }
    else{
      $this->form_validation->set_message('_login', 'Login Fail');
      return (FALSE);
    }
  }
  }
    ?>
