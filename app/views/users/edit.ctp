<?php
?>
<h2>Editar Usuario</h2>
<?php    
echo $session->flash('auth');    
echo $form->create('User', array('enctype'=>"multipart/form-data"));    
echo $form->input('user', array('type' => 'file'));
echo $form->end('Edit User');

?>

<img src="<?php echo $this->webroot;?>attachments/users/avatar/<?php echo $file_path; ?>"