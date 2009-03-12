<?php
		echo '<span id="eventName">Groups</span>'.br(1);
		echo ($this->uri->segment(7)) ? anchor($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6),'personal'):'personal';
		echo br(1);
		foreach($groups as $group){
			echo ($this->uri->segment(7) == $group['groupid']?$group['groupname']:anchor($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$group['groupid'],$group['groupname'])).br(1) ;
		}
		echo br(1);
		echo '<span id="eventName">Calendar</span>'.br(1).
		anchor('jcalendar2/add', 'add event').br(1).
		anchor('jcalendar2/adsearch', 'advanced search').br(2);
		if($this->Administration->member_of($this->user['userid'], 1))
			echo '<span id="eventName">Administration</span>'.br(1).anchor('admin', 'admin control center').br(2);
		echo br(5);
		echo 
		anchor('rss/getfeed/'.$rss,img('files/rss.gif')).anchor('jcalendar2/getcal/'.$rss,img('files/ics.gif')).br(1).
		anchor('login/logout', 'logout');
?>