<!-- *** LOGO *** -->
<?php
	echo $this->Html->div('', null, array('id'=>'site-logo'));
?>
<?php
	echo $this->Html->link(
		$this->Html->image('logo-camelidus.png', array('alt'=>'Camelidus logo', 'title'=>'Camelidus')),
		array('controller'=>'pages', 'action'=>'index'),
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
					if(!empty($username))
						{
							echo $this->Html->tag('li',
								$this->Html->tag('span', __('Welcome,', true).' '.$session->read('Auth.User.username')),
							array('escape'=>false)
							);
						}
				?>
				<?php 
					echo $this->Html->tag('li', null);
						echo $this->Html->link(
							$this->Html->image('facebook.png', array('alt'=>'Facebook', 'title'=>'Camelidus Facebook')),
							'http://www.facebook.com/camelidusweb',
							array('escape'=>false)
						);
					echo '</li>';
					echo $this->Html->tag('li', null);
						echo $this->Html->link(
							$this->Html->image('twitter.png', array('alt'=>'Twitter', 'title'=>'Camelidus Twitter')),
							'http://www.twitter.com/camelidusweb',
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
	echo $this->Html->tag('nav', null, array('id'=>'main-nav', 'class'=>'clearfix', 'role'=>'navigation'));
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
			echo $this->Html->link(__('New Chain',true), array('controller' => 'chains', 'action' => 'add'), array('class'=>'new'));
	?>
	</li>
	<?php
		if($username) {
			
			$pending = $this->requestAction('chains/getPending');
			$requests = $this->requestAction('chains/getRequestInvitations');
			$messages = $this->requestAction('users/getMessages');
			$new_messages = $this->requestAction('users/getNewMessages');
			
			echo $this->Html->tag('li', null);
				echo $this->Html->link(__('My Account',true),array('controller' => 'users', 'action' => 'account'));
				echo $this->Html->tag('ul', null);
						if($pending) {
						echo $this->Html->tag('li', null);
							echo $this->Html->link($pending.__(' pending invitations', true), array('controller' => 'invitations', 'action' => 'view'));
						echo '</li>';
						}
						if($requests) {
						echo $this->Html->tag('li', null);
							echo $this->Html->link($requests.__(' pending requests', true), array('controller' => 'invitations', 'action' => 'viewRequest'));
						echo '</li>';
						}
						if($new_messages) {
						echo $this->Html->tag('li', null);
							echo $this->Html->link($new_messages.' '.__('new messages', true), array('controller' => 'messages', 'action' => 'inbox'));
						echo '</li>';
						}
					echo '</ul>';
			echo '</li>';
			
			if($pending || $requests || $new_messages) {
				echo $this->Html->tag('li', null);
					echo $this->Html->link(__($pending + $requests + $new_messages,true), array('controller' => 'users', 'action' => 'account'), array('class'=>'bubble'));
				echo '</li>';
			}
			echo $this->Html->tag('li',null, array('class'=>'logout'));
			echo $this->Html->link(__('Logout',true), array('controller' => 'users', 'action' => 'logout'), array('class'=>'logout'));
			echo '</li>';
			
		}
		else {
			echo $this->Html->tag('li',null);
				echo $this->Html->link(__('Login / Register',true), array('controller' => 'users', 'action' => 'login'));
			echo '</li>';
		}
	?>
</nav>

<!-- ***  SEARCHER *** -->
<?php

if($modelo == 'pages') { $modelo = 'Chain'; } else { $modelo = ''; }

echo $this->Form->create($modelo, array('action'=>'search', 'class'=>'searchform'));
echo $this->Form->input('search', array('type'=>'text', 'id'=>'searchinput', 'label'=>__('Search...',true)));
echo $this->Form->end(__('Search...',true));
?>

<!-- *** LANGUAGE *** -->

<?php

$pass = '';

$action = $this->params['action'];

if(!empty($this->passedArgs[0]))
	{

		$pass = $this->passedArgs[0];

	}
	
echo $this->Html->link(__('Eng',true), array('action' => 'selectLang', 'eng', $action, $pass));

echo $this->Html->link(__('Esp',true), array('action' => 'selectLang', 'esp', $action, $pass));
?>

