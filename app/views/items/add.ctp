<!-- Archivo: /app/views/items/add.ctp -->



<h2>Nuevo Elemento</h2>


<?php echo $form->create('Item', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id');?>
<?php echo $form->hidden('chain_id', array('value' => $chain_id));;?>
<?php echo $form->hidden('type', array('value' => $item_type));;?>
<?php echo $form->hidden('user_id', array('value' => $user_id));;?>
<?php echo $form->hidden('username', array('value' => $username));;?>
<?php echo $form->input('name');?>
<?php echo $form->input('description');?>
<?php echo $form->input('link');?>
<?php echo $form->input('item', array('type' => 'file'));?>
<?php echo $form->end('Siguiente'); ?>

