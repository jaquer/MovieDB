/* Show stars, hide radio buttons and attach event handlers to their change. */
$(function() {
	$('.movielist img').show();
	$('.movielist input').hide();
	$('.movielist input').change(function() {
		updateStar($(this));
	});
});

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

/* Make entire table cell containing link clickable. */
$(function() {
	$(".movielist td").click(function(){
		sURL = $(this).find("a").attr("href");
		if (sURL) {
			$('#movie-details').attr('src', sURL);
			return false;
		}
	});
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

$(window).ready(function() {
	$.loader('close');
});
