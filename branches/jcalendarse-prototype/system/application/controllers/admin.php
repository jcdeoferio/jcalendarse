<?php
class Admin extends Controller{
  function Admin(){
    parent::Controller();

    $this->load->model('Administration');
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

  }

  function update_user(){
    
  }

  function manage_users(){
    $data['users'] = $this->Administration->select_all_users();

    $template['title'] = 'Admin - Manage Users';
    $template['sidebar'] = $this->load->view('admin/control_center_sidebar', '', true);
    $template['body'] = $this->load->view('admin/manage_users', $data, true);
    $this->load->view('template', $template);
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
