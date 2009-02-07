<h2>EVENTS</h2>
<table border=1 cellpadding=4>
  <tr>
    <th>Event Name</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Action</th>
  </tr>
  <?php foreach ($events as $event): ?>
  <tr>
    <td><?= anchor('jcalendar2/event/'.$event['eventid'],$event['eventname']) ?></td>
    <td><?= $event['start_date'] ?></td>
    <td><?= $event['end_date'] ?></td>
    <td><?= anchor('jcalendar2/update/'. $event['eventid'], 'update') . '|' . anchor('jcalendar2/delete/' . $event['eventid'], 'delete', array('onClick'=>"return (confirm('Are you sure you want to delete this event?'))")) ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<br/>
<?= form_open('jcalendar2/index') ?>
<!--View queries<br/>
<table>
  <tr>
    <td>starting from:</td>
    <td><?= form_dropdown('start_month', array(''=>'') + months_array()) ?><?= form_dropdown('start_year', array(''=>'') + years_array()) ?></td>
  </tr>
  <tr>
    <td>ending at:</td>
    <td><?= form_dropdown('end_month', array(''=>'') + months_array()) ?><?= form_dropdown('end_year', array(''=>'') + years_array()) ?></td>
  </tr>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Go') ?></td>
  </tr>
</table>
<?= form_close() ?>-->
<br/>
<?= anchor('jcalendar2/add', 'add event') . '|' . anchor('login/logout', 'logout') ?>
