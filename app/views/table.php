<script type="text/javascript">
document.write('<div id="movies-wrapper" style="display: none;">');
$.loader({content: '<strong>Loading Movies</strong>', background: {opacity: 1}});
</script>
<?= $table; ?>
<div id="pager">
	<span id="current-page" style="display: none;"></span>
	<a href="#" alt="Previous Page" id="previous-page">&laquo;</a>
	<span id="page-numbers"></span>
	<a href="#" alt="Next Page" id="next-page">&raquo;</a>
</div>
<script type="text/javascript">
document.write('</div>');
$(document).ready(function() {
	var oOptions = {
		rowsPerPage: 25,
		pager: '#pager',
		nextPage: '#next-page',
		prevPage: '#previous-page',
		currentPage: '#current-page',
		pageNumbers: '#page-numbers:'
	}
	$('#movies-table').paginateTable(oOptions);

	$('#movies-wrapper').show();

	$.loader('close');

 });
 </script>
