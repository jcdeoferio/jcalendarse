<!--<?=($this->uri->rsegment(3))?"<script>confirm('Delete successful')</script>":""?>-->
     <h2>EVENTS</h2>
     <?php if ($mode == 'L'): ?>
     <table border=1 id="events">
	<tr>
	<th>Event Name</th>
	<th>Start Date</th>
	<th>End Date</th>
	<th>Venue</th>
	<th></th>
	<th></th>
	</tr>
	<?php foreach ($events as $event): ?>
	<tr>
	<td><?= anchor('jcalendar2/event/'.$event['eventid'],$event['eventname']) ?></td>
	<td><?= $event['start_date'] ?></td>
	<td><?= $event['end_date'] ?></td>
	<td><?= $event['venue_name'] ?></td>
	<td><?= anchor('jcalendar2/update/' . $event['eventid'], 'edit') ?></td>
	<td><?= anchor('jcalendar2/delete/' . $event['eventid'], 'delete', array('onClick'=>"return (confirm('Are you sure you want to delete this event?'))")) ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php elseif($mode == 'C'): ?>
<h2><?= $monthstr.' '.$year ?></h2>
<!--	 <?php print_r($events) ?>-->
<table border=1 id="events">
<tr>
<th>Sun</th>
<th>Mon</th>
<th>Tue</th>
<th>wed</th>
<th>Thu</th>
<th>Fri</th>
<th>Sat</th>
</tr>
<?php for($i = 0, $k = 1; $i < 5; $i++): ?>
    <tr>
    <?php for($j = 0; $j < 7 && $k <= cal_days_in_month(0, $month, $year); $j++): ?>
    <?= '<td width=100px height=100px valign=top>'?>
    <?php if($i == 0 && $j < $firstday) {echo '&nbsp;</td>'; continue;} ?>
    <?= $k.br(1)?>
	 <?php if(isset($events[$k])): ?>
	 <?php foreach($events[$k] as $event): ?>
	     <?= anchor('/jcalendar2/event/'.$event['eventid'],$event['eventname']).br(1) ?>
	 <?php endforeach;?>
    <?php endif; ?>
    <?php $k++ ?>
    <?= '</td>' ?>
    <?php endfor; ?>
    </tr>
<?php endfor; ?>
</table>
<?= anchor('/jcalendar2/calendar/C/'.($month-1>0?$year:$year-1).'/'.($month-1>0?$month-1:12), 'previous month') ?>&nbsp;
<?= anchor('/jcalendar2/calendar/C/'.($month+1>12?$year+1:$year).'/'.($month+1>12?1:$month+1), 'next month') ?>
<?php endif; ?>
<br/>
<!--<?= form_open('jcalendar2/index') ?>
     View events<br/>
     <table>
     <tr>
     <td>starting from:</td>
     <td><?= form_dropdown('start_month', array(''=>'') + months_array()) ?><?= form_dropdown('start_year', array(''=>'') + years_array()) ?></td>
     </tr>
     <tr>
     <td>ending at:</td>
     <td><?= form_dropdown('end_month', array(''=>'') + months_array()) ?><?= form_dropdown('end_year', array(''=>'') + years_array()) ?></td>
     </tr>
     <tr>
     <td></td>
     <td><?= form_submit('submit', 'Go') ?></td>
     </tr>
     </table>
     <?= form_close() ?>-->
     <br/>
