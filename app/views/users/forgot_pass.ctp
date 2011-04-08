<h2>Introduce tu dirección de correo</h2>
<?php       
echo $this->Form->create('User', array('action' => 'forgotPass'));   
echo $this->Form->input('mail');    
echo $this->Form->end('Enviar');

?>



