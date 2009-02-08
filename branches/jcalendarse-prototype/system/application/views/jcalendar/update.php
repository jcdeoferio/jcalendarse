<h2>Update Event</h2>
<?php
   if($success){
   echo 'Event ' . $event_name . ' updated';
   }
?>
<?= form_open('jcalendar2/update/' . $id) ?>
<?= validation_errors() ?>
<table>
  <tr>
    <th>Event name: </th>
    <td><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>$event_name)) ?></td>
  </tr>
  <tr>
    <th>Start date: </th>
    <td>
      <?= form_dropdown('start_month', array(''=>'') + months_array(), $start_month) ?>
      <?= form_dropdown('start_day', array(''=>'') + days_array(), $start_day) ?>
      <?= form_dropdown('start_year', array(''=>'') + years_array(), $start_year) ?></td>
  </tr>
  <tr>
    <th>Start time: </th>
    <td>
      <?= form_dropdown('start_hour', array(''=>'') + hours_array(), $start_hour) ?>:
      <?= form_dropdown('start_minute', array(''=>'') + minutes_array(), $start_minute) ?>
    </td>
  </tr>
  <tr>
    <th>End date: </th>
    <td>
      <?= form_dropdown('end_month', array(''=>'') + months_array(), $end_month) ?>
      <?= form_dropdown('end_day', array(''=>'') + days_array(), $end_day) ?>
      <?= form_dropdown('end_year', array(''=>'') + years_array(), $end_year) ?>
    </td>
  </tr>
  <tr>
    <th>End time:</th>
    <td>
      <?= form_dropdown('end_hour', array(''=>'') + hours_array(), $end_hour) ?>:
      <?= form_dropdown('end_minute', array(''=>'') + minutes_array(), $end_minute) ?>
    </td>
  </tr>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Update Event') ?></td>
  </tr>
</table>
<?= form_close() ?>
