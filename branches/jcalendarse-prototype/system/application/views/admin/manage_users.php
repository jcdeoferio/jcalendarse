<table border='1' cellpadding='4' id='events'>
  <?php $trflag = false; $i = 0;?>
  <?php foreach($users as $user): ?>
  <?php if($trflag) echo '<tr>'; ?>
    <td width = 50><?= anchor('/admin/update_user/'.$user['userid'], $user['login']).'['.anchor('/admin/flip_activation/'.$user['userid'], ($user['registered']=='t'?'d':'a')).']' ?></td>
  <?php $i++;
	if($i == 8){ $trflag = true; $i = 0;}
   ?>
  <?php if($trflag){ echo '</tr>'; $trflag = false;} ?>
  <?php endforeach; ?>
</table>
