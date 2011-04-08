<?= doctype('html5'); ?>

<html>
<head>
	<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
	<?= link_tag('images/favicon.png', 'icon', 'image/png'); ?>

	<title>MovieDB</title>

	<?= link_tag('css/style.css'); ?>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

	<script type="text/javascript">
		var BASE_URL="<?= base_url(); ?>";
	</script>

	<script type="text/javascript">
		$('<style type="text/css">#movielist-container { display: none; }</style>').appendTo('head');
	</script>

	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.paginatetable.js"></script>

	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.loader-min.js"></script>

	<?= link_tag('css/jquery.loader.css'); ?>

	<script type="text/javascript" src="<?= base_url(); ?>js/jquery.moviedb.js"></script>

</head>
<body>
	<?= heading('MovieDB', 1); ?>
