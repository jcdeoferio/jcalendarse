<table border='1' cellpadding='4' id='events'>
   <tr>
   <th>User ID</th>
   <th>Student Number</th>
   <th>Login</th>
   <th>Name</th>
   <th>College</th>
   <th>Course</th>
   <th>Activation</th>
   </tr>
  <?php foreach($users as $user): ?>
   <tr>
   <td><?= $user['userid'] ?></td>
   <td><?= $user['studentnumber'] ?></td>
   <td><?= $user['login'] ?></td>
   <td><?= $user['lastname'].', '.$user['firstname'].' '.$user['middlename'] ?></td>
   <td><?= $user['collegename'] ?></td>
   <td><?= $user['coursename'] ?></td>
   <td><?= anchor('/admin/flip_activation/'.$user['userid'], ($user['registered']=='t'?'Deactivate':'Activate')) ?></td>
   </tr>
  <?php endforeach; ?>
</table>
Pages :
<?php for($i = 1; $i <= $pages; $i++): ?>
    <?= anchor('/admin/manage_users/'.$i, $i).' ' ?>
<?php endfor; ?>