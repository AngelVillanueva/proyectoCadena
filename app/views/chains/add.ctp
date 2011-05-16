<!-- Archivo: /app/views/chains/add.ctp -->




<h2>Nueva Cadena</h2>


<?php echo $form->create('Chain', array('enctype'=>"multipart/form-data"));?>
<?php echo $form->hidden('id')?>
<?php echo $form->hidden('user_id', array('value' => $user_id));?>
<?php echo $form->hidden('username', array('value' => $username));?>
<?php echo $form->input('name');?>
<?php echo $form->input('description', array('type' => 'textarea'));?>
<?php echo $form->input('chain', array('type' => 'file'));?>
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
$repeat_options = array(0 => 'No', 1 => 'Yes');
echo $this->Form->select('repeat', $repeat_options, 0)
?>
<br/>
<br/>
<?php
$objetive_options = array(100 => '100 millas', 1000 => '1000 millas', 10000 => '10000 millas');
echo $this->Form->select('next_objetive', $objetive_options, 100)
?>
<?php echo $form->input('security_code', array('label' => 'Please Enter the Sum of ' .$mathCaptcha));?>
<?php echo $form->end('Siguiente'); ?>

