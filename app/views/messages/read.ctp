<!-- Archivo: /app/views/messages/inbox.ctp -->

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

<br/>
<br/>
<?php echo $html->link('INICIO',array('controller' => 'chains', 'action' => 'index')); ?>
<br/>
<br/>



<h2>Conversación</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('From', true), 'user_id'); ?></th>
		<th><?php echo $paginator->sort(__('Subject', true), 'subject'); ?></th>
		<th><?php echo $paginator->sort(__('Text', true), 'text'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>
		<th><?php echo $paginator->sort(__('Read', true), 'read'); ?></th>
		<th><?php echo $paginator->sort(__('Deleted', true), 'deleted'); ?></th>
		<th><?php echo $paginator->sort(__('Delete', true), 'delete'); ?></th>
		
	</tr>
	
		<?php foreach($data as $message): ?>
		
		<tr>
			<td><?php echo $message['From']['username']; ?> </td>
			<td><?php echo $message['Message']['subject']; ?> </td>
			<td><?php echo $message['Message']['text']; ?> </td>
			<td><?php echo $message['Message']['created']; ?> </td>
			<td><?php echo $message['Message']['read']; ?> </td>
			<td><?php echo $message['Message']['deleted']; ?> </td>
			<td>
			<?php echo $form->create('Message', array('action' => 'delete/'.$message['Message']['id']));?>
			<?php echo $form->end('Borrar');?>
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

<br/>
<br/>

<?php echo $form->create('Message', array('controller' => 'messages', 'action' => 'write/'.$from_id.'/'.$conv_id));?>
<?php echo $form->hidden('id');?>
<?php echo $form->hidden('user_id', array('value' => $user_id));;?>
<?php echo $form->hidden('conv_id', array('value' => $conv_id));;?>
<?php echo $form->hidden('receiver_id', array('value' => $from_id));;?>
<?php echo $form->input('text');?>
<?php echo $form->end('Responder'); ?>

<?php
echo $html->link('Mensajes enviados', array('controller' => 'messages', 'action' => 'sendbox'));
?>


