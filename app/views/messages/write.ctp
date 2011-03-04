<!-- Archivo: /app/views/messages/write.ctp -->



<h2>Enviar mensaje a: <?php echo $receiver_username;?></h2>


<?php echo $form->create('Message', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id');?>
<?php echo $form->hidden('user_id', array('value' => $user_id));;?>
<?php echo $form->hidden('receiver_id', array('value' => $receiver_id));;?>
<?php echo $form->input('subject');?>
<?php echo $form->input('text');?>
<?php echo $form->end('Enviar'); ?>

