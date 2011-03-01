<?=
	form_open('user/login') .
	form_fieldset('Select user', array('id' => 'loginform')) .
	form_dropdown('user_id', $users) .
	form_submit('submit', 'Enter site') .
	form_fieldset_close() .
	form_close();
?>
<!--  image preload -->
<?
	$images = array('not-interested-on', 'not-interested-off', 'star-on', 'star-off', 'star-hover','remove');
	foreach ($images as $image):
?>
<?=
	img(array('src' => "images/" . $image . ".png", 'style' => "display: none;"));
?>
<?
	endforeach;
?>
