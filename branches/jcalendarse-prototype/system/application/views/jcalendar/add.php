<h2>Add Event</h2>
<?php
   if ($success){
   echo 'Event ' . $event_name .' added';
   }
?>
<?= form_open('jcalendar2/add') ?>
<?= validation_errors() ?>
<table>
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
    <th>Event Details:</th>
    <td><?= form_textarea(array('name'=>'event_details', 'rows'=>'4', 'cols'=>'30', 'value'=>set_value('event_details'))) ?></td>
  </tr>
  <tr>
    <th>Venue:</th>
    <td><?= form_dropdown('venue', $venues, set_value('venue')) ?></td>
  </tr>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Add Event') ?></td>
  </tr>
</table>
<?= form_close() ?>
