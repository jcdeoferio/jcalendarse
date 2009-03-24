<?php
class Login extends Controller{
	
  function Login(){
    parent::Controller();
    $this->load->model('User');
    $this->load->model('JCalendar');
    $this->load->library('pagination');
    $this->load->helper('text');
	
    $this->per_page = 10;
  }
	
  function index(){
    redirect('/login/logg/0/');
  }
			
  function logg($page = 0){
//	echo random_string('unique');
    if ($this->session->userdata('user')){
      redirect('/jcalendar2/index');
    }
    $this->form_validation->set_error_delimiters('<span id="formError"><b>','</b></span>');

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
	
    $events = $this->JCalendar->select_public_events();
	
#pagination	
    $config['base_url'] = site_url('/login/logg/');
    $config['total_rows'] = count($events);
    $config['per_page'] = $this->per_page; 
    $config['num_links'] = 3;
    $this->pagination->initialize($config);
		
    $newevents = array();
    for($i = 0;$i<$this->per_page && $i+$page<count($events);$i++)
      $newevents[$i] = $events[$page+$i];
#pagination

    $data['events'] = $newevents;
    $template['title'] = 'Login';
    $template['sidebar'] = $this->load->view('login/login', '', TRUE);
    $template['body'] = $this->load->view('jcalendar/public',$data,TRUE);
    $this->load->view('template', $template);
    $this->load->helper('text');
  }

  function logout(){
    $this->session->sess_destroy();
    redirect('/login/logg');
  }

  function _login(){
    $login = $this->input->post('login');
    $password = md5($this->input->post('password'));

    if ($user = $this->User->authenticate($login, $password)){
      if($user['registered'] == 't'){
	unset($user['password']);
	$this->session->set_userdata('user', $user);
	return (TRUE);
      }else{
	$this->form_validation->set_message('_login', 'User not yet active, Contact Staff');
	return (FALSE);
      }
    }else{
      $this->form_validation->set_message('_login', 'Login Fail');
      return (FALSE);
    }
  }
}
?>
