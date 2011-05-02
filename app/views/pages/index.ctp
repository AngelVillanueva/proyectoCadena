<!-- Archivo: /app/views/chains/index.ctp -->

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
			echo $this->element('section-chains', array('chains'=>$data, 'heading'=>__('Last Chains', true), 'action'=>'index'));
		?>
		
		<?php
			echo $this->element('section-chains', array('chains'=>$visited_chains, 'heading'=>__('Popular Chains', true), 'action'=>'visitedChains'));
		?>
		
		<?php
			echo $this->element('section-chains', array('chains'=>$item_chains, 'heading'=>__('Longer Chains', true), 'action'=>'itemChains'));
		?>
		
	</div>
</div>









