<!--<h1>Event: <?= $event['eventname'] ?></h1>
<?= $event['start_date'] . '<br/>' ?>
<?= $event['end_date'] . '<br/>' ?>
<?= $event['eventdetails'] . '<br/>' ?>
<?= $event['venue_name'] . '<br/>' ?>
-->
    <span id="eventName"><?= $event['eventname'] ?></span><?= br(1)?>
    <span id="eventDate"><?= substr($event['start_date'], 0, strlen('yyyy-mm-dd hh:mm')) ?> - <?= substr($event['end_date'], 0, strlen('yyyy-mm-dd hh:mm')) ?></span><span id="eventVenue"><?= (trim($event['venue_name'])==''?'':' @ '.$event['venue_name']) ?><?= br(1)?></span>
	<span id="eventDetails"><?= $event['eventdetails']?></span>
	<?= br(2) ?>
