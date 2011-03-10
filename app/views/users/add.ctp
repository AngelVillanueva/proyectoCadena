<?php
?>
<h2>Registrar Usuario</h2>
<?php    
echo $session->flash('auth');    
echo $form->create('User', array('type' => 'file'));    
echo $form->input('username');    
echo $form->input('password');
$options=array('1'=>'Admin','2'=>'Registered');
echo $form->select('role',$options);  
echo $form->input('user', array('type' => 'file'));
echo $form->end('Add User');

?>