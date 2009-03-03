<table border='1' cellpadding='4' id='events'>
   <tr>
   <th>User ID</th>
   <th>Student Number</th>
   <th>Login</th>
   <th>Name</th>
   <th>Action</th>
   </tr>
  <?php foreach($users as $user): ?>
   <tr>
   <td><?= $user['userid'] ?></td>
   <td><?= $user['studentnumber'] ?></td>
   <td><?= $user['login'] ?></td>
   <td><?= $user['lastname'].', '.$user['firstname'].' '.$user['middlename'] ?></td>
   <td><?= anchor('/admin/update_user/'.$user['userid'], 'Update').' | '.anchor('/admin/flip_activation/'.$user['userid'], ($user['registered']=='t'?'Deactivate':'Activate')) ?></td>   </tr>
  <?php endforeach; ?>
</table>
<?php echo $this->pagination->create_links();?>

