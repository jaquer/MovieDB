<?= doctype('html4-trans'); ?>
<html>
<head>
	<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>

	<title>MovieDB</title>

	<?= link_tag('css/style.css'); ?>

	<?= link_tag('images/favicon.png', 'icon', 'image/png'); ?>

	<script type="text/javascript" src="<?= base_url(); ?>js/init.js"></script>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
	<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.fixheadertable.min.js"></script>
	<?= link_tag('css/jquery.fixheadertable.css'); ?>

</head>
<body>
	<?= heading('MovieDB', 1); ?>
	<hr>
