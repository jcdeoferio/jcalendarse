<?='<?xml version="1.0"?>'?>
<rss version="2.0">
	<channel>
		<title>jCalendar</title>
		<description>a typical CS student's daily school life summarized in a calendar.</description>
		<link><?php echo site_url() ?></link>
<?php foreach ($events as $event){
		echo "\t\t<item>\n".
					"\t\t\t<title>".$event['eventname']."</title>\n".
					"\t\t\t<link>".site_url('/jcalendar2/event/'.$event['eventid'])."</link>\n".
					"\t\t\t<description><![CDATA[\n".
					"\t\t\t".'( '.substr($event['start_date'], 0, strlen('yyyy-mm-dd hh:mm')).' - '.substr($event['end_date'], 0, strlen('yyyy-mm-dd hh:mm')).
						(trim($event['venue_name'])==''?'':' @ '.$event['venue_name'])." ) ".br(2).str_replace(array("\r\n", "\n", "\r"),'<br/>',$event['eventdetails']).
					"\n\t\t\t]]></description>\n\t\t</item>\n\n";
	}
?>
	</channel>
</rss>