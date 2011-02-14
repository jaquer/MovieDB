<?= doctype('html4-trans'); ?>
<html>
<head>
	<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>

	<title>MovieDB</title>

	<?= link_tag('css/style.css'); ?>

	<?= link_tag('images/favicon.png', 'icon', 'image/png'); ?>

	<script type="text/javascript" src="<?= base_url() ?>js/init.js"></script>

</head>
<body>
	<?= heading('MovieDB', 1); ?>
	<hr>
