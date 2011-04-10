<div id="movielist-container">
<script type="text/javascript">
	$.loader({content: '<strong>Loading Movies</strong>', background: {opacity: 1}});
</script>
<?= form_open('movielist/save'); ?>
<?= form_hidden('user_id', $this->session->userdata('user_id')); ?>
<?= $table; ?>
<p id="pager">
	<span id="current-page" style="display: none;"></span>
	<a href="#" title="Previous Page" id="previous-page-button">&laquo;</a>
	<span id="page-numbers"></span>
	<a href="#" title="Next Page" id="next-page-button">&raquo;</a>
</p>
<p id="form-buttons">
<?= form_submit(array('name' => 'exit', 'id' => 'exit-button'), 'Exit'); ?>
<?= form_submit(array('name' => 'save', 'id' => 'save-button'), 'Save Selections'); ?>
</p>
<?= form_close(); ?>
<iframe name="movie-details" id="movie-details" seamless></iframe>
</div><!-- #movielist-container -->
