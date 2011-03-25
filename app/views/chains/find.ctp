<!-- Archivo: /app/views/chains/find.ctp -->



<?php
	echo $form->create('User', array(
		'url' => array_merge(array('action' => 'find'), $this->params['pass'])
		));
	echo $form->input('search', array('div' => false));
	echo $form->submit(__('Search', true), array('div' => false));
	echo $form->end();
?>

<?php
	echo $form->create('Chain', array(
		'url' => array_merge(array('action' => 'find'), $this->params['pass'])
		));
	echo $form->input('search', array('div' => false));
	echo $form->submit(__('Search', true), array('div' => false));
	echo $form->end();
?>


<br/>
<h2><br />Cadenas</h2>

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