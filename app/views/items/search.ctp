<!-- Archivo: /app/views/chains/buscador.ctp -->

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



<h2><br />Buscador CADENAS</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Items', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Millas', true), 'miles'); ?></th>
		<th><?php echo $paginator->sort(__('Meta', true), 'objetive'); ?></th>
		
		
	</tr>
	
		<?php foreach($b_chains as $chain): ?>
		
		<tr>
			<td><?php echo $chain['Chain']['id']; ?> </td>
			<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
			<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
			<td><?php echo $chain['Chain']['n_hits']; ?> </td>
			<td><?php echo $chain['Chain']['n_votes']; ?> </td>
			<td><?php echo $chain['Chain']['n_comments']; ?> </td>
			<td><?php echo $chain['Chain']['n_items']; ?> </td>
			<td><?php echo $chain['Chain']['miles']; ?> </td>
			<td><?php echo $chain['Chain']['next_objetive']; ?> </td>
		
			
		</tr>
		
		<?php endforeach; ?>

</table>

<h2><br />Buscador ITEMS</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>

		
		
	</tr>
	
		<?php foreach($b_items as $item): ?>
		
		<tr>
			<td><?php echo $item['Item']['id']; ?> </td>
			<td><?php echo $html->link($item['Item']['name'],array('controller' => 'chains', 'action' => 'view', $item['Item']['id'])); ?></td>
			<td><?php echo $html->link($item['Item']['username'],array('controller' => 'users', 'action' => 'account', $item['Item']['username'])); ?></td>
			<td><?php echo $item['Chain']['n_hits']; ?> </td>
			<td><?php echo $item['Chain']['n_votes']; ?> </td>
			<td><?php echo $item['Chain']['n_comments']; ?> </td>
			<td><?php echo $item['Chain']['created']; ?> </td>
	
		
			
		</tr>
		
		<?php endforeach; ?>

</table>



	
<h2><br />Buscador USUARIOS</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
	
	</tr>
	
		<?php foreach($b_users as $user): ?>
		
		<tr>
			<td><?php echo $user['User']['id']; ?> </td>
			<td><?php echo $html->link($user['User']['username'],array('controller' => 'users', 'action' => 'account', $user['User']['username'])); ?></td>
			
			
			
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
