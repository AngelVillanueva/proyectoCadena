<!-- Archivo: /app/views/invitations/view_request.ctp -->

<h2><?php __('Invitationes pendientes:') ?></h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Cadena', true), 'chain_id'); ?></th>
		<th><?php echo $paginator->sort(__('Solicitante', true), 'guest_name'); ?></th>
		<th><?php echo $paginator->sort(__('Aceptar', true), 'active'); ?></th>
	
		
	</tr>
	
		<?php foreach($data as $invitation): ?>
		
		<tr>
			<td><?php echo $invitation['Invitation']['id']; ?> </td>
			<td><?php echo $html->link($invitation['Invitation']['chain_id'],array('controller' => 'chains', 'action' => 'view', $invitation['Invitation']['chain_id'])); ?></td>
			<td><?php echo $invitation['Invitation']['guest_name']; ?> </td>
			<td>
			<?php 
			echo $form->create('Invitation', array('controller' => 'invitations', 'action' => 'active/'.$invitation['Invitation']['id']));
			echo $form->end('Aceptar solicitud'); 
			?>
			</td>
			
			
		</tr>
		
		<?php endforeach; ?>

</table>


