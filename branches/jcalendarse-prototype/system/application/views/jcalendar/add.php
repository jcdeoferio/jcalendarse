<h2>Add Event</h2>
<?php
   if ($success){
   echo 'Event ' . $event_name .' added';
   }
?>
<?= form_open('jcalendar2/add') ?>
<?= $this->validation->error_string ?>
<table>
  <tr>
    <th>Event name: </th>
    <td><?= form_input(array('name'=>'event_name', 'size'=>'30')) ?></td>
  </tr>
  <tr>
    <th>Start date: </th>
    <td>
      <?= form_dropdown('start_month', array(''=>'') + months_array()) ?>
      <?= form_dropdown('start_day', array(''=>'') + days_array()) ?>
      <?= form_dropdown('start_year', array(''=>'') + years_array()) ?></td>
  </tr>
  <tr>
    <th>Start time: </th>
    <td>
      <?= form_dropdown('start_hour', array(''=>'') + hours_array()) ?>:
      <?= form_dropdown('start_minute', array(''=>'') + minutes_array()) ?>
    </td>
  </tr>
  <tr>
    <th>End date: </th>
    <td>
      <?= form_dropdown('end_month', array(''=>'') + months_array()) ?>
      <?= form_dropdown('end_day', array(''=>'') + days_array()) ?>
      <?= form_dropdown('end_year', array(''=>'') + years_array()) ?>
    </td>
  </tr>
  <tr>
    <th>End time:</th>
    <td>
      <?= form_dropdown('end_hour', array(''=>'') + hours_array()) ?>:
      <?= form_dropdown('end_minute', array(''=>'') + minutes_array()) ?>
    </td>
  </tr>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Add Event') ?></td>
  </tr>
</table>
<?= form_close() ?>
<?= anchor('jcalendar2/index', 'back to calendar') ?>
