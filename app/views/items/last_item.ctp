<!-- Archivo: /app/views/items/last_item.ctp -->




<br/>
<br/>
<?php echo $html->link('INICIO',array('controller' => 'chains', 'action' => 'index')); ?>
<br/>

<br/>
<h2><br />Ultimo Item</h2>

<table>
		
		<tr>
			<td><?php echo $last_item['Item']['id']; ?> </td>
			<td><?php echo $html->link($last_item['Item']['name'],array('controller' => 'items', 'action' => 'view', $last_item['Item']['id'])); ?></td>
			<td><?php echo $html->link($last_item['Item']['username'],array('controller' => 'users', 'action' => 'account', $last_item['Item']['username'])); ?></td>
			<td><?php echo $last_item['Item']['created']; ?> </td>
			
			
			
		</tr>
		
		

</table>

