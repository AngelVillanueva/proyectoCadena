<!-- Archivo: /app/views/users/last.ctp -->



<h2><br />Usuarios (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('User', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Created', true), 'created'); ?></th>

		
	</tr>
	
		<?php foreach($data as $user): ?>
		
		<tr>
			<td><?php echo $user['User']['id']; ?> </td>
			<td><?php echo $html->link($user['User']['username'],array('controller' => 'users', 'action' => 'account', $user['User']['username'])); ?></td>
			<td><?php echo $user['User']['created']; ?> </td>
			
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
<h2>Ultima cadena</h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Items', true), 'n_items'); ?></th>
			
	</tr>
	

	
	<tr>
		<td><?php echo $last_chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($last_chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $last_chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($last_chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $last_chain['Chain']['id'])); ?></td>
		<td><?php echo $last_chain['Chain']['n_items']; ?> </td>
	
		
	</tr>
	
	

</table>


<table>
<br/>
<br/>
<h2>Ultimo item</h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
	

			
	</tr>
	

	
	<tr>
		<td><?php echo $last_item['Item']['id']; ?> </td>
		<td><?php echo $html->link($last_item['Item']['username'],array('controller' => 'users', 'action' => 'account', $last_item['Item']['username'])); ?></td>
		
		
	
		
	</tr>
	
	

</table>

<table>
<br/>
<br/>
<h2>Ultimo Favorito usuario</h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Fav ID', true), 'fav_id'); ?></th>
	

			
	</tr>
	

	
	<tr>
		<td><?php echo $last_fav_user['Favorite']['id']; ?> </td>
		<td><?php echo $last_fav_user['Favorite']['fav_id']; ?> </td>
		
		
	
		
	</tr>
	
	

</table>

<table>
<br/>
<br/>
<h2>Ultimo Favorito cadena</h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Fav ID', true), 'fav_id'); ?></th>
	

			
	</tr>
	

	
	<tr>
		<td><?php echo $last_fav_chain['Favorite']['id']; ?> </td>
		<td><?php echo $last_fav_user['Favorite']['fav_id']; ?> </td>
		
		
	
		
	</tr>
	
	

</table>



<?php }?>


	
	
	




