<?= doctype('html5'); ?>

<html>
<head>
	<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv'); ?>
	<?= link_tag('images/favicon.png', 'icon', 'image/png'); ?>

	<title><?= $movie_name ?> - MovieDB</title>

	<?= link_tag('https://fonts.googleapis.com/css?family=Droid+Sans'); ?>

	<?= link_tag('css/style.css'); ?>
	<style type="text/css">
	/* Override main CSS */
	body {
		font-size: 8pt;
		width: auto;
		margin: 0;
		padding: 0;
		float: none;
	}
	h1 {
		font-size: 1.25em;
		border: none;
		text-align: center;
	}
	h1 img,
	span img {
		vertical-align: bottom;
	}
	</style>

</head>
<body>
	<?= anchor('http://m.imdb.com/title/' . $imdb_id, heading($movie_name, 1)); ?>

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

	<?= heading('Votes', 3); ?>
	<ul>
<? foreach ($users as $user): ?>
		<li><?= $user['user_name'], br(), $user['rating_stars']; ?>
		<? if ($user['rating_date']): ?>
		<span title="<?= $user['rating_date']; ?>"><?= $user['rating_timespan']; ?> ago.</span>
		<? endif; ?>
		</li>
<? endforeach; ?>
	</ul>
</body>
</html>
