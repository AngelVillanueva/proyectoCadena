<h2>Introduce tu dirección de correo</h2>
<?php       
echo $this->Form->create('User', array('action' => 'forgotPass/'.$token));   
echo $form->input('password', array('type' => 'password'));
echo $form->input('password_confirm', array('type' => 'password'));   
echo $this->Form->end('Reset Password');

?>



