<script type="text/javascript">
	$.loader({content: '<strong>Loading Movies</strong>', background: {opacity: 1}});
</script>
<?= $table; ?>
<p id="pager">
	<span id="current-page" style="display: none;"></span>
	<a href="#" title="Previous Page" id="previous-page-button">&laquo;</a>
	<span id="page-numbers"></span>
	<a href="#" title="Next Page" id="next-page-button">&raquo;</a>
</p>
<iframe name="movie-details" id="movie-details" seamless></iframe>
