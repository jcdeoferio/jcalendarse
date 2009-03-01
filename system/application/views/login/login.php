<?= form_open('login/logg') ?>
<?= validation_errors() ?>
<fieldset>
<legend>login</legend>
username:<?= form_input(array('name'=>'login', 'size'=>'10')) ?></br>
password:<?= form_password(array('name'=>'password', 'size'=>'10')) ?></br>
<?= form_submit(array('name'=>'submit', 'value'=>'Login')) ?>
</fieldset>
<?= form_close() ?>
<?= anchor('register','register'); ?>
