<!-- Archivo: /app/views/invitations/add.ctp -->




<h2>Invita a un amigo!</h2>

<?php echo $form->create('Invitation', array('enctype'=>"multipart/form-data"));?>

<?php echo $form->hidden('Invitation.0.id')?>
<?php echo $form->hidden('Invitation.0.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.0.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.0.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.0.active', array('value' => 1));?>
<?php echo $form->input('Invitation.0.guest_name');?>
<?php echo $form->input('Invitation.0.guest_mail');?>

<?php echo $form->hidden('Invitation.1.id')?>
<?php echo $form->hidden('Invitation.1.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.1.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.1.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.1.active', array('value' => 1));?>
<?php echo $form->input('Invitation.1.guest_name');?>
<?php echo $form->input('Invitation.1.guest_mail');?>

<?php echo $form->hidden('Invitation.2.id')?>
<?php echo $form->hidden('Invitation.2.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.2.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.2.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.2.active', array('value' => 1));?>
<?php echo $form->input('Invitation.2.guest_name');?>
<?php echo $form->input('Invitation.2.guest_mail');?>

<?php echo $form->hidden('Invitation.3.id')?>
<?php echo $form->hidden('Invitation.3.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.3.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.3.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.3.active', array('value' => 1));?>
<?php echo $form->input('Invitation.3.guest_name');?>
<?php echo $form->input('Invitation.3.guest_mail');?>

<?php echo $form->hidden('Invitation.4.id')?>
<?php echo $form->hidden('Invitation.4.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.4.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.4.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.4.active', array('value' => 1));?>
<?php echo $form->input('Invitation.4.guest_name');?>
<?php echo $form->input('Invitation.4.guest_mail');?>



<?php echo $form->end('Invitar'); ?>