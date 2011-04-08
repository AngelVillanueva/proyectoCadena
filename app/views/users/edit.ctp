<?php
?>
<h2>Editar Usuario: <?php echo $username; ?></h2>
<?php    
echo $session->flash('auth');    
echo $form->create('User', array('enctype'=>"multipart/form-data"));  
echo $form->input('password', array('type' => 'password'));
echo $form->input('password_confirm', array('type' => 'password'));  
echo $form->input('user', array('type' => 'file'));
echo $form->end('Edit User');

?>

<img src="<?php echo $this->webroot;?>attachments/users/avatar/<?php echo $file_path; ?>"