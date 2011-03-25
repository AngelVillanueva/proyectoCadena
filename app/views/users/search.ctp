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

<?php
echo $form->create('', array('action'=>'search'));
echo $form->input('search', array('type'=>'text'));
echo $form->end('Buscador');
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
			<td><?php echo $chain['Objetive']['miles']; ?> </td>
		
			
		</tr>
		
		<?php endforeach; ?>

</table>



<!-- Muestra los numeros de página -->

<?php
echo $this->Paginator->counter(array(
	'format' => 'Page %page% of %pages%,
				showing %current% records out of %count% total,
				starting on record %start%, ending on %end%',
	'model' =>	'Chain',
));

echo $this->Paginator->prev( $title = '<< Prev ', array ('model' => 'Chain','update' => 'updatehere' ));
echo $this->Paginator->next( $title = 'Next >>', array ('model' => 'Chain' ));
?>
<div id="updatehere">
</div>
	
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

<?php
echo $this->Paginator->counter(array(
	'format' => 'Page %page% of %pages%,
				showing %current% records out of %count% total,
				starting on record %start%, ending on %end%',
	'model' =>	'User'
	
));
echo $this->Paginator->prev( $title = '<< Prev ', array ('model' => 'User' ));
echo $this->Paginator->next( $title = 'Next >>', array ('model' => 'User' ));
?>
<div id="updatehere2">
</div>
<div id="loadhere2">
</div>