<!-- Archivo: /app/views/chains/view.ctp -->

<?php $this->Html->script('/js/libs/jcarousel', array('inline'=>false)); ?>

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

<?php

	echo $this->Html->div('slider-nav',
		$this->Html->link('<<', '#', array('class'=>'prev-slide')).$this->Html->link('>>', '#', array('class'=>'next-slide')),
		array('escape'=>false));
?>

</div>

<?php

if(($check_invitation > 0 || $check_own == $username) && ($check_joins == 0 || $check_repeat == 1))
{
echo $form->create('Item', array('controller' => 'items', 'action' => 'selectType/'.$id));
echo $form->end('Nuevo Item'); 
}

if($check_own == $username || $check_joins > 0)
{
echo $form->create('Invitation', array('controller' => 'invitations', 'action' => 'add/'.$id));
echo $form->end('Enviar invitación'); 
}

?>