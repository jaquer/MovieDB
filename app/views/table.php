<?= $table; ?>
<script type="text/javascript">
$(document).ready(function() {
	var options = {
		width: 780,
		caption: '<?= $caption; ?>',
		showhide: false,
		pager: true,
		rowsPerPage: 25,
		wrapper: false
	}
	$('#movies-table').fixheadertable(options);
 });
 </script>
