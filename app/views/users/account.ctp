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

<br/>
<?php echo $html->link('Inbox ('.$new_messages.'/'.$messages.')',array('controller' => 'messages', 'action' => 'inbox')); ?>
<br/>
<br/>




<h2><?php echo $account_username;?></h2>
<img src="<?php echo $this->webroot;?>attachments/users/avatar/<?php echo $file_path; ?>"
<br/>
<br/>

<h2>Seguidores: <?php echo $supporters;?></h2>


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
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
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
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>


<table>

<h2>Cadenas que sigue:</h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($fav_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>


<table>

<h2>Usuarios que sigue:</h2>
	<tr>
		<th><?php echo $paginator->sort(__('User', true), 'image'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'username'); ?></th>
		
			
	</tr>
	
	<?php foreach($fav_users as $user): ?>
	
	<tr>
		<td><img src="<?php echo $this->webroot;?>attachments/users/avatar/<?php echo $user['User']['user_file_path']; ?>" </td>
		<td><?php echo $html->link($user['User']['username'],array('controller' => 'users', 'action' => 'account', $user['User']['username'])); ?></td>	
	</tr>
	
	<?php endforeach; ?>
	
	

</table>



<?php
if($check_user==1)
{

if($check_fav == 0)
{

echo $form->create('Favorite', array('controller' => 'favorites', 'action' => 'add/'.$account_id.'/0'));
echo $form->end('Seguir usuario'); 

}

echo $form->create('Message', array('controller' => 'messages', 'action' => 'write/'.$account_id));
echo $form->end('Enviar mensaje'); 

}
?>


	
	
	




