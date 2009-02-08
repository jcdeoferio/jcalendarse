<?= form_open('login/logg') ?>
<?= validation_errors() ?>
<table>
	<tr>
		<td>login</td>
		<td><?= form_input(array('name'=>'login', 'size'=>'10')) ?></td>
	</tr>
	<tr>
		<td>password</td>
		<td><?= form_password(array('name'=>'password', 'size'=>'10')) ?></td>
	</tr>
	<tr>
		<td></td>
		<td><?= form_submit(array('name'=>'submit', 'value'=>'Login')) ?></td>
	</tr>
</table>
<?= form_close() ?>
