<!-- Archivo: /app/views/chains/index.ctp -->

<?php
	echo $this->Html->div('clearfix sidebar-none', null, array('id'=>'layout'));
		echo $this->Html->div('grid4', null, array('id'=>'content'));

?>
		<?php

			echo $this->element('section-chains', array('chains'=>$data, 'heading'=>__('Last Chains', true), 'max'=>0, 'action'=>'index'));
		?>
		
	</div>
</div>









