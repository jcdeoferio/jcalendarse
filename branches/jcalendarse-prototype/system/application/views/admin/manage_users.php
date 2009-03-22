<?php
echo validation_errors();
echo form_open('admin/manage_users');
echo form_fieldset('Search Users');
echo form_label('User ID: ', 'userid').form_input('userid', set_value('userid')?set_value('userid'):$userid).br(1);
echo form_label('Student Number: ', 'studentid').form_input('studentid', set_value('studentid')?set_value('studentid'):$studentid).br(1);
echo form_label('Login: ', 'login').form_input('login', set_value('login')?set_value('login'):$login).br(1);
echo form_label('Lastname: ', 'lastname').form_input('lastname', set_value('lastname')?set_value('lastname'):$lastname).br(1);
echo form_label('Firstname: ', 'firstname').form_input('firstname', set_value('firstname')?set_value('firstname'):$firstname).br(1);
echo form_label('Middlename: ', 'middlename').form_input('middlename', set_value('middlename')?set_value('middlename'):$middlename).br(1);
echo form_submit('submit', 'Search');
echo form_fieldset_close();
echo form_close();
$tmpl = array ( 'table_open'  => '<table id="events" border="1" cellpadding="4">' );
$this->table->set_template($tmpl);
$this->table->set_heading('User ID','Student Number','Login','Name','Action');
foreach($users as $user){
  $this->table->add_row($user['userid'],$user['studentnumber'],$user['login'],$user['lastname'].', '.$user['firstname'].' '.$user['middlename'],anchor('/admin/update_user/'.$user['userid'], 'Update').br(1).anchor('/admin/delete_user/'.$user['userid'].'/'.$this->uri->segment(3), 'Delete', array('onClick'=>"return (confirm('Are you sure you want to delete {$user['firstname']}?'))")).br(1).anchor('/admin/flip_activation/'.$user['userid'].'/'.$this->uri->segment(3), ($user['registered']=='t'?'Deactivate':'Activate')));
}
echo $this->table->generate().$this->pagination->create_links();
?>
