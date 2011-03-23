<!-- Archivo: /app/views/items/last.ctp -->


<h2><br />Items (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>

		
	</tr>
	
		<?php foreach($data as $item): ?>
		
		<tr>
			<td><?php echo $item['Item']['id']; ?> </td>
			<td><?php echo $html->link($item['Item']['name'],array('controller' => 'items', 'action' => 'view', $item['Item']['name'])); ?></td>
			<td><?php echo $item['Item']['created']; ?> </td>
			
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
