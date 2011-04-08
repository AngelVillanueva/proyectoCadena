<!-- Archivo: /app/views/invitations/view.ctp -->

<h2><?php __('Invitationes pendientes:') ?></h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Cadena', true), 'chain_id'); ?></th>
		<th><?php echo $paginator->sort(__('Nombre Cadena:', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Te invita:', true), 'username'); ?></th>
		
		
	</tr>
	
		<?php foreach($data as $invitation): ?>
		
		<tr>
			<td><?php echo $invitation['Invitation']['id']; ?> </td>
			<td><?php echo $html->link($invitation['Invitation']['chain_id'],array('controller' => 'chains', 'action' => 'view', $invitation['Invitation']['chain_id'])); ?></td>
			<td><?php echo $html->link($invitation['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $invitation['Invitation']['chain_id'])); ?></td>
			<td><?php echo $invitation['Invitation']['username']; ?> </td>
			
		
			
			
		</tr>
		
		<?php endforeach; ?>

</table>


