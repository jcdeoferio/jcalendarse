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
<?= form_open('jcalendar2/update/' . $id, '', array('userid'=>$user['userid'])) ?>
<?= validation_errors() ?>

<?php 
   $fixedpermissions = array();
   foreach($permissions as $permission){
   $fixedpermissions[$permission['groupid']] = $permission;
   if($permission['groupid'] && $permission['grouproleid'] == 3){
     echo form_hidden('group-'.$permission['groupid'], true);
   }
 }
?>

<fieldset>
<legend>Update Event</legend>
Event name: <br/><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>$event_name)) ?><br/>
Start date: <br/>
<?= form_dropdown('start_month', array(''=>'') + months_array(), set_value('start_month',$start_month)) ?>
<?= form_dropdown('start_day', array(''=>'') + days_array(), set_value('start_day',$start_day)) ?>
<?= form_dropdown('start_year', array(''=>'') + years_array(), set_value('start_year',$start_year)) ?>
<br/>
<!--<script>DateInput('start', true, 'YYYYMMDD',<?= $start_year.$start_month.$start_day?>)</script>-->
Start time: <br/><?= form_dropdown('start_hour', array(''=>'') + hours_array(), $start_hour) ?>:
      <?= form_dropdown('start_minute', array(''=>'') + minutes_array(), $start_minute) ?><br/>
End date: <br/>
<?= form_dropdown('end_month', array(''=>'') + months_array(), set_value('end_month',$end_month)) ?>
<?= form_dropdown('end_day', array(''=>'') + days_array(), set_value('end_day',$end_day)) ?>
<?= form_dropdown('end_year', array(''=>'') + years_array(), set_value('end_year',$end_year)) ?>
<br/>
End time: <br/><?= form_dropdown('end_hour', array(''=>'') + hours_array(), $end_hour) ?>:
      <?= form_dropdown('end_minute', array(''=>'') + minutes_array(), $end_minute) ?><br/>
Event details: <br/><?= form_textarea(array('name'=>'event_details', 'rows'=>'4', 'cols'=>'30', 'value'=>$event_details)) ?> <br/>
Venue: <br/><?= form_dropdown('venue', $venues, $venue) ?><br/><br/>
<?= form_checkbox('personal_event', 'personal_event', $permissions[0]).' '.form_label('Personal', 'personal_event').' ' ?>
<?php $i = 1; ?>
<?php 
   foreach($groups as $group){
    if($i==8){echo br(1);$i=0;}
    if($group['grouproleid'] < 3){
      echo form_checkbox('group-'.$group['groupid'], $group['groupname'], isset($fixedpermissions[$group['groupid']])).' '.form_label($group['groupname'], $group['groupid']).' ';
      $i++;
    }
} echo br(2);?>
<?= form_submit('submit', 'Update Event') ?> <br/>
</fieldset>
<!--<?php /*
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
   <th>Groups:</th>
</tr>
<tr>
    <td><?= form_checkbox('personal_event', 'personal_event', set_value('personal_event')||$permissions[0]).' '.form_label('Personal', 'personal_event').' ' ?></td>
<?php
   $i = 8;
   foreach($groups as $group){
     if($i == 8){echo '</tr><tr>'; $i=0;}
     if($group['grouproleid'] < 3){
       echo '<td>'.form_checkbox('group-'.$group['groupid'], $group['groupname'], set_value('group-'.$group['groupid'])||$permissions['groupid'] == 't').' '.form_label($group['groupname'], $group['groupid']).' </td>';
       $i++;
     }
 }
echo '</tr>';
?>
  <tr>
    <td></td>
    <td><?= form_submit('submit', 'Update Event') ?></td>
  </tr>
  </table>*/?>
-->
<?= form_close() ?>
