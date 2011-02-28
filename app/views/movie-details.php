<?= doctype('html4-trans'); ?>
<html>
<head>
	<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>

	<title><?= $movie_name ?> - MovieDB</title>

	<?= link_tag('css/style.css'); ?>

	<?= link_tag('images/favicon.png', 'icon', 'image/png'); ?>

</head>
<body>
	<?= heading($movie_name, 1); ?>
	<hr>
	<?= heading('Movie Details', 3); ?>
	<dl>
		<dt>Name</dt>
			<dd><?= $movie_name; ?></dd>
		<dt>Year</dt>
			<dd><?= $movie_year; ?></dd>
		<dt>Status</dt>
			<dd><?= $movie_status; ?></dd>
		<dt>Added</dt>
			<dd><?= $movie_added; ?></dd>
		<dt>Votes</dt>
			<dd><?= $rating_count; ?></dd>
		<dt>Average Rating</dt>
			<dd><?= $rating_average; ?></dd>
	</dl>
	<?= heading('User Votes', 3); ?>
	<dl>
<? foreach ($users as $user): ?>
		<dt><?= $user['user_name']; ?></dt>
			<dd><?= $user['rating_value']; ?><? if ($user['rating_added']) echo ' on ' . $user['rating_added']; ?></dd>
<? endforeach ?>
	</dl>
</body>
</html>
