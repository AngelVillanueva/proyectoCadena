<!-- Archivo: /app/views/chains/last.ctp -->



<h2><br />Cadenas (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>

		
	</tr>
	
		<?php foreach($data as $chain): ?>
		
		<tr>
			<td><?php echo $chain['Chain']['id']; ?> </td>
			<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
			<td><?php echo $chain['Chain']['created']; ?> </td>
			
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



<?php if($check==0){?>

<table>
<br/>
<br/>
<h2>Millas</h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Millas', true), 'miles'); ?></th>
		<th><?php echo $paginator->sort(__('Ultimo item', true), 'last_item'); ?></th>
		<th><?php echo $paginator->sort(__('Ultimo participante', true), 'last_player'); ?></th>
			
	</tr>
	

	
	<tr>
		<td><?php echo $chain_id; ?> </td>
		<td><?php echo $miles; ?> </td>
		<td><?php echo $last_item['Item']['id'];?> </td>
		<td><?php echo $last_item['Item']['username'];?> </td>
		
	
		
	</tr>
	
	

</table>


<?php }?>
	
	




