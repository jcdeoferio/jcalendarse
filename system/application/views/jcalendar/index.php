<?php if ($mode == 'L'): ?>
<?= ($mode == 'M' ? 'Monthly':anchor('jcalendar2/calendar/M','Monthly')).' | '.($mode == 'W' ? 'Weekly':anchor('jcalendar2/calendar/W','Weekly')).' | '.($mode == 'D' ? 'Daily':anchor('jcalendar2/calendar/D','Daily')).' | '.($mode == 'L' ? 'List':anchor('jcalendar2/calendar/L','List')) ?>
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

<?php elseif($mode == 'M'): ?>
<h2><?= $monthstr.' '.$year ?></h2>
<?= ($mode == 'M' ? 'Monthly':anchor('jcalendar2/calendar/M','Monthly')).' | '.($mode == 'W' ? 'Weekly':anchor('jcalendar2/calendar/W','Weekly')).' | '.($mode == 'D' ? 'Daily':anchor('jcalendar2/calendar/D','Daily')).' | '.($mode == 'L' ? 'List':anchor('jcalendar2/calendar/L','List')) ?>
<?= br(2).anchor('/jcalendar2/calendar/M/'.($month-1>0?$year:$year-1).'/'.($month-1>0?$month-1:12), 'previous month').' | ' ?>
<?= anchor('/jcalendar2/calendar/M/'.($month+1>12?$year+1:$year).'/'.($month+1>12?1:$month+1), 'next month') ?>
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

<?php elseif($mode == 'W'): ?>
<h2><?= $monthstr.' '.$year ?></h2>
<?= ($mode == 'M' ? 'Monthly':anchor('jcalendar2/calendar/M','Monthly')).' | '.($mode == 'W' ? 'Weekly':anchor('jcalendar2/calendar/W','Weekly')).' | '.($mode == 'D' ? 'Daily':anchor('jcalendar2/calendar/D','Daily')).' | '.($mode == 'L' ? 'List':anchor('jcalendar2/calendar/L','List')).br(2) ?>
<?php
	if($date['mday'] - 7 < 1){
		if($month-1 < 1){
			echo anchor('/jcalendar2/calendar/W/'.($year-1).'/12/'.cal_days_in_month(0,$month,$year-1),'previous week');
		}else{
			echo anchor('/jcalendar2/calendar/W/'.($year).'/'.($month-1).'/'.cal_days_in_month(0,$month-1,$year),'previous week');
		}
	}else{
		echo anchor('/jcalendar2/calendar/W/'.($year).'/'.($month).'/'.($day-7),'previous week');
	}
	echo ' | ';
	if($date['mday']+7 > cal_days_in_month(0, $month, $year)){
		if($month+1 > 12){
			echo anchor('/jcalendar2/calendar/W/'.($year+1).'/1/1','next week');
		}else{
			echo anchor('/jcalendar2/calendar/W/'.($year).'/'.($month+1).'/1','previous week');
		}
	}else{
		echo anchor('/jcalendar2/calendar/W/'.($year).'/'.($month).'/'.($day+7),'next week');
	}
?>
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
<tr>
<?php
		for($i = $date['mday']-$date['wday']; $i <= $date['mday']-$date['wday']+6; $i++){
		echo '<td width=100px height=100px valign=top>'.(($i < 1 || $i > cal_days_in_month(0, $month, $year)) ? '':$i).br(1);
		if(isset($events[$i]))
		foreach($events[$i] as $event)
	     echo anchor('/jcalendar2/event/'.$event['eventid'],$event['eventname']).br(1);
		echo '</td>';
		}
?>
</tr>
</table>

<?php elseif($mode == 'D'): ?>
<h2><?= $monthstr.' '.$year ?></h2>
<?= ($mode == 'M' ? 'Monthly':anchor('jcalendar2/calendar/M','Monthly')).' | '.($mode == 'W' ? 'Weekly':anchor('jcalendar2/calendar/W','Weekly')).' | '.($mode == 'D' ? 'Daily':anchor('jcalendar2/calendar/D','Daily')).' | '.($mode == 'L' ? 'List':anchor('jcalendar2/calendar/L','List')).br(2) ?>
<?php
	if($date['mday'] - 1 < 1){
		if($month-1 < 1){
			echo anchor('/jcalendar2/calendar/D/'.($year-1).'/12/'.cal_days_in_month(0,$month,$year-1),'previous day');
		}else{
			echo anchor('/jcalendar2/calendar/D/'.($year).'/'.($month-1).'/'.cal_days_in_month(0,$month-1,$year),'previous day');
		}
	}else{
		echo anchor('/jcalendar2/calendar/D/'.($year).'/'.($month).'/'.($day-1),'previous day');
	}
	echo ' | ';
	if($date['mday']+1 > cal_days_in_month(0, $month, $year)){
		if($month+1 > 12){
			echo anchor('/jcalendar2/calendar/D/'.($year+1).'/1/1','next day');
		}else{
			echo anchor('/jcalendar2/calendar/D/'.($year).'/'.($month+1).'/1','previous day');
		}
	}else{
		echo anchor('/jcalendar2/calendar/D/'.($year).'/'.($month).'/'.($day+1),'next day');
	}
?>
<table border=1 id="events" width=100%>
<tr>
<th>Sun</th>
</tr>
<tr>
<?php
		echo '<td width=100px height=100px valign=top>'.$date['mday'].br(1);
		if(isset($events[$date['mday']]))
		foreach($events[$date['mday']] as $event)
	     echo anchor('/jcalendar2/event/'.$event['eventid'],$event['eventname']).br(1);
		echo '</td>';
?>
</tr>
</table>
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
