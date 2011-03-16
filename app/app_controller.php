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