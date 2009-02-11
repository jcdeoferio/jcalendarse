<?= form_open('jcalendar2/adsearch') ?>
<?= validation_errors() ?>
<table events>
  <tr>
    <th>Event name: </th>
    <td><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>set_value('event_name'))) ?></td>
  </tr>
  <tr>
    <th>Start date: </th>
    <td>
      <?= form_dropdown('start_month', array(''=>'') + months_array(), set_value('start_month')) ?>
      <?= form_dropdown('start_day', array(''=>'') + days_array(), set_value('start_day')) ?>
      <?= form_dropdown('start_year', array(''=>'') + years_array(), set_value('start_year')) ?></td>
  </tr>
  <tr>
    <th>Start time: </th>
    <td>
      <?= form_dropdown('start_hour', array(''=>'') + hours_array(), set_value('start_hour')) ?>:
      <?= form_dropdown('start_minute', array(''=>'') + minutes_array(), set_value('start_minute')) ?>
    </td>
  </tr>
  <tr>
    <th>End date: </th>
    <td>
      <?= form_dropdown('end_month', array(''=>'') + months_array(), set_value('end_month')) ?>
      <?= form_dropdown('end_day', array(''=>'') + days_array(), set_value('end_day')) ?>
      <?= form_dropdown('end_year', array(''=>'') + years_array(), set_value('end_year')) ?>
    </td>
  </tr>
  <tr>
    <th>End time:</th>
    <td>
      <?= form_dropdown('end_hour', array(''=>'') + hours_array(), set_value('end_hour')) ?>:
      <?= form_dropdown('end_minute', array(''=>'') + minutes_array(), set_value('end_minute')) ?>
    </td>
  </tr>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Search') ?></td>
  </tr>
</table>
<?= form_close() ?>
<?php if(isset($events)): ?>
<table id='events'>
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
<?php endif; ?>
