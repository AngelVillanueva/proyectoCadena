<!-- Archivo: /app/views/chains/view.ctp -->

<?php $this->Html->script('/js/libs/jcarousel', array('inline'=>false)); ?>

<h1 id="welcome"><?php echo $chain['Chain']['name']; ?></h1>

<?php echo $this->Html->div('slider', null, array('id'=>'header-slider')); ?>

<?php

	echo $this->Html->tag('ul', null, array('class'=>'slides clearfix'));
		foreach($items as $item) {
			$urlimage = '/attachments/timthumb.php?src=items/avatar/'.$item['Item']['item_file_path'].'&w=40&h=40&f=5,0,255,0';
			echo $this->Html->tag('li',
				$this->Html->div('slide-feature-image',
					$this->Html->link(
						$this->Html->image($urlimage, array('class'=>'feature-img', 'alt'=>$item['Item']['name'], 'title'=>$item['Item']['name'])),
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