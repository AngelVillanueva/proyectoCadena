<!-- Archivo: /app/views/chains/index.ctp -->

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

<br/>
<br/>
<?php echo $html->link('Perfil',array('controller' => 'users', 'action' => 'account')); ?>
<br/>
<br/>
<?php echo $html->link('NUEVA CADENA',array('controller' => 'chains', 'action' => 'add')); ?>
<br/>
<br/>
<?php echo $html->link('REGISTRAR USUARIO',array('controller' => 'users', 'action' => 'add')); ?>
<br/>
<br/>
<?php echo $html->link('Tienes '.$pending.' invitacion(es) pendientes!',array('controller' => 'invitations', 'action' => 'view')); ?>


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
		<th><?php echo $paginator->sort(__('Meta', true), 'objetive'); ?></th>
		
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
			<td><?php echo $chain['Objetive']['miles']; ?> </td>
			
			
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
<br/>
<br/>
<h2><?php echo $html->link('MAS VISITADAS',array('controller' => 'chains', 'action' => 'visited_chains')); ?></h2>

	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		
	</tr>

	<?php foreach($visited_chains as $chain): ?>

	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_hits']; ?> </td>

	
	</tr>

	<?php endforeach; ?>
	
</table>


<table>
<br/>
<br/>
<h2><?php echo $html->link('MAS COMENTADAS',array('controller' => 'chains', 'action' => 'comment_chains')); ?></h2>

	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_hits'); ?></th>
		
	</tr>

	<?php foreach($comment_chains as $chain): ?>

	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_comments']; ?> </td>

	
	</tr>

	<?php endforeach; ?>
	
</table>

	

	
<table>
<br/>
<br/>
<h2><?php echo $html->link('MAS VOTADAS',array('controller' => 'chains', 'action' => 'voted_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
			
	</tr>
	
	<?php foreach($voted_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_votes']; ?> </td>
	
		
	</tr>
	
	<?php endforeach; ?>

</table>


<table>
<br/>
<br/>
<h2><?php echo $html->link('Con mas Items!',array('controller' => 'chains', 'action' => 'item_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Items', true), 'n_items'); ?></th>
			
	</tr>
	
	<?php foreach($item_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_items']; ?> </td>
	
		
	</tr>
	
	<?php endforeach; ?>

</table>
	

<table>
<br/>
<br/>
<h2><?php echo $html->link('Tus cadenas!',array('controller' => 'chains', 'action' => 'user_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($user_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>

<table>

<h2><?php echo $html->link('Cadenas en las que has participado (añadido items)',array('controller' => 'chains', 'action' => 'join_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($join_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>





	
	
	




