<table border='1' cellpadding='4'>
  <tr>
    <th>groupid</th>
    <th>group name</th>
  </tr>
  <?php foreach($groups as $group): ?>
  <tr>
    <td><?= $group['groupid'] ?></td>
    <td><?= $group['groupname'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>
