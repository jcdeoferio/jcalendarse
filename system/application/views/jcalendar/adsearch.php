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
Start date: <br/>
<?= form_dropdown('start_month', array(''=>'') + months_array(), set_value('start_month','')) ?>
<?= form_dropdown('start_day', array(''=>'') + days_array(), set_value('start_day','')) ?>
<?= form_dropdown('start_year', array(''=>'') + years_array(), set_value('start_year','')) ?>
<br/>
Start time: <br/><?= form_dropdown('start_hour', hours_array(), set_value('start_hour')) ?>:<?= form_dropdown('start_minute', minutes_array(), set_value('start_minute')) ?><br/>
   End date: <br/>
<?= form_dropdown('end_month', array(''=>'') + months_array(), set_value('end_month','')) ?>
<?= form_dropdown('end_day', array(''=>'') + days_array(), set_value('end_day','')) ?>
<?= form_dropdown('end_year', array(''=>'') + years_array(), set_value('end_year','')) ?>
<br/>
End time: <br/><?= form_dropdown('end_hour', hours_array(), set_value('end_hour')) ?>:<?= form_dropdown('end_minute', minutes_array(), set_value('end_minute')) ?><br/><br/>

Groups: <br/>
<?php $i = 0; ?>
<?= form_checkbox('personal_event', 'personal_event', FALSE).' '.form_label('Personal', 'personal_event') ?>
<?php foreach($groups as $group){
    if($i==8){echo br(1);$i=0;}
		echo form_checkbox('group-'.$group['groupid'], $group['groupname'], FALSE).' '.form_label($group['groupname'], $group['groupid']);
		$i++;
} echo br(2);?>


<?= form_submit('submit', 'Search') ?> <br/>
</fieldset>

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
    <td><?= anchor('jcalendar2/update/'. $event['eventid'], 'update') . '|' . ($permissions[$event['eventid']] ? anchor('jcalendar2/delete/' . $event['eventid'], 'delete', array('onClick'=>"return (confirm('Are you sure you want to delete this event?'))")) : '') ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
