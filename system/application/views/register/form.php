<?= form_open('register/reg') ?>
<?= validation_errors() ?>
<fieldset>
<legend>register</legend>
<table>
<tr>
<td>
Student number:
</td>
<td>
<?= form_input(array('name'=>'studentnumber', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
First name:
</td>
<td>
<?= form_input(array('name'=>'firstname', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
Middle name:
</td>
<td>
<?= form_input(array('name'=>'middlename', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
Last name:
</td>
<td>
<?= form_input(array('name'=>'lastname', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
Username:
</td>
<td>
<?= form_input(array('name'=>'login', 'size'=>'10')) ?>
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
<?= form_password(array('name'=>'password2', 'size'=>'10')) ?>
</td>
</tr>
<tr>
<td>
College:
</td>
<td>
<?= form_dropdown('college', $colleges, null) ?>
</td>
</tr>
<tr>
<td>
Course:
</td>
<td>
<?= form_dropdown('course', $courses, null) ?>
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
