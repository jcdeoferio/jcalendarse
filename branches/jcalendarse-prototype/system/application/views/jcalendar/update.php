<script type="text/javascript" src=<?='"'.base_url()."files/calendarDateInput.js".'"'?>>
/***********************************************
* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/
</script>

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
	<script>DateInput('start', true, 'YYYYMMDD',<?= $start_year.$start_month.$start_day?>)</script>
<!--	<input type="button" onClick="alert(this.form.start.value)" value="Show date value passed">
      <?= form_dropdown('start_month', array(''=>'') + months_array(), set_value('start_month')) ?>
      <?= form_dropdown('start_day', array(''=>'') + days_array(), set_value('start_day')) ?>
      <?= form_dropdown('start_year', array(''=>'') + years_array(), set_value('start_year')) ?>
-->	  
	  </td>
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
	<script>DateInput('end', true, 'YYYYMMDD',<?= $end_year.$end_month.$end_day?>)</script>
	<!--
      <?= form_dropdown('end_month', array(''=>'') + months_array(), set_value('end_month')) ?>
      <?= form_dropdown('end_day', array(''=>'') + days_array(), set_value('end_day')) ?>
      <?= form_dropdown('end_year', array(''=>'') + years_array(), set_value('end_year')) ?>
	 -->
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
    <th>Event Details:</th>
    <td><?= form_textarea(array('name'=>'event_details', 'rows'=>'4', 'cols'=>'30', 'value'=>$event_details)) ?></td>
  </tr>
  <tr>
    <th>Venue:</th>
    <td><?= form_dropdown('venue', $venues, $venue) ?></td>
  </tr>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Update Event') ?></td>
  </tr>
</table>
<?= form_close() ?>
