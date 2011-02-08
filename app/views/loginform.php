
<?= form_open('user/login'); ?>

<?= form_fieldset('Select user', array('id' => 'loginform')); ?>

<?= form_dropdown('user_id', $users); ?>

<?= form_submit('submit', 'Enter site'); ?>

<!--  image preload -->
<?php
	$images = array('ni_on', 'ni_off', 'star_on', 'star_off', 'delete');
	foreach($images as $image):
		echo img(array('src' => $image . ".png", 'style' => "display: none;"));
	endforeach
?>
