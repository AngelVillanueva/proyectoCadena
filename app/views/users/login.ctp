<?php    

echo $session->flash('auth');    
echo $this->Form->create('User', array('action' => 'login'));    
echo $this->Form->input('username');    
echo $this->Form->input('password');    
echo $this->Form->end('Login');

?>

<?php

echo $html->link('Has perdido la password?', array('controller' => 'users', 'action' => 'forgotPass')); 

?>

