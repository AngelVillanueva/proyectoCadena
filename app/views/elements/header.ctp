<!-- *** LOGO *** -->
<?php
	echo $this->Html->div('', null, array('id'=>'site-logo'));
?>
<?php
	echo $this->Html->link(
		$this->Html->image('logo-camelidus.png', array('alt'=>'Camelidus logo', 'title'=>'Camelidus')),
		array('controller' => 'chains', 'action' => 'index'),
		array('escape'=>false)
	);
?>
</div>

<?php
	echo $this->Html->div('', __('Trata de arrancarlo, Carlos...',true), array('id'=>'site-description'));
?>


<!-- ***  HEADER WIDGET *** -->
<?php
	echo $this->Html->div('header-widget', null);
		echo $this->Html->div('widget', null);
			echo $this->Html->tag('ul', null);
?>
				<?php 
					echo $this->Html->tag('li', null);
						echo $this->Html->link(
							$this->Html->image('facebook.png', array('alt'=>'Facebook', 'title'=>'Camelidus Facebook')),
							'http://www.facebook.com/camelidus',
							array('escape'=>false)
						);
					echo '</li>';
					echo $this->Html->tag('li', null);
						echo $this->Html->link(
							$this->Html->image('twitter.png', array('alt'=>'Twitter', 'title'=>'Camelidus Twitter')),
							'http://www.twitter.com/camelidus',
							array('escape'=>false)
						);
					echo $this->Html->tag('li', null);
						echo $this->Html->link(
							$this->Html->image('rss.png', array('alt'=>'RSS', 'title'=>'Camelidus RSS')),
							'#',
							array('escape'=>false)
						);
					echo '</li>';
				?>
		</ul>
	</div>
</div>

<!-- ***  MAIN NAV *** -->
<?php
	echo $this->Html->tag('ul', null, array('id'=>'main-nav', 'class'=>'clearfix'));
?>
	<?php if($username == 'admin')
		{
		echo $this->Html->tag('li', null);
			echo $this->Html->link(__('Admin Menu',true), '#', array('class'=>'admin'));
			echo $this->Html->tag('ul', null, array('class'=>'children'));
				echo $this->Html->tag('li', null);
					echo $this->Html->link('Administrar cadenas',array('controller' => 'chains', 'action' => 'admin'));
				echo '</li>';
				echo $this->Html->tag('li', null);
					echo $html->link('Administrar items',array('controller' => 'items', 'action' => 'admin'));
				echo '</li>';
				echo $this->Html->tag('li', null);
					echo $html->link('Administrar comentarios',array('controller' => 'comments', 'action' => 'admin'));
				echo '</li>';
				echo $this->Html->tag('li', null);
					echo $html->link('Administrar usuarios',array('controller' => 'users', 'action' => 'admin'));
				echo '</li>';
				echo $this->Html->tag('li', null);
					echo $html->link('Administrar invitaciones',array('controller' => 'invitations', 'action' => 'admin'));
				echo '</li>';
			echo '</ul>';
		}
	?>
	</li>
	<?php
		echo $this->Html->tag('li', null, array('class'=>'new'));
			echo $this->Html->link(__('New Chain',true),array('controller' => 'chains', 'action' => 'add'));
	?>
	</li>
	<?php
		echo $this->Html->tag('li', null);
			echo $this->Html->link(__('My Account',true),array('controller' => 'users', 'action' => 'account'));
	?>
	</li>
</ul>

<!-- ***  SUB NAV *** -->
<?php
	echo $this->Html->tag('ul', null, array('id'=>'sub-nav', 'class'=>'clearfix'));
?>
	<?php
		if(empty($username))
			{
				echo $this->Html->tag('li',null);
				echo $this->Html->link(__('Login',true), array('controller' => 'users', 'action' => 'login'));
				echo '</li>';
			}
		else
			{
				echo $this->Html->tag('li',null);
				echo __('Welcome,').' '.$session->read('Auth.User.username');
				echo $this->Html->link(__('Logout',true), array('controller' => 'users', 'action' => 'logout'));
				echo '</li>';
			}
	?>
	</li>
</ul>

<!-- ***  SEARCHER *** -->
<?php
echo $this->Form->create('', array('action'=>'search'));
echo $this->Form->input('search', array('type'=>'text', 'id'=>'searchinput', 'label'=>__('Search...',true)));
echo $this->Form->end(__('Search...',true));
?>