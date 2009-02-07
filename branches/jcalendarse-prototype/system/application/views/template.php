<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>JCalendar - <?= $title ?></title>

	<?= link_tag('files/favicon.png', 'shortcut icon', 'image/ico'); ?>
	<?= link_tag('files/style.css') ?>
</head>

<body>
	<div id="header">
		<?= img('files/logo.png') ?>
		<hr width="902px" align="left"/>
	</div>
	<div id="body">
	<!--<marquee><h1>JuanCalendar</h1></marquee> -->
		<div id="sidebar">
			<?= $sidebar?>
		</div>
		<div id="bodymain">
			<?= $body?>
		</div>
	</div>
	<div id="footer">
		Copyright &copy; 2009<?=nbs(20)?>•<?=nbs(10)?>jCalendar<?=nbs(10)?>•<?=nbs(20)?>jCalendar Team
	</div>
</body>
</html>
