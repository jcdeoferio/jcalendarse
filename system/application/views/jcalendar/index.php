<h2>EVENTS</h2>
<table border=1 id="events">
  <tr>
    <th>Event Name</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Venue</th>
  </tr>
  <?php foreach ($events as $event): ?>
  <tr>
    <td><?= anchor('jcalendar2/event/'.$event['eventid'],$event['eventname']) ?></td>
    <td><?= $event['start_date'] ?></td>
    <td><?= $event['end_date'] ?></td>
    <td><?= $event['venue_name'] ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<br/>
<!--<?= form_open('jcalendar2/index') ?>
View queries<br/>
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
