
<?= form_open('user/login'); ?>

<?= form_fieldset('Select user', array('id' => 'loginform')); ?>

<?= form_dropdown('user_id', $users); ?>

<?= form_submit('submit', 'Enter site'); ?>
