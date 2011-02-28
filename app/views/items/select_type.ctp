<!-- Archivo: /app/views/items/select_type.ctp -->



<h2>Nuevo Elemento</h2>


<?php echo $form->create('Item', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('chain_id', array('value' => $chain_id));;?>
<?php
$options = array(0 => 'Selecciona', 1 => 'Text', 2 => 'Photo', 3 => 'Video');
echo $this->Form->select('type', $options)
?>
<?php echo $form->end('Siguiente'); ?>

