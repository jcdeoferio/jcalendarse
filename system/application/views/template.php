<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>jCalendar - <?= $title ?></title>
	<?= link_tag('files/favicon.png', 'shortcut icon', 'image/ico'); ?>
	<?= link_tag('files/style.css') ?>
</head>

<body>
	<div id="main">
		<div id="header">
			<?= img('files/logo.png') ?>
		</div>
		<div id="sidebar">
			<?= $sidebar?>
		</div>
		<div id="body">
			<?= $body?>
		</div>
		<div id="footer">
			Copyright &copy; 2009 • jCalendar • jCalendar Team
		</div>
	</div>
</body>
</html>
