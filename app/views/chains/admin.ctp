<!-- Archivo: /app/views/chains/admin.ctp -->

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
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Items', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Millas', true), 'miles'); ?></th>
		<th><?php echo $paginator->sort(__('Denunciada', true), 'denounced'); ?></th>
		<th><?php echo $paginator->sort(__('Aprobada', true), 'approved'); ?></th>
		<th><?php echo $paginator->sort(__('Aprobar', true), 'approve'); ?></th>
		
		
	</tr>
	
		<?php foreach($data as $chain): ?>
		
		<tr>
			<td><?php echo $chain['Chain']['id']; ?> </td>
			<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
			<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
			<td><?php echo $chain['Chain']['n_hits']; ?> </td>
			<td><?php echo $chain['Chain']['n_votes']; ?> </td>
			<td><?php echo $chain['Chain']['n_comments']; ?> </td>
			<td><?php echo $chain['Chain']['n_items']; ?> </td>
			<td><?php echo $chain['Chain']['miles']; ?> </td>
			<td><?php echo $chain['Chain']['denounced']; ?> </td>
			<td><?php echo $chain['Chain']['approved']; ?> </td>
			<td>
			<?php echo $form->create('Chain', array('action' => 'approve/'.$chain['Chain']['id']));?>
			<?php echo $form->end('aprobar cadena');?>
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
