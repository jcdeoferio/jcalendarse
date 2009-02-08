<h2>Upcoming Events:</h2>
  <?php foreach ($events as $event): ?>
    <span id="eventName"><?= anchor('jcalendar2/event/'.$event['eventid'],$event['eventname']) ?></span><?= br(1)?>
    <span id="eventDate"><?= $event['start_date'] ?> - <?= $event['end_date'] ?> @  </span><span id="eventVenue">Sample Venue<?= $event['venue_name'] ?><?= br(1)?></span>
	<span id="eventDetails"><?= $event['eventdetails']?>Sample Details</span>
	<?= br(2) ?>
  <?php endforeach; ?>
<?= form_open('jcalendar2/index') ?>
<!--View queries<br/>
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
