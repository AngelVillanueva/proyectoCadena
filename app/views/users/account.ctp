<!-- Archivo: /app/views/users/account.ctp -->

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
<br/>
<?php echo $html->link('Tienes '.$pending.' invitacion(es) pendientes!',array('controller' => 'invitations', 'action' => 'view')); ?>
<br/>
<br/>

<table>
<h2><?php echo $html->link($tittle1,array('controller' => 'chains', 'action' => 'user_chains', $account_id)); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($user_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['user_id'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>

<table>

<h2><?php echo $html->link($tittle2,array('controller' => 'chains', 'action' => 'join_chains', $account_id)); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($join_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['user_id'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>





	
	
	




