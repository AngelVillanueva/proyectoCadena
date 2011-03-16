<!-- Archivo: /app/views/items/search.ctp -->

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




<h2><br />Items (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Chain', true), 'chain_id'); ?></th>
		<th><?php echo $paginator->sort(__('Type', true), 'type'); ?></th>
		<th><?php echo $paginator->sort(__('Position', true), 'position'); ?></th>
		<th><?php echo $paginator->sort(__('Path', true), 'item_file_path'); ?></th>
		<th><?php echo $paginator->sort(__('Size', true), 'item_file_size'); ?></th>
		<th><?php echo $paginator->sort(__('Denounced', true), 'denounced'); ?></th>
		<th><?php echo $paginator->sort(__('Approved', true), 'approved'); ?></th>
		
		
	</tr>
	
		<?php foreach($data as $item): ?>
		
		<tr>
			<td><?php echo $item['Item']['id']; ?> </td>
			<td><?php echo $html->link($item['Item']['name'],array('controller' => 'items', 'action' => 'view', $item['Item']['id'])); ?></td>
			<td><?php echo $html->link($item['Item']['username'],array('controller' => 'users', 'action' => 'account', $item['Item']['username'])); ?></td>
			<td><?php echo $item['Item']['n_hits']; ?> </td>
			<td><?php echo $item['Item']['n_votes']; ?> </td>
			<td><?php echo $item['Item']['n_comments']; ?> </td>
			<td><?php echo $html->link($item['Item']['chain_id'],array('controller' => 'chains', 'action' => 'view', $item['Item']['chain_id'])); ?></td>
			<td><?php echo $item['Item']['type']; ?> </td>
			<td><?php echo $item['Item']['position']; ?> </td>
			<td><?php echo $item['Item']['item_file_path']; ?> </td>
			<td><?php echo $item['Item']['item_file_size']; ?> </td>
			<td><?php echo $item['Item']['denounced']; ?> </td>
			<td><?php echo $item['Item']['approved']; ?> </td>
			
			
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

