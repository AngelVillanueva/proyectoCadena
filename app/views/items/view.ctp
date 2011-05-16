<!-- Archivo: /app/views/items/view.ctp -->





<h2><?php __('Item:') ?></h2>

<table>

	<tr>       
		<th><?php __('Item ID')?></th>
		<th><?php __('Name')?></th>        
		<th><?php __('Author')?></th>
		<th><?php __('Pertenece a cadena:')?></th>  
		<th><?php __('Description')?></th>  
		<th><?php __('Votes')?></th>   
		<th><?php __('Hits')?></th>   
		<th><?php __('Position/Total')?></th>  
		<th><?php __('Imagen')?></th>
		<th><?php __('Description')?></th>
		<th><?php __('Aprobado')?></th>
		<th><?php __('Denunciar')?></th>
		<th><?php __('Aprobar')?></th>
	
		 
		  
	</tr>
	
	<tr>
		<td><?php echo $item['Item']['id']; ?></td>
		<td><?php echo $item['Item']['name']; ?></td>
		<td><?php echo $html->link($item['Item']['username'],array('controller' => 'users', 'action' => 'account', $item['Item']['username'])); ?></td>
		<td><?php echo $html->link($item['Item']['chain_id'],array('controller' => 'chains', 'action' => 'view', $item['Item']['chain_id'])); ?></td>
		<td><?php echo $item['Item']['description']; ?></td>
		<td><?php echo $item['Item']['n_votes']; ?></td>
		<td><?php echo $item['Item']['n_hits']; ?></td>
		<td><?php echo $item['Item']['position']; ?>/<?php echo $n_items; ?></td>
		
		<td>
		<?php 
		switch($item['Item']['type'])
		{
			case 1:
			break;
			
			case 2:
			?><img src="<?php echo $this->webroot;?>attachments/items/avatar/<?php echo $item['Item']['item_file_path']; ?>"<?php
			break;
			
			case 3:
				switch($item['Item']['host']){
				
				case 'www.youtube.com':
				case 'youtube.com':
				echo $youtube->video($item['Item']['vid']);
				break;
				
				case 'www.vimeo.com':
				case 'vimeo.com':
				echo $vimeo->getEmbedCode('http://www.vimeo.com'.$item['Item']['vid'], array());
				break;
				
				}
					
			break;
		
		
		
		}
		?>
		</td>
		<td><?php echo $item['Item']['description']; ?></td>
		<td><?php echo $item['Item']['approved']; ?></td>
		<td>
		<?php 
		echo $form->create('Item', array('controller' => 'items', 'action' => 'denounce/'.$item['Item']['id']));
		echo $form->end('Denunciar item'); 
		?>
		</td>
		<td>
		<?php 
		echo $form->create('Item', array('controller' => 'items', 'action' => 'delete/'.$item['Item']['id']));
		echo $form->end('Eliminar item'); 
		?>
		</td>
		
	</tr>

</table>


<?php
echo $html->link('VOTAR ITEM',array('controller' => 'votes', 'action' => 'add', $id, 'i')); 
?>


<h2>Comentarios:</h2>

<table>

<tr> 
	<th><?php __('Comentario')?></th>
	<th><?php __('Author')?></th> 
	<th><?php __('Text')?></th>    
	<th><?php __('Denounce')?></th>            
	  
</tr>

<?php foreach($comments as $key => $comment): ?>

<tr>

<td><?php echo ($key+1).'/'.$n_comments ?></td>
<td><?php echo $comment['Comment']['username']; ?></td>
<td><?php echo $comment['Comment']['text']; ?></td>
<td>
<?php 
echo $form->create('Comment', array('controller' => 'comments', 'action' => 'denounce/'.$comment['Comment']['id'].'/'.$item['Item']['id'].'/i'));
echo $form->end('Denunciar comentario'); 
?>
</td>
</tr>

<?php endforeach; ?>

</table>



<br/>
<br/>
<?php
echo $form->create('Comment', array('controller' => 'comments', 'action' => 'add/'.$id.'/i'));
echo $form->hidden('id');
echo $form->input('text', array('type' => 'textarea'));
echo $form->end('Comentar'); 
?>

<?php
echo '<br/>';
echo $html->link('Siguiente Item >>',array('controller' => 'items', 'action' => 'view', $next_item['Item']['id']));
echo '<br/>';
echo $html->link('<< Item Anterior',array('controller' => 'items', 'action' => 'view', $prev_item['Item']['id']));
echo '<br/>';
?>
