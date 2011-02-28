<!-- Archivo: /app/views/chains/invite.ctp -->




<h2>Invita a un amigo!</h2>


<?php echo $form->create('Invitation', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id')?>
<?php echo $form->input('guest_name');?>
<?php echo $form->input('guest_mail');?>
<?php echo $form->end('Invitar'); ?>

