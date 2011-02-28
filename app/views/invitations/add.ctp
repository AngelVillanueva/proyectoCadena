<!-- Archivo: /app/views/invitations/add.ctp -->




<h2>Invita a un amigo!</h2>


<?php echo $form->create('Invitation', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id')?>
<?php echo $form->hidden('chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('username', array('value' => $user));?>
<?php echo $form->hidden('pending', array('value' => 1));?>
<?php echo $form->input('guest_name');?>
<?php echo $form->input('guest_mail');?>
<?php echo $form->end('Invitar'); ?>