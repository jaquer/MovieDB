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
	<?= anchor('http://m.imdb.com/title/' . $imdb_id, heading($movie_name . ' (' . $movie_year . ')', 1)); ?>

	<?= img(array('src' => 'cover/show/' . $movie_id, 'id' => 'movie-cover'), TRUE); ?>

	<dl class="tabular">
		<dt>Added</dt>
			<dd><span title="<?= $movie_added; ?>"><?= $movie_timespan; ?> ago.</span></dd>
		<dt>Status</dt>
			<dd><?= $movie_status; ?></dd>
		<dt>Average</dt>
			<dd><?= $rating_average; ?></dd>
	</dl>

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
