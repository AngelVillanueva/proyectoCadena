<!-- Archivo: /app/views/chains/index.ctp -->

<?php $this->Html->script('/js/libs/cycle', array('inline'=>false)); ?>

<?php
	$data = $this->requestAction('chains/index');
	$visited_chains = $this->requestAction('chains/visitedChains');
	$item_chains = $this->requestAction('chains/itemChains');
?>

<?php
	echo $this->Html->div('clearfix sidebar-none', null, array('id'=>'layout'));
		echo $this->Html->div('grid4', null, array('id'=>'content'));

?>
		<?php
			echo $this->element('home-slider'); 
		?>

		<?php
			$welcome = __("Hello howdy, go create the world longest chain !!", true);
			echo $this->Html->tag('h1', $welcome, array('id'=>'welcome'));
		?>

		<?php
			$subheading = __("Descubre aquí las últimas cadenas añadidas y decide a cuál quieres unirte. ¡Hay para todos los gustos!", true);
			echo $this->element('section-chains-home', array('chains'=>$data, 'heading'=>__('The Last Chains', true), 'subheading'=>$subheading, 'max'=>'3', 'action'=>'index'));
		?>
		
		<?php
			$subheading = __("Descubre aquí las cadenas más visitadas y decide a cuál quieres unirte. ¡Hay para todos los gustos!", true);
			echo $this->element('section-chains-home', array('chains'=>$visited_chains, 'heading'=>__('The Popular Chains', true), 'subheading'=>$subheading, 'max'=>'3', 'action'=>'visitedChains'));
		?>
		
		<?php
			$subheading = __("Descubre aquí las cadenas más largas y decide a cuál quieres unirte. ¡Hay para todos los gustos!", true);
			echo $this->element('section-chains-home', array('chains'=>$item_chains, 'heading'=>__('The Longer Chains', true), 'subheading'=>$subheading, 'max'=>'3', 'action'=>'itemChains'));
		?>
		
	</div>
</div>









