<!-- Archivo: /app/views/users/view.ctp -->

<?php if(empty($user))
{
echo $html->link('Login', array('controller' => 'users', 'action' => 'login')); 
}
else
{
	echo $session->read('Auth.User.username'); 
	echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); 
}
?>

<br/>
<br/>
<?php echo $html->link('INICIO',array('controller' => 'chains', 'action' => 'index')); ?>
<br/>
<br/>


<br/>
<h2><br />Usuarios</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Eliminar solo usuario', true), 'delete'); ?></th>
		<th><?php echo $paginator->sort(__('Eliminar usuario y sus aportaciones', true), 'delete_cascade'); ?></th>
		
	</tr>
	
		<?php foreach($data as $account): ?>
		
		<tr>
			<td><?php echo $account['User']['id']; ?> </td>
			<td><?php echo $html->link($account['User']['username'],array('controller' => 'users', 'action' => 'account', $account['User']['username'])); ?></td>
			<td><?php echo $account['User']['created']; ?> </td>
			<td>
			<?php echo $form->create('User', array('action' => 'delete/'.$account['User']['id'].'/'.1));?>
			<?php echo $form->end('Eliminar solo usuario');?>
			</td>
			<td>
			<?php echo $form->create('User', array('action' => 'delete/'.$account['User']['id'].'/'.0'));?>
			<?php echo $form->end('Eliminar usuario y aportaciones');?>
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







	
	
	




