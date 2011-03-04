<!-- Archivo: /app/views/chains/last_chain.ctp -->




<br/>
<br/>
<?php echo $html->link('INICIO',array('controller' => 'chains', 'action' => 'index')); ?>
<br/>

<br/>
<h2><br />Ultima cadena</h2>

<table>
		
		<tr>
			<td><?php echo $last_chain['Chain']['id']; ?> </td>
			<td><?php echo $html->link($last_chain['Chain']['name'],array('controller' => 'chains', 'action' => 'view', $last_chain['Chain']['id'])); ?></td>
			<td><?php echo $html->link($last_chain['Chain']['username'],array('controller' => 'users', 'action' => 'account', $last_chain['Chain']['username'])); ?></td>
			<td><?php echo $last_chain['Chain']['created']; ?> </td>
			
			
			
		</tr>
		
		

</table>









	
	
	




