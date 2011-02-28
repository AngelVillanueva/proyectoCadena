<!-- Archivo: /app/views/chains/view.ctp -->

<br/>
<br/>
<?php echo $html->link('INICIO',array('controller' => 'chains', 'action' => 'index')); ?>
<br/>
<br/>

<h2><?php __('Chain:') ?></h2>

<table>


	
	<tr> 
		<th><?php __('Chain ID')?></th> 
		<th><?php __('Name')?></th>        
		<th><?php __('Author')?></th>   
		<th><?php __('Items')?></th>
		<th><?php __('Players')?></th>
		<th><?php __('Items')?></th>
		<th><?php __('Votes')?></th>
		<th><?php __('Meta')?></th>   
		     
		  
	</tr>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?></td>
		<td><?php echo $chain['Chain']['name']; ?></td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['user_id'])); ?></td>
		<td>
		<?php foreach($items as $item): ?>
		<?php echo $html->link($item['Item']['id'],array('controller' => 'items', 'action' => 'view',$item['Item']['id'] ));?>
		<br />
		<?php endforeach; ?>
		</td>
		<td>
		<?php foreach($items as $item): ?>
		<?php echo $html->link($item['Item']['username'],array('controller' => 'users', 'action' => 'account',$item['Item']['username'] ));?>
		<br />
		<?php endforeach; ?>
		</td>
		<td>
		<?php foreach($items as $item): ?>
		<img src="<?php echo $this->webroot;?>attachments/items/avatar/<?php echo $item['Item']['item_file_path']; ?>"
		<br />
		<?php endforeach; ?>
		</td>
		<td><?php echo $chain['Chain']['n_votes']; ?></td>
		<td><?php echo $chain['Objetive']['miles']; ?></td>
		</td>
	</tr>

</table>


<?php 

if($n_items == 0)
{
echo 'Cadena vacía... <br/>';
}
if($check_invitation > 0)
{
echo $html->link('NUEVO ITEM',array('controller' => 'items', 'action' => 'select_type', $id)); 
}
?>

<br/>
<?php 
echo $form->create('Vote', array('controller' => 'votes', 'action' => 'add/'.$id.'/c'));
echo $form->end('Votar'); 
?>

<?php
echo $form->create('Chain', array('controller' => 'chains', 'action' => 'denounce/'.$id));
echo $form->end('Denunciar cadena'); 
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
echo $form->create('Comment', array('controller' => 'comments', 'action' => 'denounce/'.$comment['Comment']['id'].'/'.$chain['Chain']['id'].'/c'));
echo $form->end('Denunciar comentario'); 
?>
</td>

</tr>

<?php endforeach; ?>

</table>



<br/>
<br/>
<?php
echo $form->create('Comment', array('controller' => 'comments', 'action' => 'add/'.$id.'/c'));
echo $form->hidden('id');
echo $form->textarea('text');
echo $form->end('Comentar'); 
?>


