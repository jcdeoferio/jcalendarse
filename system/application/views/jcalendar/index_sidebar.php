<?= anchor('jcalendar2/add', 'add event').br(1).
    anchor('jcalendar2/adsearch', 'advanced search').br(1).
    anchor('admin', 'admin control center').br(1).
	anchor('rss/getfeed/'.$rss,'rss feed').br(1).
	anchor('http://localhost/jcalendarse-prototype/calendars/calendar_'.$rss.'.ics','iCalendar').br(1).
    anchor('login/logout', 'logout')
?>