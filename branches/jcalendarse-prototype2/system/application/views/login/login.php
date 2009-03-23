<?php echo form_open('login/logg').validation_errors().form_fieldset('login').
'username:'.form_input(array('name'=>'login', 'size'=>'10')).br(1).
'password:'.form_password(array('name'=>'password', 'size'=>'10')).br(2).
form_submit(array('name'=>'submit', 'value'=>'Login')).form_fieldset_close().
form_close().br(1).anchor('register','register');
?>
