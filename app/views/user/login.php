<?=
	form_open('user/login') .
	form_fieldset('Select User', array('id' => 'loginform')) .
	form_dropdown('user_id', $users) .
	form_submit('submit', 'Enter Site') .
	form_fieldset_close() .
	form_close();
?>
<!--  image preload -->
<?
	$images = array('not-interested', 'not-interested-off', 'star', 'star-off', 'star-hover','remove');
	foreach ($images as $image):
?>
<?=
	img(array('src' => "images/" . $image . ".png", 'style' => "display: none;"));
?>
<?
	endforeach;
?>
