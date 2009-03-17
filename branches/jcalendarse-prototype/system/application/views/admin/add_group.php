<?php
	echo form_open($submit_url).validation_errors().form_fieldset('add group');
	echo 'Group name: '.form_input(array('name'=>'groupname', 'size'=>'20', 'value'=>set_value('groupname')?set_value('groupname'):isset($groupname)? $groupname:''));
	echo form_fieldset_close();
	$tmpl = array ( 'table_open'  => '<table id="events" border="1" cellpadding="4">' );
	$this->table->set_template($tmpl);
	$this->table->set_heading('User ID','Student Number','Login','Name','Action');
	foreach($users as $user){
		$rolex = -1;
		if(isset($member_of))
		foreach($member_of as $memof){
			if($memof['userid'] == $user['userid']){
				$rolex = $memof['grouproleid'];
				break;
			}
		}
		$t = form_checkbox('user-'.$user['userid'], $user['login'], set_value($user['userid']) ? set_value('user-'.$user['userid']) : ($rolex!=-1 ? $rolex:false))
			.' '.form_label('add', $user['userid']).br(1);
		foreach($roles as $role){
//			echo $rolex.' '.$role['grouproleid'].br(1);
			$t.= form_radio('grouprole-'.$user['userid'],$role['grouproleid'], $rolex == $role['grouproleid'] ).form_label($role['grouprolename'],$role['grouprolename']).br(1);
		}
	$this->table->add_row($user['userid'],$user['studentnumber'],$user['login'],$user['lastname'].', '.$user['firstname'].' '.$user['middlename'],$t);
	}
	echo $this->table->generate();
	echo form_submit(array('name'=>'submit', 'value'=>'Submit')).form_close();
?>