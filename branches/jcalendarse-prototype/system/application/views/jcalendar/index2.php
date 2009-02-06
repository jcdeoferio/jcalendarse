<h2>EVENTS</h2>
<table border=1 cellpadding=4>
  <tr>
    <th>Sun</th>
    <th>Mon</th>
    <th>Tue</th>
    <th>Wed</th>
    <th>Thu</th>
    <th>Fri</th>
    <th>Sat</th>
  </tr>
  <?php for($i )>
<!--  <?php foreach ($events as $event): ?>
  <tr>
    <td><?= $event['name'] ?></td>
    <td><?= $event['startdate'] ?></td>
    <td><?= $event['enddate'] ?></td>
    <td><?= anchor('jcalendar2/update/'. $event['id'], 'update') . '|' . anchor('jcalendar2/delete/' . $event['id'], 'delete', array('onClick'=>"return (confirm('Are you sure you want to delete this event?'))")) ?></td>
  </tr>
  <?php endforeach; ?>  -->
</table>
<br/>
<?= anchor('jcalendar2/add', 'add event') . '|' . anchor('login/logout', 'logout') ?>
