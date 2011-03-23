<!-- Archivo: /app/views/comments/last.ctp -->


<h2><br />Comments (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('User', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Chain', true), 'chain_id'); ?></th>
		<th><?php echo $paginator->sort(__('Item', true), 'item_id'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>
		<th><?php echo $paginator->sort(__('Text', true), 'text'); ?></th>
	
		
	</tr>
	
		<?php foreach($data as $comment): ?>
		
		<tr>
			<td><?php echo $comment['Comment']['id']; ?> </td>
			<td><?php echo $html->link($comment['Comment']['username'],array('controller' => 'users', 'action' => 'account', $comment['Comment']['username'])); ?></td>
			<td><?php echo $html->link($comment['Comment']['chain_id'],array('controller' => 'chains', 'action' => 'view', $comment['Comment']['chain_id'])); ?></td>
			<td><?php echo $html->link($comment['Comment']['item_id'],array('controller' => 'items', 'action' => 'view', $comment['Comment']['item_id'])); ?></td>
			<td><?php echo $comment['Comment']['created']; ?> </td>
			<td><?php echo $comment['Comment']['text']; ?> </td>
	
			
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

