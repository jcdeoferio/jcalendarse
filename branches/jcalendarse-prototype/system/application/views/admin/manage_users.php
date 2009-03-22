<?php $tmpl = array ( 'table_open'  => '<table id="events" border="1" cellpadding="4">' );
$this->table->set_template($tmpl);
$this->table->set_heading('User ID','Student Number','Login','Name','Action');
foreach($users as $user){
  $this->table->add_row($user['userid'],$user['studentnumber'],$user['login'],$user['lastname'].', '.$user['firstname'].' '.$user['middlename'],anchor('/admin/update_user/'.$user['userid'], 'Update').br(1).anchor('/admin/delete_user/'.$user['userid'].'/'.$this->uri->segment(3), 'Delete', array('onClick'=>"return (confirm('Are you sure you want to delete {$user['firstname']}?'))")).br(1).anchor('/admin/flip_activation/'.$user['userid'].'/'.$this->uri->segment(3), ($user['registered']=='t'?'Deactivate':'Activate')));
}
echo $this->table->generate().$this->pagination->create_links();
?>
