/* Paginate the table, and set the pager position to static. */
$(function() {
	var oOptions = {
			rowsPerPage: 25,
			pager: '#pager',
			nextPage: '#next-page-button',
			prevPage: '#previous-page-button',
			currentPage: '#current-page',
			pageNumbers: '#page-numbers:'
	}

	$('.movielist').paginateTable(oOptions);

	$('.movielist').show();

	var oPager = $('#pager');
	oPager.show();

	var oPagerPosition = oPager.position();
	oPager.css('position', 'fixed');
	oPager.css('left', oPagerPosition.left);
	oPager.css('top', oPagerPosition.top);
});
