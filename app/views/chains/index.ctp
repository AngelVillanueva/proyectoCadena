<!-- Archivo: /app/views/chains/index.ctp -->


<?php echo $html->link('Tienes '.$pending.' invitacion(es) pendientes!',array('controller' => 'invitations', 'action' => 'view')); ?>
<br/>
<br/>
<?php echo $html->link('Tienes '.$request_invitations.' solicitudes(es) de participacion pendientes!',array('controller' => 'invitations', 'action' => 'view_request')); ?>


<?php
	echo $this->Html->div('clearfix sidebar-none', null, array('id'=>'layout'));
		echo $this->Html->div('grid4', null, array('id'=>'content'));

?>
		<?php
			echo $this->Html->div('category-section clearfix', null);
		?>
			<?php
				foreach($data as $chain) {
					$chainimage = $this->requestAction('chains/get_image/'.$chain['Chain']['id']);
					if($chainimage) { $urlchainimage = $this->webroot.'../attachments/items/avatar/'.$chainimage;} else { $urlchainimage = 'default-chain-image.png'; }
					echo $this->Html->div('post', null);
						echo $this->Html->div('post-image', null);
							echo $this->Html->link(
								$this->Html->image($urlchainimage, array('alt'=>$chain['Chain']['name'], 'title'=>$chain['Chain']['name'])),
								array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id']),
								array('escape'=>false)
							);
							echo $this->Html->para('post-date', $chain['Chain']['created']);
						echo '</div>';
						echo $this->Html->div('post-content', null);
							echo $this->Html->tag('h2', null, array('class'=>'post-title'));
								echo $this->Html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id']));
								echo $this->Html->tag('sup', $chain['Chain']['n_comments'], array('class'=>'post-comment'));
							echo '</h2>';
							echo $this->Html->para('', $chain['Chain']['description']);
							echo $this->Html->para('post-meta', null);
								echo $this->Html->tag('span', '<em>By </em>'.$chain['Chain']['username'], array('class'=>'post-author'), array('escape'=>'false'));
								echo $this->Html->tag('span', '<em>Items: </em>'.$chain['Chain']['n_items'], array('class'=>'post-category'), array('escape'=>'false'));
							echo '</p>';
						echo '</div>'; 
					echo '</div>';
				}
			?>
		</div>
	</div>
</div>



<h2><br />Cadenas (muestra 5)</h2>

<table>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Items', true), 'n_comments'); ?></th>
		<th><?php echo $paginator->sort(__('Millas', true), 'miles'); ?></th>
		<th><?php echo $paginator->sort(__('Next Meta', true), 'next_objetive'); ?></th>
		<th><?php echo $paginator->sort(__('Private', true), 'private'); ?></th>
		<th><?php echo $paginator->sort(__('Restricted', true), 'restricted'); ?></th>
		
		
	</tr>
	
		<?php foreach($data as $chain): ?>
		
		<tr>
			<td><?php echo $chain['Chain']['id']; ?> </td>
			<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
			<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
			<td><?php echo $chain['Chain']['n_hits']; ?> </td>
			<td><?php echo $chain['Chain']['n_votes']; ?> </td>
			<td><?php echo $chain['Chain']['n_comments']; ?> </td>
			<td><?php echo $chain['Chain']['n_items']; ?> </td>
			<td><?php echo $chain['Chain']['miles']; ?> </td>
			<td><?php echo $chain['Chain']['next_objetive']; ?> </td>
			<td><?php echo $chain['Chain']['private']; ?> </td>
			<td><?php echo $chain['Chain']['restricted']; ?> </td>
			
			
			
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
<br/>
<br/>
<h2><?php echo $html->link('MAS VISITADAS',array('controller' => 'chains', 'action' => 'visited_chains')); ?></h2>

	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Hits', true), 'n_hits'); ?></th>
		
	</tr>

	<?php foreach($visited_chains as $chain): ?>

	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_hits']; ?> </td>

	
	</tr>

	<?php endforeach; ?>
	
</table>


<table>
<br/>
<br/>
<h2><?php echo $html->link('MAS COMENTADAS',array('controller' => 'chains', 'action' => 'comment_chains')); ?></h2>

	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Comments', true), 'n_hits'); ?></th>
		
	</tr>

	<?php foreach($comment_chains as $chain): ?>

	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_comments']; ?> </td>

	
	</tr>

	<?php endforeach; ?>
	
</table>

	

	
<table>
<br/>
<br/>
<h2><?php echo $html->link('MAS VOTADAS',array('controller' => 'chains', 'action' => 'voted_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Votes', true), 'n_votes'); ?></th>
			
	</tr>
	
	<?php foreach($voted_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_votes']; ?> </td>
	
		
	</tr>
	
	<?php endforeach; ?>

</table>


<table>
<br/>
<br/>
<h2><?php echo $html->link('Con mas Items!',array('controller' => 'chains', 'action' => 'item_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		<th><?php echo $paginator->sort(__('Items', true), 'n_items'); ?></th>
			
	</tr>
	
	<?php foreach($item_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		<td><?php echo $chain['Chain']['n_items']; ?> </td>
	
		
	</tr>
	
	<?php endforeach; ?>

</table>
	

<table>
<br/>
<br/>
<h2><?php echo $html->link('Tus cadenas!',array('controller' => 'chains', 'action' => 'user_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($user_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>

<table>

<h2><?php echo $html->link('Cadenas en las que has participado (añadido items)',array('controller' => 'chains', 'action' => 'join_chains')); ?></h2>
	<tr>
		<th><?php echo $paginator->sort(__('Id', true), 'id'); ?></th>
		<th><?php echo $paginator->sort(__('Author', true), 'username'); ?></th>
		<th><?php echo $paginator->sort(__('Name', true), 'name'); ?></th>
		
			
	</tr>
	
	<?php foreach($join_chains as $chain): ?>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?> </td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><?php echo $html->link($chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id'])); ?></td>
		
	
		
	</tr>
	
	<?php endforeach; ?>

</table>









