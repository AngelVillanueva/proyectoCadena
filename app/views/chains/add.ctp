<!-- Archivo: /app/views/chains/add.ctp -->




<h2>Nueva Cadena</h2>


<?php echo $form->create('Chain', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id')?>
<?php echo $form->hidden('user_id', array('value' => $user_id));?>
<?php echo $form->hidden('username', array('value' => $username));?>
<?php echo $form->input('name');?>
<?php echo $form->input('description');?>
<?php echo $form->end('Siguiente'); ?>

