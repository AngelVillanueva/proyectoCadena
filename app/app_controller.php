<?php

class AppController extends Controller {


	var $components = array('Auth', 'Session');
	
	
	
	function inicializarAuth()
	{
	
	$this->Auth->authorize = 'controller';
	$this->Auth->userModel = 'User';
	$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
	$this->Auth->loginRedirect = array('controller' => 'chains', 'action' => 'index');
	$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
	$this->Auth->loginError = 'El nombre de usuario y/o la contraseña no son correctos';
	$this->Auth->authError = 'No tienes permiso para entrar en esta zona';
	
	}
	
	
	
	function beforeFilter(){
	
	$this->inicializarAuth();
	
	
	}
	
	
	function admin()
	
	{
	
	$username = $this->Session->read('Auth.User.username');
	$role = $user = $this->Session->read('Auth.User.role');
	$this->set('username',$username);
	
	if($role != 1)
	{
	
	$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
	$this->redirect(array('controller' => $this->modelClass.'s', 'action' => 'index'));
	
	}
	
	$this->this->modelClass->recursive = 0;
	
	$data = $this->paginate($this->modelClass);
	$this->set(compact('data'));
	
	
	}
	
	function denounce($id = null)
	{
	
	$this->{$this->modelClass}->id = $id;
	
	$this->{$this->modelClass}->saveField('denounced', 1);
	$this->Session->setFlash('Denunciado, En breve revisaremos el contenido...');
	$this->redirect(array('controller' => $this->modelClass.'s' , 'action' => 'view', $id));
	
	}
	
	
	function last($id = null){
	
	//$this->layout = 'ajax';
	
	$cond = '';
	

	if(!empty($id)){
	
	$check = 0;
	
	switch($this->modelClass)
	{
	
	case 'User':
	
		$this->User->id = $id;
		$this->set('last_chain', $this->User->Chain->find('first', array('conditions' => array('Chain.user_id' => $id) , 'order' => 'Chain.created DESC')));
		$this->set('last_item', $this->User->Item->find('first', array('conditions' => array('Chain.user_id' => $id) ,'order' => 'Item.created DESC')));
		$this->set('last_fav_user', $this->User->Favorite->find('first', array('conditions' => array('Favorite.user_id' => $id, 'Favorite.type' => 0) ,'order' => 'Favorite.created DESC')));
		$this->set('last_fav_chain', $this->User->Favorite->find('first', array('conditions' => array('Favorite.user_id' => $id, 'Favorite.type' => 1) ,'order' => 'Favorite.created DESC')));
		
		$this->Session->setFlash('Usuarios');
		break;
		
	case 'Chain':
	
		$this->Chain->id = $id;
	
		$this->set('last_item', $this->Chain->Item->find('first', array('conditions' => array('Chain.id' => $id) , 'order' => 'Item.created DESC')));
		
		$this->set('chain_id', $this->Chain->id);
		$this->set('miles', $this->Chain->field('miles'));
			
		$this->Session->setFlash('Cadenas');
		break;
	
	}
	
	$this->paginate = array('conditions' => array(''.$this->modelClass.'.id' => $id), 'limit'=>5, 'order' => array(''.$this->modelClass.'.created DESC'));
	
	}
	
	else{
	
	
	$check = 1;
	$this->paginate = array('conditions' => $cond, 'limit'=>5, 'order' => array(''.$this->modelClass.'.created DESC'));
	
	
	}
	
	$this->set('check', $check);
	$this->set('data', $this->paginate());
	
	}
	



	function search(){
	
	$username = $this->Session->read('Auth.User.username');
	$this->set('username',$username);
	
	
	
	if(!empty($this->data))
	
	{
	
	$search = $this->data[$this->modelClass]['search'];
	
	//$cond = "Chain.name LIKE '%".$search."%'". " OR ". "User.username LIKE '%".$search."%'";
	
	//$conditions = array('limit'=>4,	'conditions'=> $cond);
	
	
	App::import('Model', 'User');       
	$user = new User();
	 
	App::import('Model', 'Chain');       
	$chain = new Chain();
	
	App::import('Model', 'Item');       
	$item = new Item();
	
	//$this->Session->write('Search', $cond);
	$this->Session->write('Search', $search);
	
	
	
	//$this->paginate = $conditions;
	}
	
	else
	{
	
	
	//$cond = $this->Session->read('Search');
	$search = $this->Session->read('Search');
	//$conditions = array('limit'=>4,	'conditions'=> $cond);
	
	
	
	//$this->paginate = $conditions;
	
	}
	
	
	$searchterm = "%".$search."%";

	
	
	$this->paginate = array(
	   'conditions' => array('Chain.name LIKE' => $searchterm),
	   'limit' => 10
	);
	
	$b_chains = $this->paginate('Chain');
	$this->set(compact('b_chains'));
	
	$this->paginate = array(
	   'conditions' => array('User.username LIKE' => $searchterm),
	   'limit' => 10
	);
	
	$b_users = $this->paginate('User');
	$this->set(compact('b_users'));
	
	$this->paginate = array(
	   'conditions' => array('Item.name LIKE' => $searchterm),
	   'limit' => 10
	);
	
	$b_items = $this->paginate('Item');
	$this->set(compact('b_items'));
	
	//$this->set('b_chains', $this->paginate('Chain', array('conditions' => array('Chain.name LIKE' => '%'.$search.'%')), 'DISTINCT Chain.name' ));
	
	//$this->set('b_users', $this->paginate('User', array('conditions' => array('User.username LIKE' => '%'.$search.'%')), 'DISTINCT User.username'));
	
	
	
	
	
	
	
	
	}

}

?>