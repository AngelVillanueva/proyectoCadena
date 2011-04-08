<!-- Archivo: /app/views/users/admin.ctp -->

<?php if(empty($username))
{
echo $html->link('Login', array('controller' => 'users', 'action' => 'login')); 
}
else
{
	echo $session->read('Auth.User.username'); 
	echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
}
?>

<?php if($username == 'admin')
{
echo '<br/>';
echo $html->link('Administrar cadenas',array('controller' => 'chains', 'action' => 'admin'));
echo '<br/>';
echo $html->link('Administrar items',array('controller' => 'items', 'action' => 'admin'));
echo '<br/>';
echo $html->link('Administrar comentarios',array('controller' => 'comments', 'action' => 'admin'));
echo '<br/>';
echo $html->link('Administrar usuarios',array('controller' => 'users', 'action' => 'admin'));
}
?>

<br/>
<?php echo $html->link('NUEVA CADENA',array('controller' => 'chains', 'action' => 'add')); ?>
<br/>




<h2><br />Cadenas (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Username', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>
		<th><?php echo $paginator->sort(__('Role', true), 'role'); ?></th>
		<th><?php echo $paginator->sort(__('Mail', true), 'mail'); ?></th>
		<th><?php echo $paginator->sort(__('Image', true), 'image'); ?></th>
		<th><?php echo $paginator->sort(__('Active', true), 'active'); ?></th>
		<th><?php echo $paginator->sort(__('Activar', true), 'activar'); ?></th>
		
	</tr>
	
		<?php foreach($data as $user): ?>
		
		<tr>
			<td><?php echo $user['User']['id']; ?> </td>
			<td><?php echo $html->link($user['User']['username'],array('controller' => 'users', 'action' => 'account', $user['User']['username'])); ?></td>
			<td><?php echo $user['User']['created']; ?> </td>
			<td><?php echo $user['User']['role']; ?> </td>
			<td><?php echo $user['User']['mail']; ?> </td>
			<td><img src="<?php echo $this->webroot;?>attachments/users/avatar/<?php echo $user['User']['user_file_path']; ?>" </td>
			<td><?php echo $user['User']['active']; ?> </td>
		
			<td>
			<?php echo $form->create('User', array('action' => 'active/'.$user['User']['id']));?>
			<?php echo $form->end('Activar usuario');?>
			</td>
			
			
		</tr>
		
		<?php endforeach; ?>

</table>


<!-- Muestra los numeros de página -->

<?php echo $paginator->numbers(); ?>

<!-- Muestra los enlaces para Anterior y Siguiente -->

<?php
	echo $paginator->prev(__('<< Prev ', true), null, null, array('class' => 'disabled'));
	echo $paginator->next(__(' Next >>', true), null, null, array('class' => 'disabled'));

?>

<!-- Muestra X de Y, donde X es la página actual e Y el total de páginas -->

<?php echo $paginator->counter(); ?> 




<table>

	
	
	




