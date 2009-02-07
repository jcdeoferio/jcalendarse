<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>JCalendar - <?= $title ?></title>

	<?= link_tag('files/favicon.png', 'shortcut icon', 'image/ico'); ?>
	<?= link_tag('files/style.css') ?>
</head>

<body>
	<?= img('files/logo.png') ?>
	<hr width="899px" align="left"/>
	
	<!--<marquee><h1>JuanCalendar</h1></marquee> -->
	<?= $sidebar?>
	<?= $body?>
</body>

</html>
