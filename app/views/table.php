<?= $table; ?>
<script type="text/javascript">
$(document).ready(function() {
	var options = {
		width: 783,
		colratio: [130, 650],
		caption: '<?= $caption; ?>',
		showhide: false,
		pager: true,
		rowsPerPage: 25,
		wrapper: false
	}
	$('#movies-table').fixheadertable(options);
 });
 </script>
