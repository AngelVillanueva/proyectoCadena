<!-- Archivo: /app/views/chains/voted_chains.ctp -->

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
<?php echo $html->link('NUEVA CADENA',array('controller' => 'chains', 'action' => 'add')); ?>


<br/>
<h2><br />Mas votadas</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_comments'); ?></th>
		
	</tr>
	
		<?php foreach($data as $chain): ?>
		
		<tr>
			<td><?php echo $chain['Chain']['id']; ?> </td>
			<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
			<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
			<td><?php echo $chain['Chain']['n_hits']; ?> </td>
			<td><?php echo $chain['Chain']['n_votes']; ?> </td>
			<td><?php echo $chain['Chain']['n_comments']; ?> </td>
			
			
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






	
	
	




