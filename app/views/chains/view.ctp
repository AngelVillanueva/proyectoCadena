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
		<th><?php __('Description')?></th>        
		<th><?php __('Author')?></th>   
		<th><?php __('Image')?></th> 
		<th><?php __('Items')?></th>
		<th><?php __('Players')?></th>
		<th><?php __('Items')?></th>
		<th><?php __('Position Item')?></th>
		<th><?php __('Votes')?></th>
		<th><?php __('Miles')?></th>
		<th><?php __('Metas')?></th>
		<th><?php __('Next Meta')?></th>   
		<th><?php __('Aprobada')?></th>   
		     
		  
	</tr>
	
	<tr>
		<td><?php echo $chain['Chain']['id']; ?></td>
		<td><?php echo $chain['Chain']['name']; ?></td>
		<td><?php echo $chain['Chain']['description']; ?></td>
		<td><?php echo $html->link($chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $chain['Chain']['username'])); ?></td>
		<td><img src="<?php echo $this->webroot;?>attachments/chains/avatar/<?php echo $chain['Chain']['chain_file_path']; ?>"</td>
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
		<?php switch($item['Item']['type'])
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
				echo $youtube->image($item['Item']['vid'], 'small'); 
				break;
				
				case 'www.vimeo.com':
				case 'vimeo.com':
				$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video'.$item['Item']['vid'].'.php'));
				?><img src="<?php echo $hash[0]['thumbnail_medium'];?>"<?php
				break;
			
				}
				
				break;
		
		}
		?>
		
		<br />
		<?php endforeach; ?>
		</td>
		<td>
		<?php foreach($items as $item): ?>
		<?php echo $item['Item']['position']; ?>
		<br />
		<?php endforeach; ?>
		</td>
		<td><?php echo $chain['Chain']['n_votes']; ?></td>
		<td><?php echo $chain['Chain']['miles']; ?></td>
		<td>
		<?php foreach($objetives as $objetive): ?>
		<?php echo $objetive['Objetive']['miles']; ?>
		<br />
		<?php endforeach; ?>
		</td>
		<td><?php echo $chain['Chain']['next_objetive']; ?></td>
		<td><?php echo $chain['Chain']['approved']; ?></td>
		
	</tr>

</table>


<?php 

if($n_items == 0)
{
echo 'Cadena vacía... <br/>';
}
if(($check_invitation > 0 || $check_own == $username) && ($check_joins == 0 || $check_repeat == 1))
{
echo $form->create('Item', array('controller' => 'items', 'action' => 'selectType/'.$id));
echo $form->end('Nuevo Item'); 
}
?>

<?php 
echo $form->create('Vote', array('controller' => 'votes', 'action' => 'add/'.$id.'/c'));
echo $form->end('Votar'); 
?>

<?php
echo $form->create('Chain', array('controller' => 'chains', 'action' => 'denounce/'.$id));
echo $form->end('Denunciar cadena'); 
?>


<?php
if($check_fav == 0)
{

echo $form->create('Favorite', array('controller' => 'favorites', 'action' => 'add/'.$id.'/1'));
echo $form->end('Añadir a favoritos'); 

}
?>

<?php
if($check_own == $username)
{

echo $form->create('Chain', array('controller' => 'chains', 'action' => 'approve/'.$id));
echo $form->end('Borrar cadena'); 

}
?>

<?php
if($check_own == $username || $check_joins > 0)
{
echo $form->create('Invitation', array('controller' => 'invitations', 'action' => 'add/'.$id));
echo $form->end('Enviar invitación'); 
}
?>

<?php
if($restricted == 1 && $check_own != $username && $check_invitation == 0 && $check_joins == 0 && $check_request == 0)
{
echo $form->create('Invitation', array('controller' => 'invitations', 'action' => 'request/'.$id));
echo $form->end('Solicitar unirse a la cadena'); 
}
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


