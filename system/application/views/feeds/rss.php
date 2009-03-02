<rss version="2.0">
	<channel>
		<title>jCalendar</title>
		<link>http://localhost/jcalendarse-prototype</link>
		<description>a typical CS student's daily school life summarized in a calendar.</description>
		<language>en-us</language>
<?php foreach ($events as $event): ?>
		<item>
			<title><?= $event['eventname'] ?></title>
			<link>http://localhost/jcalendarse-prototype/index.php/jcalendar2/event/<?= $event['eventid'] ?></link>
			<description>
			<?= substr($event['start_date'], 0, strlen('yyyy-mm-dd hh:mm')) ?> - <?= substr($event['end_date'], 0, strlen('yyyy-mm-dd hh:mm')) ?><?= (trim($event['venue_name'])==''?'':' @ '.$event['venue_name']) ?> <?= $event['eventdetails']?>
			
			</description>
		</item>
<?php endforeach; ?>
</channel>
</rss>