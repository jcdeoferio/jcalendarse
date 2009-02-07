<?php
class Login extends Controller{
  
  function Login(){
    parent::Controller();
    
    $this->load->model('User');
  }
  
  function index(){
    redirect('/login/logg');
  }
      
  function logg(){
    if ($this->session->userdata('user')){
      redirect('/jcalendar2/index');
    }
    $rules['login'] = 'required';
    $rules['password'] = 'required|callback__login';
    $this->validation->set_rules($rules);

    if ($this->validation->run()){
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

    $template['title'] = 'Login';
    $template['body'] = $this->load->view('login/login', $data, TRUE);
	       
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
      $this->validation->set_message('_login', 'Login Fail');
      return (FALSE);
    }
  }
  }
    ?>
