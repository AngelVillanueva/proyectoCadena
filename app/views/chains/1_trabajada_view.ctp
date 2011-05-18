<!-- Archivo: /app/views/chains/view.ctp -->

<?php $this->Html->script('/js/libs/jcarousel', array('inline'=>false)); ?>

<?php
	$goals = '';
	foreach($objetives as $objetive) {
		if($goals <> '') {
			$goals .= ' - '.$objetive['Objetive']['miles'];
		} else {
			$goals = $objetive['Objetive']['miles'];
		}
	}
?>
<div class="list-large-image">
<?php

	echo $this->Html->tag('h1', $chain['Chain']['name']);
	
	echo $this->Html->div('post clearfix',
		$this->Html->div('post-image',
			$this->Html->image('/attachments/img.php?src=chains/avatar/'.$chain['Chain']['chain_file_path'].'&w=680&h=390', array('alt'=>$chain['Chain']['description'], 'title'=>$chain['Chain']['name'])),
		array('escape'=>false)).
		$this->Html->div('post-content',
			$this->Html->para('post-date', date('M j, Y', strtotime($chain['Chain']['created']))).
			$this->Html->tag('h2', $chain['Chain']['name'], array('class'=>'post-title')).
			$this->Html->para('post-meta',
				$this->Html->tag('span', __('Votes: ', true).$chain['Chain']['n_votes'], array('class'=>'post-comment')).
				$this->Html->tag('span', __('Miles: ', true).$chain['Chain']['miles'], array('class'=>'post-author')).
				$this->Html->tag('span', __('Goals: ', true).$goals, array('class'=>'post-category')).
				$this->Html->tag('span', __('Next Goal: ', true).$chain['Chain']['next_objetive'], array('class'=>'post-category'))).
			$this->Html->para('', $chain['Chain']['description']).
			$this->Html->image('icons/medal.png', array('class'=>'badge')).$this->Html->image('icons/heart.png', array('class'=>'badge')).$this->Html->image('icons/add.png', array('class'=>'badge')).
			$this->Html->image('icons/comment_add.png', array('class'=>'badge')).$this->Html->image('icons/favourite_add.png', array('class'=>'badge')).$this->Html->image('icons/bullet_add.png', array('class'=>'badge')).
			$this->Html->image('icons/s_Facebook.png', array('class'=>'badge')).$this->Html->image('icons/s_Twitter.png', array('class'=>'badge')).$this->Html->image('icons/s_RSS.png', array('class'=>'badge')),
		array('escape'=>false)),
	array('escape'=>false));
	
?>
</div>

<?php

	if(($check_invitation > 0 || $check_own == $username) && ($check_joins == 0 || $check_repeat == 1)) {
		$addForm = $this->Form->create('Item', array('controller' => 'items', 'action' => 'selectType/'.$id)).$this->Form->end(__('New Item', true)); 
	} else $addForm = '';
	
	if($check_fav == 0) {
		$favoriteForm = $this->Form->create('Favorite', array('controller' => 'favorites', 'action' => 'add/'.$id.'/1')).$this->Form->end(__('Add to favorites', true)); 
	} else $favoriteForm = '';
	
	if($check_own == $username) {
		$deleteForm = $this->Form->create('Chain', array('controller' => 'chains', 'action' => 'approve/'.$id)).$this->Form->end(__('Delete chain', true)); 
	} else $deleteForm = '';
	
	if($check_own == $username || $check_joins > 0) {
		$inviteForm = $this->Form->create('Invitation', array('controller' => 'invitations', 'action' => 'add/'.$id)).$this->Form->end(__('Send invitation', true)); 
	} else $inviteForm = '';
	
	if($restricted == 1 && $check_own != $username && $check_invitation == 0 && $check_joins == 0 && $check_request == 0) {
		$requestForm = $this->Form->create('Invitation', array('controller' => 'invitations', 'action' => 'request/'.$id)).$this->Form->end(__('Send a request to join', true)); 
	} else $requestForm = '';

	echo $this->Html->div('actions-menu',
		$addForm.
		$this->Form->create('Vote', array('controller' => 'votes', 'action' => 'add/'.$id.'/c')).$this->Form->end(__('Vote', true)).
		$this->Form->create('Chain', array('controller' => 'chains', 'action' => 'denounce/'.$id)).$this->Form->end(__('Report abuse', true)).
		$favoriteForm.$deleteForm.$inviteForm.$requestForm,
	array('escape'=>false));

?>

<?php echo $this->Html->div('slider', null, array('id'=>'header-slider')); ?>

<?php

	echo $this->Html->tag('ul', null, array('class'=>'slides clearfix'));
		foreach($items as $item) {
			$urlimage = '/attachments/img.php?src=items/avatar/'.$item['Item']['item_file_path'].'&w=195&h=140';
			echo $this->Html->tag('li',
				$this->Html->div('slide-feature-image',
					$this->Html->link(
						$this->Html->image($urlimage, array('class'=>'feature-img', 'alt'=>$item['Item']['name'], 'title'=>$item['Item']['name'], 'width'=>'195', 'height'=>'140')),
						array('controller'=>'items', 'action'=>'view', $item['Item']['id']),
					array('escape'=>false)),
				array('escape'=>false)).
				$this->Html->div('slide-content-wrap',
					$this->Html->tag('h3',
						$this->Html->link($item['Item']['name'], array('controller'=>'items', 'action'=>'view', $item['Item']['id'])),
					array('escape'=>false)),
				array('escape'=>false)
				),
	array('escape'=>false));
		}							
	echo '</ul>';

?>

</div>


<!-- ORIGINAL CONTENT -->

<?php 

if($n_items == 0)
{
echo 'Cadena vacía... <br/>';
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