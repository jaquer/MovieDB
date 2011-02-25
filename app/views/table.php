<script type="text/javascript">
document.write('<div id="movies-wrapper" style="display: none;">');
$.loader({content: '<strong>Loading Movies</strong>', background: {opacity: 1}});
</script>
<?= $table; ?>
<script type="text/javascript">
document.write('</div>');
$(document).ready(function() {
	var options = {
		width: 783,
		colratio: [140, 640],
		caption: '<?= $caption; ?>',
		showhide: false,
		pager: true,
		rowsPerPage: 25,
		wrapper: false
	}
	$('#movies-wrapper').show();
	$.loader('close');
	$('#movies-table').fixheadertable(options);
 });
 </script>
