<script type="text/javascript" src=<?='"'.base_url()."files/calendarDateInput.js".'"'?>>
/***********************************************
* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/
</script>
<?php
   if ($success){
   echo 'Event ' . $event_name .' added';
   }
?>
<?= form_open('jcalendar2/add', '', array('userid'=>$user['userid'])) ?>
<?= validation_errors() ?>
<fieldset>
<legend>Add Event</legend>
Event name: <br/><?= form_input(array('name'=>'event_name', 'size'=>'30')) ?><br/>
Start date: <br/>
<?= form_dropdown('start_month', array(''=>'') + months_array(), set_value('start_month','')) ?>
<?= form_dropdown('start_day', array(''=>'') + days_array(), set_value('start_month','')) ?>
<?= form_dropdown('start_year', array(''=>'') + years_array(), set_value('start_month','')) ?>
<br/>
Start time: <br/><?= form_dropdown('start_hour', array(''=>'') + hours_array()) ?>:<?= form_dropdown('start_minute', array(''=>'') + minutes_array()) ?><br/>
End date: <br/>
<?= form_dropdown('end_month', array(''=>'') + months_array(), set_value('end_month','')) ?>
<?= form_dropdown('end_day', array(''=>'') + days_array(), set_value('end_month','')) ?>
<?= form_dropdown('end_year', array(''=>'') + years_array(), set_value('end_month','')) ?>
<br/>
End time: <br/><?= form_dropdown('end_hour', array(''=>'') + hours_array()) ?>:<?= form_dropdown('end_minute', array(''=>'') + minutes_array()) ?><br/>
Event details: <br/><?= form_textarea(array('name'=>'event_details', 'rows'=>'4', 'cols'=>'30')) ?> <br/>
Venue: <br/><?= form_dropdown('venue', $venues) ?><br/>
Groups: <br/>
<?= form_checkbox('personal_event', 'personal_event', FALSE).' '.form_label('Personal', 'personal_event').' ' ?>
<?php $i = 1; ?>
<?php 
   foreach($groups as $group){
    if($i==8){echo br(1);$i=0;}
    if($group['grouproleid'] < 3){
      echo form_checkbox('group-'.$group['groupid'], $group['groupname'], FALSE).' '.form_label($group['groupname'], $group['groupid']).' ';
      $i++;
    }
} echo br(2);?>
<!--<?= (isset($groups) ? "Group: <br/> ".form_dropdown('group', $groups, set_value('group'))." <br/><br/>" : "<br/>" )?>-->
<?= form_submit('submit', 'Add Event') ?> <br/>
</fieldset>

<?= form_close() ?>

<!--
<table>
  <tr>
    <th>Event name: </th>
    <td><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>set_value('event_name'))) ?></td>
  </tr>
  <tr>
    <th>Start date: </th>
    <td>
	<script>DateInput('start', true, 'DD-MON-YYYY')</script>
	  </td>
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
	<script>DateInput('end', true, 'DD-MON-YYYY')</script>
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
</table> -->
