<?= $table; ?>
<script type="text/javascript">
$(document).ready(function() {
	var options = {
		caption: 'Unrated movies',
		showhide: false,
		pager: true,
		rowsPerPage: 25,
		wrapper: false
	}
	$('#movies-table').fixheadertable(options);
 });
 </script>
