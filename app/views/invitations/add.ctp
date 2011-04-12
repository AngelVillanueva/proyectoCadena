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

<?php echo $form->hidden('Invitation.5.id')?>
<?php echo $form->hidden('Invitation.5.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.5.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.5.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.5.active', array('value' => 1));?>
<?php echo $form->input('Invitation.5.guest_name');?>
<?php echo $form->input('Invitation.5.guest_mail');?>

<?php echo $form->hidden('Invitation.6.id')?>
<?php echo $form->hidden('Invitation.6.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.6.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.6.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.6.active', array('value' => 1));?>
<?php echo $form->input('Invitation.6.guest_name');?>
<?php echo $form->input('Invitation.6.guest_mail');?>

<?php echo $form->hidden('Invitation.7.id')?>
<?php echo $form->hidden('Invitation.7.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.7.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.7.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.7.active', array('value' => 1));?>
<?php echo $form->input('Invitation.7.guest_name');?>
<?php echo $form->input('Invitation.7.guest_mail');?>

<?php echo $form->hidden('Invitation.8.id')?>
<?php echo $form->hidden('Invitation.8.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.8.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.8.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.8.active', array('value' => 1));?>
<?php echo $form->input('Invitation.8.guest_name');?>
<?php echo $form->input('Invitation.8.guest_mail');?>

<?php echo $form->hidden('Invitation.9.id')?>
<?php echo $form->hidden('Invitation.9.chain_id', array('value' => $chain_id));?>
<?php echo $form->hidden('Invitation.9.username', array('value' => $user));?>
<?php echo $form->hidden('Invitation.9.pending', array('value' => 1));?>
<?php echo $form->hidden('Invitation.9.active', array('value' => 1));?>
<?php echo $form->input('Invitation.9.guest_name');?>
<?php echo $form->input('Invitation.9.guest_mail');?>

<?php echo $form->end('Invitar'); ?>