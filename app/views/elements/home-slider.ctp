<?php
	echo $this->Html->div('', 
		$this->Html->tag('ul', 
			$this->Html->tag('li',
				$this->Html->div('details',
					$this->Html->tag('h3', 'Título de la diapo').
					$this->Html->para('', 'Aquí el subtítulo de la diapo'),
				array('escape'=>false)).
				$this->Html->link(
					$this->Html->image('slider/slider-1.jpg',array('width'=>968, 'height'=>420)),
				'#', array('escape'=>false)),
			array('escape'=>false)).
			$this->Html->tag('li',
				$this->Html->div('details',
					$this->Html->tag('h3', 'Título de la diapo 2').
					$this->Html->para('', 'Aquí el subtítulo de la diapo 2'),
				array('escape'=>false)).
				$this->Html->link(
					$this->Html->image('slider/slider-2.jpg',array('width'=>968, 'height'=>420)),
				'#', array('escape'=>false)),
			array('escape'=>false)).
			$this->Html->tag('li',
				$this->Html->div('details',
					$this->Html->tag('h3', 'Título de la diapo 3').
					$this->Html->para('', 'Aquí el subtítulo de la diapo 3'),
				array('escape'=>false)).
				$this->Html->link(
					$this->Html->image('slider/slider-3.jpg',array('width'=>968, 'height'=>420)),
				'#', array('escape'=>false)),
			array('escape'=>false)).
			$this->Html->tag('li',
				$this->Html->div('details',
					$this->Html->tag('h3', 'Título de la diapo 4').
					$this->Html->para('', 'Aquí el subtítulo de la diapo 4'),
				array('escape'=>false)).
				$this->Html->link(
					$this->Html->image('slider/slider-4.jpg',array('width'=>968, 'height'=>420)),
				'#', array('escape'=>false)),
			array('escape'=>false)),
		array('class'=>'slidesh'), array('escape'=>false)),
	array('id'=>'slider-home'),
	array('escape'=>false)
	);
?>