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
	<?= $sidebar?>
	<?= $body?>
	</div>
	<!--<?= br(5)?>-->
	<div id="footer">
		<p id="footertext">Copyright &copy; 2009<?=nbs(20)?>•<?=nbs(2)?>jCalendar<?=nbs(2)?>•<?=nbs(20)?>jCalendar Team</p>
	</div>
</body>
</html>
