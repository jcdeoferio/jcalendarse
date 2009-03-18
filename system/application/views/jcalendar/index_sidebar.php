<?php
	echo '<span id="eventName">Groups</span>'.br(1);
	if($group_arg)
		echo anchor('jcalendar2/calendar/'.$mode.'/'.$year.'/'.$month.'/'.$day,'all').br(1);
	else
		echo 'all'.br(1);
	if($group_arg != 'P')
		echo anchor('jcalendar2/calendar/'.$mode.'/'.$year.'/'.$month.'/'.$day.'/P','personal').br(1);
	else
		echo 'personal'.br(1);
	foreach($groups as $group)
		if($group_arg != $group['groupid'])
			echo anchor('jcalendar2/calendar/'.$mode.'/'.$year.'/'.$month.'/'.$day.'/'.$group['groupid'],$group['groupname']).br(1);
		else
			echo $group['groupname'].br(1);
	echo br(1);
	echo '<span id="eventName">Calendar</span>'.br(1).
				anchor('jcalendar2/add', 'add event').br(1).
				anchor('jcalendar2/adsearch', 'advanced search').br(2);
	if($this->Administration->member_of($this->user['userid'], 1))
		echo '<span id="eventName">Administration</span>'.br(1).anchor('admin', 'admin control center').br(2);
	echo br(3);
	echo 		anchor('rss/getfeed/'.$rss,img('files/rss.gif')).anchor('jcalendar2/getcal/'.$rss,img('files/ics.gif')).br(1).
					anchor('login/logout', 'logout');
?>