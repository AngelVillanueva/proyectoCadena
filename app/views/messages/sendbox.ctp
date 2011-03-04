<!-- Archivo: /app/views/messages/sendbox.ctp -->

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


<h2>Mensajes enviados</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('To', true), 'user_id'); ?></th>
		<th><?php echo $paginator->sort(__('Subject', true), 'subject'); ?></th>
		<th><?php echo $paginator->sort(__('Text', true), 'text'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>
		<th><?php echo $paginator->sort(__('Read', true), 'read'); ?></th>
		<th><?php echo $paginator->sort(__('Deleted', true), 'deleted'); ?></th>
		
	</tr>
	
		<?php foreach($data as $message): ?>
		
		<tr>
			<td><?php echo $message['Receiver']['username']; ?> </td>
			<td><?php echo $message['Message']['subject']; ?> </td>
			<td><?php echo $message['Message']['text']; ?> </td>
			<td><?php echo $message['Message']['created']; ?> </td>
			<td><?php echo $message['Message']['read']; ?> </td>
			<td><?php echo $message['Message']['deleted']; ?> </td>
			
			
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

<?php
echo $html->link('Mensajes recibidos', array('controller' => 'messages', 'action' => 'inbox'));
?>


