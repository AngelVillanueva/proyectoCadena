<!-- Archivo: /app/views/chains/add.ctp -->




<h2>Nueva Cadena</h2>


<?php echo $form->create('Chain', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id')?>
<?php echo $form->hidden('user_id', array('value' => $user_id));?>
<?php echo $form->hidden('username', array('value' => $username));?>
<?php echo $form->input('name');?>
<?php echo $form->input('description');?>
<?php
$restricted_options = array(0 => 'Open', 1 => 'Restricted');
echo $this->Form->select('restricted', $restricted_options, 0)
?>
<br/>
<br/>
<?php
$private_options = array(0 => 'Public', 1 => 'Private');
echo $this->Form->select('private', $private_options, 0)
?>
<br/>
<br/>
<?php
$objetive_options = array(0 => '100 miles', 1 => '1000 miles', 2 => '10000 miles');
echo $this->Form->select('objetive', $objetive_options, 0)
?>
<?php echo $form->end('Siguiente'); ?>

