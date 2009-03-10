<?php
echo form_open($submit_url, '', array('new_user' => $new_user)).validation_errors().form_fieldset($new_user?'register':'update');
$this->table->add_row('Student number:', form_input(array('name'=>'studentnumber', 'size'=>'10', 'value'=>set_value('studentnumber')?set_value('studentnumber'):(!$new_user?$user_data['studentnumber']:''))));
$this->table->add_row('First name:',form_input(array('name'=>'firstname', 'size'=>'10', 'value'=>set_value('firstname')?set_value('firstname'):(!$new_user?$user_data['firstname']:''))));
$this->table->add_row('Middle name:',form_input(array('name'=>'middlename', 'size'=>'10', 'value'=>set_value('middlename')?set_value('middlename'):(!$new_user?$user_data['middlename']:''))));
$this->table->add_row('Last name:',form_input(array('name'=>'lastname', 'size'=>'10', 'value'=>set_value('lastname')?set_value('lastname'):(!$new_user?$user_data['lastname']:''))));
$this->table->add_row('Username:',form_input(array('name'=>'login', 'size'=>'10', 'value'=>set_value('login')?set_value('login'):(!$new_user?$user_data['login']:''))));
$this->table->add_row('Password:',form_password(array('name'=>'password1', 'size'=>'10')));
$this->table->add_row('Re-type password:',form_password(array('name'=>'PasswordConfirmation', 'size'=>'10')));
$this->table->add_row('College:',form_dropdown('college', $colleges, set_value('college')?set_value('college'):(!$new_user?$user_data['collegeid']:'')));
$this->table->add_row('Course:',form_dropdown('course', $courses, set_value('course')?set_value('course'):(!$new_user?$user_data['courseid']:'')));
if(!$new_user){
$group_dropdown = '';
	foreach($groups as $group){
			$group_dropdown.=form_checkbox('group-'.$group['groupid'], $group['groupname'], set_value($group['groupid'])?set_value($group['groupid']):(isset($member_of[$group['groupid']])?$member_of[$group['groupid']]:'')).' '.form_label($group['groupname'], $group['groupid']).br(1).
			form_radio('group-'.$group['groupid'].'_role',1, $member_of[$group['groupid']] == 1).form_label('read events','read_events').
			form_radio('group-'.$group['groupid'].'_role',2, $member_of[$group['groupid']] == 2).form_label('edit events','edit_events').
			form_radio('group-'.$group['groupid'].'_role',3, $member_of[$group['groupid']] == 3).form_label('edit members and events','edit_members/events').br(1);
	}
	$this->table->add_row('Groups:',$group_dropdown);
}
echo $this->table->generate().br(2).form_submit(array('name'=>'submit', 'value'=>$new_user?'Register':'Update')).form_fieldset_close().form_close();
?>
