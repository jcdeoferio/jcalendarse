<script type="text/javascript" src=<?='"'.base_url()."files/calendarDateInput.js".'"'?>>
/***********************************************
* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/
</script>
<?php
   if($success){
   echo 'Event ' . $event_name . ' updated';
   }
?>
<?= form_open('jcalendar2/update/' . $id) ?>
<?= validation_errors() ?>
<fieldset>
<legend>Update Event</legend>
Event name: <br/><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>$event_name)) ?><br/>
Start date: <br/><script>DateInput('start', true, 'YYYYMMDD',<?= $start_year.$start_month.$start_day?>)</script>
Start time: <br/><?= form_dropdown('start_hour', array(''=>'') + hours_array(), $start_hour) ?>:
      <?= form_dropdown('start_minute', array(''=>'') + minutes_array(), $start_minute) ?><br/>
End date: <br/><script>DateInput('end', true, 'YYYYMMDD',<?= $end_year.$end_month.$end_day ?>)<!--,<?= $end_year.$end_month.$end_day?>--></script>
End time: <br/><?= form_dropdown('end_hour', array(''=>'') + hours_array(), $end_hour) ?>:
      <?= form_dropdown('end_minute', array(''=>'') + minutes_array(), $end_minute) ?><br/>
Event details: <br/><?= form_textarea(array('name'=>'event_details', 'rows'=>'4', 'cols'=>'30', 'value'=>$event_details)) ?> <br/>
Venue: <br/><?= form_dropdown('venue', $venues, $venue) ?><br/><br/>
<?= form_submit('submit', 'Update Event') ?> <br/>
</fieldset>
<!--
<table>
  <tr>
    <th>Event name: </th>
    <td><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>$event_name)) ?></td>
  </tr>
  <tr>
    <th>Start date: </th>
    <td>
	<script>DateInput('start', true, 'YYYYMMDD',<?= $start_year.$start_month.$start_day?>)</script>  
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
	<script>DateInput('end', true, 'YYYYMMDD',<?= $end_year.$end_month.$end_day ?>)</script>
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
-->
<?= form_close() ?>