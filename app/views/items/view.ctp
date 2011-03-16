<!-- Archivo: /app/views/items/view.ctp -->

<?php
echo $form->create('', array('action'=>'search'));
echo $form->input('Buscar', array('type'=>'text'));
echo $form->end('Buscar');
?>



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
		<th><?php __('Position')?></th>  
		<th><?php __('Imagen')?></th>
		<th><?php __('Description')?></th>
		<th><?php __('Aprobado')?></th>
		<th><?php __('Denunciar')?></th>
		<th><?php __('Eliminar')?></th>
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
		<td><?php echo $item['Item']['position']; ?></td>
		<td><img src="<?php echo $this->webroot;?>attachments/items/avatar/<?php echo $item['Item']['item_file_path']; ?>"</td>
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
		echo $form->create('Item', array('controller' => 'items', 'action' => 'disapprove/'.$item['Item']['id']));
		echo $form->end('Eliminar item'); 
		?>
		</td>
		<td>
		<?php 
		echo $form->create('Item', array('controller' => 'items', 'action' => 'approve/'.$item['Item']['id']));
		echo $form->end('Aprobar item'); 
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
echo $form->textarea('text');
echo $form->end('Comentar'); 
?>



