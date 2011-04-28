<?php
?>
<h2>Registrar Usuario</h2>
<?php    
echo $session->flash('auth');    
echo $form->create('User', array('type' => 'file'));    
echo $form->input('username');    
echo $form->input('password', array('type' => 'password'));
echo $form->input('password_confirm', array('type' => 'password'));
echo $form->input('mail');
echo $form->hidden('role', array('value' => 2));
echo $form->input('user', array('type' => 'file'));
echo $form->input('security_code', array('label' => 'Please Enter the Sum of ' .$mathCaptcha));
echo $form->end('Add User');

?>