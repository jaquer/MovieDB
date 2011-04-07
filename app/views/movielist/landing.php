<? header('Refresh: 30; url=' . site_url('movielist/unrated')); ?>
<?= heading('Select your destination:', 2); ?>
<ul>
	<li><?= anchor('movielist/orphaned', 'Movies Missing Your Rating'); ?><br/>
	Movies missing <strong>only</strong> your rating. Consider going here first.</li>
	<li><?= anchor('movielist/unrated', 'Unrated Movies'); ?><br/>
	Movies you haven't rated. You'll be automatically sent here in 30 seconds.</li>
	<li><?= anchor('movielist/all', 'All Movies'); ?><br/>
	Check out ratings on all movies in the database.</li>
	<li><?= anchor('movielist/delete', 'Movies to Delete'); ?><br/>
	Active movies, with ratings from all users and average rating of less than 3.0.</li>
</ul>
