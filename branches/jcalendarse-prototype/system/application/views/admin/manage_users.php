<?php $tmpl = array ( 'table_open'  => '<table id="events" border="1" cellpadding="4">' );
$this->table->set_template($tmpl);
$this->table->set_heading('User ID','Student Number','Login','Name','Action');
foreach($users as $user){
	$this->table->add_row($user['userid'],$user['studentnumber'],$user['login'],$user['lastname'].', '.$user['firstname'].' '.$user['middlename'],anchor('/admin/update_user/'.$user['userid'], 'Update').' | '.anchor('/admin/flip_activation/'.$user['userid'], ($user['registered']=='t'?'Deactivate':'Activate')));
}
echo $this->table->generate().$this->pagination->create_links();
?>
