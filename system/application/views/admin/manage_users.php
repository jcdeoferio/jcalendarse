<table border='1' cellpadding='4'>
  <tr>
    <th>userid</th>
    <th>login</th>
  </tr>
  <?php foreach($users as $user): ?>
  <tr>
    <td><?= $user['userid'] ?></td>
    <td><?= $user['login'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>
