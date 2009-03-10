<script type="text/javascript" src=<?='"'.base_url()."files/calendarDateInput.js".'"'?>>
/***********************************************
* Jason's Date Input Calendar- By Jason Moon http://calendar.moonscript.com/dateinput.cfm
* Script featured on and available at http://www.dynamicdrive.com
* Keep this notice intact for use.
***********************************************/
</script>

<?= form_open('jcalendar2/adsearch') ?>
<?= validation_errors() ?>

<fieldset>
<legend>Search Event</legend>
Event name: <br/><?= form_input(array('name'=>'event_name', 'size'=>'30', 'value'=>set_value('event_name'))) ?><br/>
Start date: <br/><script>DateInput('start', false, 'DD-MON-YYYY')</script>
Start time: <br/><?= form_dropdown('start_hour', array(''=>'') + hours_array(), set_value('start_hour')) ?>:<?= form_dropdown('start_minute', array(''=>'') + minutes_array(), set_value('start_minute')) ?><br/>
End date: <br/><script>DateInput('end', false, 'DD-MON-YYYY')</script>
End time: <br/><?= form_dropdown('end_hour', array(''=>'') + hours_array(), set_value('end_hour')) ?>:<?= form_dropdown('end_minute', array(''=>'') + minutes_array(), set_value('end_minute')) ?><br/>
Groups: <br/>
<?php $i = 0; ?>
<?= form_checkbox('personal_event', 'personal_event', FALSE).' '.form_label('Personal', 'personal_event') ?>
<?php foreach($groups as $group){
    if($i==8){echo br(1);$i=0;}
    if($group['grouproleid'] > 1){
			echo form_checkbox('group-'.$group['groupid'], $group['groupname'], FALSE).' '.form_label($group['groupname'], $group['groupid']);
			$i++;
		}
} echo br(2);?>
<?= form_submit('submit', 'Search') ?> <br/>
</fieldset>
<!--
<table events>
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
    <td></td>
    <td><?= form_submit('submit', 'Search') ?></td>
  </tr>
</table>
-->
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
