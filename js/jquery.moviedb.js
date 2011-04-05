$(function() {

	/* Show stars, hide radio buttons. */
	$('.movielist img').show();
	$('.movielist input').hide();
	/* Attach event handlers to radio buttons change. */
	$('.movielist input').change(function() {
		updateStar($(this));
	});

	/* Make entire table cell containing link clickable. */
	$('.movielist td').click(function(){
		sURL = $(this).find('a').attr('href');
		if (sURL) {
			$('#movie-details').attr('src', sURL);
			return false;
		}
	});

	/* Paginate the table and show it. */
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

	/* Fix the pager's position to the place where it first appears.
	   This is to prevent it from "floating up" when the table shrinks. */
	var oPager = $('#pager');
	oPager.show();

	var oPagerPosition = oPager.position();
	oPager.css('position', 'fixed');
	oPager.css('left', oPagerPosition.left);
	oPager.css('top', oPagerPosition.top);

});

/* Change star images on radio button value change. */
function updateStar(oRadio) {

	oParent = oRadio.parents('td');
	oStars  = oParent.find('img');

	iValue = oRadio.val();

	if (iValue == 0)
		$(oStars[0]).attr('src', '/moviedb/images/not-interested.png');
	else
		$(oStars[0]).attr('src', '/moviedb/images/not-interested-off.png');

	for (iIndex = 1; iIndex <= 5; iIndex++)
		if (iIndex <= iValue)
			$(oStars[iIndex]).attr('src', '/moviedb/images/star.png');
		else
			$(oStars[iIndex]).attr('src', '/moviedb/images/star-off.png');

}

/* Closing the loader on $(document).ready() would still show the table "folding up" when paginated. */
$(window).ready(function() {
	$.loader('close');
});
