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
	
	//$this->autoRender = false;
	if(!empty($this->data)) { 

	$search = $this->data[$this->modelClass]['Buscar'];
	$cond ="";
	
	$i=0;
	foreach($this->{$this->modelClass}->_schema as $field => $value){
	//debug($field);
	if($i>0){
	$cond = $cond. " OR ";
	}
	$cond = $cond. " ".$this->modelClass.".".$field." LIKE '%".$search."%' ";
	$i++;
	}
	
	$this->Session->write('Search', $cond);
	
	}
	
	else
	{
	
	$cond = $this->Session->read('Search');
	
	}
	
	
	$conditions = array('limit'=>4,	'conditions'=> $cond);
	$this->paginate = $conditions;
	$this->set('data', $this->paginate());
	//$this->render('index');
	}



}

?>