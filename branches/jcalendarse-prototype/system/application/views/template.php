<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>jCalendar - <?= $title ?></title>
<!-- GET THIS FROM USERDATA! -->
	<?= link_tag(site_url('/rss/getfeed/'.(isset($rss)?$rss:'')), 'alternate', 'application/rss+xml', 'jCalendar Public RSS Feed') ?>
	<?= link_tag('files/favicon.png', 'shortcut icon', 'image/ico'); ?>
	<?= link_tag('files/style.css') ?>
</head>
<body>
	<div id="main">
		<div id="header">
			<?= img('files/logo.png') ?>
		</div>
		<div id="content">
			<div id="sidebar">
                                <?= isset($user)?"Welcome, ".$user['login'].'.'.br(2):'' ?>
				<?= isset($sidebar)?$sidebar:br(17)?>
				<?= br(4)?>
			</div>
			<div id="body">
				<?= $body?>
				<?= br(4)?>
			</div>
		</div>
		<div id="footer">
			Copyright &copy; 2009 • jCalendar • jCalendar Team
		</div>
	</div>
</body>
</html>
