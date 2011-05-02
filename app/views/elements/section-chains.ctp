<?php
	echo $this->Html->tag('section', null, array('class'=>'category-section clearfix'));
		echo $this->Html->tag('h1',
		$this->Html->link($heading, array('controller'=>'chains', 'action'=>$action)),
		array('class'=>'page-title'),
		array('escape'=>'false'));
?>
		<?php
			$orden = 0;
			foreach($chains as $chain) {
				
				$lastitemimage = $this->requestAction('chains/getImage/'.$chain['Chain']['id']);
				if($lastitemimage) { $urllastitemimage = $this->webroot.'../attachments/items/avatar/'.$lastitemimage;} else { $urllastitemimage = 'default-chain-image.png'; }
				if(!$chain['Chain']['chain_file_path']) {$urlchainimage = 'default-chain-image.png'; } else { $urlchainimage = $this->webroot.'../attachments/chains/avatar/'.$chain['Chain']['chain_file_path']; }
				$orden = $orden + 1;
				if($orden == 1 || $orden % 5 == 0) { $divclases = 'post nomargin'; } else { $divclases = 'post';}
				if($orden > 4) { break; }

				echo $this->Html->div($divclases, null);
					echo $this->Html->div('post-image', null);
						echo $this->Html->link(
							$this->Html->image($urlchainimage, array('alt'=>$chain['Chain']['name'], 'title'=>$chain['Chain']['name'])).
							$this->Html->image($urllastitemimage, array('alt'=>$chain['Chain']['name'], 'title'=>$chain['Chain']['name'], 'class'=>'mini')),
							array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id']),
							array('escape'=>false)
						);
						echo $this->Html->para('post-date', 'Items: '.$chain['Chain']['n_items']);
					echo '</div>';
					echo $this->Html->div('post-content', null);
						echo $this->Html->tag('h2', null, array('class'=>'post-title'));
							echo $this->Html->link(
								$this->Text->truncate($chain['Chain']['name'], 30, array('ending'=>'...', 'exact'=>'true')),
								array('controller' => 'chains', 'action' => 'view', $chain['Chain']['id']));
						echo '</h2>';
						echo $this->Html->para('', $chain['Chain']['description']);
						echo $this->Html->para('post-meta', null);
							echo $this->Html->tag('span', '<em>By </em>'.$chain['Chain']['username'], array('class'=>'post-author'), array('escape'=>'false'));
							echo $this->Html->tag(
								'span',
								'<em>Comments: </em>'.$this->Html->link($chain['Chain']['n_comments'], array('controller'=>'chains', 'action'=>'view', $chain['Chain']['id'])),
									array('class'=>'post-category'), array('escape'=>'false')
								);
						echo '</p>';
					echo '</div>'; 
				echo '</div>';
			}
		?>
	</section>