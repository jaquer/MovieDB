<?= $table; ?>
<script type="text/javascript">
$(document).ready(function() {
	var options = {
		caption: 'Unrated items',
		showhide: false,
		pager: true,
		rowsPerPage: 25,
		height: 655,
		wrapper: false
	}
	$('#item-table').fixheadertable(options);
 });
 </script>
