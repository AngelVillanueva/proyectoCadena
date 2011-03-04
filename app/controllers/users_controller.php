<?php

class UsersController extends AppController {

	var $name = 'Users';
	
	function index(){}
	
	function beforeFilter() {
	
	      $this->Auth->allow('login', 'logout');
	      
	    }
	
	
	function login(){
	}
	
	function logout(){
	
		$this->redirect($this->Auth->logout());
	}


	function account($account_user = null)
	
	{
	
	
	$user = $this->Session->read('Auth.User.username');
	$this->set('user',$user);
	
	$user_id = $this->Session->read('Auth.User.id');
	$this->set('user_id',$user_id);
	
	
	if($account_user != $user)
	{
	$account_id = $this->User->field('id', array('User.username' => $account_user));
	}
	
	$add_fav = 0;
	
	
	if(!empty($account_id))
	{
	
	$this->User->id = $account_id;
	$this->set('account_id', $account_id);
	
	$account_mail = $this->User->field('mail');
	$account_username = $this->User->field('username');
	$this->set('account_username', $account_username);
	
	$tittle1 = 'Cadenas de '.$account_username;
	$this->set('tittle1', $tittle1);
	$tittle2 = 'Cadenas en las que '.$account_username.' ha participado';
	$this->set('tittle2', $tittle2);
	
	$add_fav = 1;
	
	
	}
	
	else
	
	{
	
	$account_id = $this->Session->read('Auth.User.id');
	$this->set('account_id',$account_id);
	
	$account_mail = $this->Session->read('Auth.User.mail');
	$this->set('account_mail',$account_mail);
	
	$tittle1 = 'Tus cadenas';
	$this->set('tittle1', $tittle1);
	$tittle2 = 'Cadenas en las que has participado';
	$this->set('tittle2', $tittle2);
	
	
	
	
	}
	
	
	$this->User->Chain->recursive = 0;
	
	$data = $this->paginate('Chain');
	$this->set(compact('data'));
	
	//invitationes pendientes
	$this->set('pending', $this->User->Chain->Invitation->find('count', array('conditions' => array('Invitation.guest_mail' => $account_mail, 'Invitation.pending' => 1))));
	
	//array de cadenas del usuario
	$this->set('user_chains', $this->User->Chain->find('all',array('conditions' => array('Chain.user_id' => $account_id),'limit' => 5, 'order' => 'Chain.id ASC')));
	
	//array de cadenas en las que el usuario ha participado
	$this->set('join_chains', $this->User->Chain->Item->find('all', array('conditions' => array('Item.user_id' => $account_id), 'group by' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'), 'fields' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'),'limit' => 5, 'order' => 'Chain.id ASC')));
	
	
	
	$filter_fav_chains = $this->User->Favorite->find('all', array('conditions' => array('Favorite.user_id' => $account_id, 'Favorite.type' => 1), 'fields' => array('Favorite.fav_id')));
	
	$filter_fav_users = $this->User->Favorite->find('all', array('conditions' => array('Favorite.user_id' => $account_id, 'Favorite.type' => 0), 'fields' => array('Favorite.fav_id')));
	
	$list_chains = array();
	$list_users = array();
	
	foreach($filter_fav_chains as $favorite_chains)
	{
	
	array_push($list_chains, $favorite_chains['Favorite']['fav_id']);
	
	}
	
	foreach($filter_fav_users as $favorite_users)
	{
	
	array_push($list_users, $favorite_users['Favorite']['fav_id']);
	
	}
	
	$fav_chains = $this->User->Chain->find('all', array('conditions' => array('Chain.id' => $list_chains)));
	$this->set('fav_chains', $fav_chains);
	
	$fav_users = $this->User->find('all', array('conditions' => array('User.id' => $list_users)));
	$this->set('fav_users', $fav_users);
	
	$this->set('add_fav', $add_fav);
	
	
	}


	function add(){
	
		$user = $this->Session->read('Auth.User.username');
		$role = $user = $this->Session->read('Auth.User.role');
		$this->set('user',$user);
		
		if($role != 1)
		{
		
		$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
		$this->redirect(array('controller' => 'chains', 'action' => 'index'));
		
		}
		
		if(!empty($this->data))
		
		{
		
		if ($this->User->save($this->data)) { 
		
		
		
		$this->Session->setFlash('Usuario guardado!');
		$this->redirect(array('controller' => 'users', 'action' => 'add')); 
		
		}
		
		}
		
		
	
	}
	
	
	function delete($id = null)
	
	{
	
	$user = $this->Session->read('Auth.User.username');
	$role = $user = $this->Session->read('Auth.User.role');
	$this->set('user',$user);
	
	if($role != 1)
	{
	
	$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
	$this->redirect(array('controller' => 'chains', 'action' => 'index'));
	
	}
	
	
	$this->User->id = $id;
	
	$this->User->delete($id, false);
	
	$this->Session->setFlash('Usuario eliminado!');
	$this->redirect(array('controller' => 'users', 'action' => 'view')); 
	
	
	
	
	}
	
	function last_user()
	{
	
	$this->set('last_user', $this->User->find('first',  array('order' => array('User.created DESC'))));
	
	}
	
	
	function view()
	
	{
	
	$user = $this->Session->read('Auth.User.username');
	$role = $user = $this->Session->read('Auth.User.role');
	$this->set('user',$user);
	
	if($role != 1)
	{
	
	$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
	$this->redirect(array('controller' => 'chains', 'action' => 'index'));
	
	}
	
	
	
	
	
	$data = $this->paginate('User');
	$this->set(compact('data'));
	
	}

}


?>