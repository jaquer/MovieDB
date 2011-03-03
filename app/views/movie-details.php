<?= doctype('html5'); ?>

<html>
<head>
	<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
	<?= link_tag('images/favicon.png', 'icon', 'image/png'); ?>

	<title><?= $movie_name ?> - MovieDB</title>

</head>
<body>
	<?= heading($movie_name, 1); ?>

	<?= heading('Movie Details', 3); ?>
	<dl class="tabular">
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
		<dt>Average</dt>
			<dd><?= $rating_average; ?></dd>
	</dl>

	<?= heading('User Votes', 3); ?>
	<dl class="tabular">
<? foreach ($users as $user): ?>
		<dt><?= $user['user_name']; ?></dt>
			<dd><?= $user['rating_value']; ?><? if ($user['rating_added']) echo ' on ' . $user['rating_added']; ?></dd>
<? endforeach; ?>
	</dl>

	<?= heading('IMdB Information ' . anchor('http://www.imdb.com/title/' . $imdb_id, img('images/imdb.png'), 'target="imdb" title="IMdB Full Site"'), 3); ?>
	<iframe src="http://m.imdb.com/title/<?= $imdb_id; ?>" width="320" height="480">
		<p><strong><?= anchor('http://www.imdb.com/title/' . $imdb_id, $movie_name); ?></strong> at The Internet Movie Database</p>
	</iframe>

</body>
</html>
