<!-- Archivo: /app/views/comments/admin.ctp -->

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




<h2><br />Comments (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('User', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Chain', true), 'chain_id'); ?></th>
		<th><?php echo $paginator->sort(__('Item', true), 'item_id'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>
		<th><?php echo $paginator->sort(__('Text', true), 'text'); ?></th>
		<th><?php echo $paginator->sort(__('Denounced', true), 'denounced'); ?></th>
		<th><?php echo $paginator->sort(__('Approved', true), 'approved'); ?></th>
		<th><?php echo $paginator->sort(__('Approve/Disapprove', true), 'approve_disaprove'); ?></th>
		
	</tr>
	
		<?php foreach($data as $comment): ?>
		
		<tr>
			<td><?php echo $comment['Comment']['id']; ?> </td>
			<td><?php echo $html->link($comment['Comment']['username'],array('controller' => 'users', 'action' => 'account', $comment['Comment']['username'])); ?></td>
			<td><?php echo $html->link($comment['Comment']['chain_id'],array('controller' => 'chains', 'action' => 'view', $comment['Comment']['chain_id'])); ?></td>
			<td><?php echo $html->link($comment['Comment']['item_id'],array('controller' => 'items', 'action' => 'view', $comment['Comment']['item_id'])); ?></td>
			<td><?php echo $comment['Comment']['created']; ?> </td>
			<td><?php echo $comment['Comment']['text']; ?> </td>
			<td><?php echo $comment['Comment']['denounced']; ?> </td>
			<td><?php echo $comment['Comment']['approved']; ?> </td>
			<td>
			<?php echo $form->create('Comment', array('action' => 'disapprove/'.$comment['Comment']['id']));?>
			<?php echo $form->end('desaprobar comentario');?>
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

