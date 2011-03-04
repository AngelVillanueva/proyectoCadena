<!-- Archivo: /app/views/users/last_user.ctp -->




<br/>
<br/>
<?php echo $html->link('INICIO',array('controller' => 'chains', 'action' => 'index')); ?>
<br/>

<br/>
<h2><br />Ultimo usuario</h2>

<table>
		
		<tr>
			<td><?php echo $last_user['User']['id']; ?> </td>
			<td><?php echo $html->link($last_user['User']['username'],array('controller' => 'users', 'action' => 'account', $last_user['User']['username'])); ?></td>
			<td><?php echo $last_user['User']['created']; ?> </td>
			
			
			
		</tr>
		
		

</table>







	
	
	




