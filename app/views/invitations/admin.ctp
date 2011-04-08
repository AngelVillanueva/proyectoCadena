<!-- Archivo: /app/views/comments/admin.ctp -->

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
}
?>




<h2><br />Invitaciones</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Chain_id', true), 'chain_id'); ?></th>
		<th><?php echo $paginator->sort(__('User', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Guest', true), 'guest_name'); ?></th>
		<th><?php echo $paginator->sort(__('Guest Mail', true), 'guest_mail'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>
		<th><?php echo $paginator->sort(__('Pending', true), 'pending'); ?></th>
		<th><?php echo $paginator->sort(__('Active', true), 'active'); ?></th>
		<th><?php echo $paginator->sort(__('Delete', true), 'delete'); ?></th>
		
	</tr>
	
		<?php foreach($data as $invitation): ?>
		
		<tr>
			<td><?php echo $invitation['Invitation']['id']; ?> </td>
			<td><?php echo $html->link($invitation['Invitation']['chain_id'],array('controller' => 'chains', 'action' => 'view', $invitation['Invitation']['chain_id'])); ?></td>
			<td><?php echo $html->link($invitation['Invitation']['username'],array('controller' => 'users', 'action' => 'account', $invitation['Invitation']['username'])); ?></td>
			<td><?php echo $html->link($invitation['Invitation']['guest_name'],array('controller' => 'users', 'action' => 'account', $invitation['Invitation']['guest_name'])); ?></td>
			<td><?php echo $invitation['Invitation']['guest_mail']; ?> </td>
			<td><?php echo $invitation['Invitation']['created']; ?> </td>
			<td><?php echo $invitation['Invitation']['pending']; ?> </td>
			<td><?php echo $invitation['Invitation']['active']; ?> </td>
			<td>
			<?php echo $form->create('Invitation', array('action' => 'delete/'.$invitation['Invitation']['id']));?>
			<?php echo $form->end('Borrar invitacion');?>
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

