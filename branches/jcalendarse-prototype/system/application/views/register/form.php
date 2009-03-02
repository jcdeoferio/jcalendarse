<?= form_open($submit_url, '', array('new_user' => $new_user)) ?>
<?= validation_errors() ?>
<fieldset>
     <legend><?= $new_user?'register':'update' ?></legend>
<table>
<tr>
<td>
Student number:
</td>
<td>
     <?= form_input(array('name'=>'studentnumber', 'size'=>'10', 'value'=>set_value('studentnumber')?set_value('studentnumber'):(!$new_user?$user_data['studentnumber']:''))) ?>
</td>
</tr>
<tr>
<td>
First name:
</td>
<td>
<?= form_input(array('name'=>'firstname', 'size'=>'10', 'value'=>set_value('firstname')?set_value('firstname'):(!$new_user?$user_data['firstname']:''))) ?>
</td>
</tr>
<tr>
<td>
Middle name:
</td>
<td>
<?= form_input(array('name'=>'middlename', 'size'=>'10', 'value'=>set_value('middlename')?set_value('middlename'):(!$new_user?$user_data['middlename']:''))) ?>
</td>
</tr>
<tr>
<td>
Last name:
</td>
<td>
<?= form_input(array('name'=>'lastname', 'size'=>'10', 'value'=>set_value('lastname')?set_value('lastname'):(!$new_user?$user_data['lastname']:''))) ?>
</td>
</tr>
<tr>
<td>
Username:
</td>
<td>
<?= form_input(array('name'=>'login', 'size'=>'10', 'value'=>set_value('login')?set_value('login'):(!$new_user?$user_data['login']:''))) ?>
</td>
</tr>
<tr>
<td>
Password:
</td>
<td>
<?= form_password(array('name'=>'password1', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
Re-type password:
</td>
<td>
<?= form_password(array('name'=>'PasswordConfirmation', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
College:
</td>
<td>
<?= form_dropdown('college', $colleges, set_value('college')?set_value('college'):(!$new_user?$user_data['collegeid']:'')) ?>
</td>
</tr>
<tr>
<td>
Course:
</td>
<td>
<?= form_dropdown('course', $courses, set_value('course')?set_value('course'):(!$new_user?$user_data['courseid']:'')) ?>
</td>
</tr>
<tr>
<td colspan=2>
<br/><?= form_submit(array('name'=>'submit', 'value'=>'Register')) ?>
</td>
</tr>
</table>
</fieldset>
<?= form_close() ?>
