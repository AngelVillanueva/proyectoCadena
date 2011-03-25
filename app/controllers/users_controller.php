<?php

class UsersController extends AppController {

	var $name = 'Users';
	
	var $components = array('Attachment' => array('files_dir' => 'users', 'images_size' => array( 'avatar' => array(75, 75, 'resizeCrop'))));
	
	
	
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
	
	$account_mail = $this->Session->read('Auth.User.mail');
	$this->set('account_mail',$account_mail);
	
	
	if($account_user != $user)
	{
	$account_id = $this->User->field('id', array('User.username' => $account_user));
	
	}
	
	$check_user = 0;
	
	
	if(!empty($account_id))
	{
	
	$this->User->id = $account_id;
	$this->set('account_id', $account_id);
	
	
	$account_username = $this->User->field('username');
	$this->set('account_username', $account_username);
	
	$file_path = $this->User->field('user_file_path');
	$this->set('file_path', $file_path);
	
	$tittle1 = 'Cadenas de '.$account_username;
	$this->set('tittle1', $tittle1);
	$tittle2 = 'Cadenas en las que '.$account_username.' ha participado';
	$this->set('tittle2', $tittle2);
	
	$check_user = 1;
	
	
	}
	
	else
	
	{
	
	$account_id = $this->Session->read('Auth.User.id');
	$this->set('account_id',$account_id);
	
	$account_username = $this->Session->read('Auth.User.username');
	$this->set('account_username', $account_username);
	
	
	$this->User->id = $account_id;
	
	$file_path = $this->User->field('user_file_path');
	$this->set('file_path', $file_path);
	
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
	
	//Array de cadenas en las que el usuario ha participado
	
	$this->set('join_chains', $this->User->Chain->Item->find('all', array('conditions' => array('Item.user_id' => $account_id), 'group by' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'), 'fields' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'),'limit' => 5, 'order' => 'Chain.id ASC')));
	
	//Mensajes y mensajes sin leer
	
	$messages = $this->User->ReceivedMessage->find('count', array('conditions' => array('ReceivedMessage.receiver_id' => $user_id, 'ReceivedMessage.deleted' => 0)) );
	$this->set('messages', $messages);
	
	$new_messages =  $this->User->ReceivedMessage->find('count', array('conditions' => array('ReceivedMessage.receiver_id' => $user_id, 'ReceivedMessage.read' => 0, 'ReceivedMessage.deleted' => 0)));
	$this->set('new_messages', $new_messages);
	
	
	//Cadenas favoritas
	
	$filter_fav_chains = $this->User->Favorite->find('all', array('conditions' => array('Favorite.user_id' => $account_id, 'Favorite.type' => 1), 'fields' => array('Favorite.fav_id')));
	
	//Usuarios favoritos
	
	$filter_fav_users = $this->User->Favorite->find('all', array('conditions' => array('Favorite.user_id' => $account_id, 'Favorite.type' => 0), 'fields' => array('Favorite.fav_id')));
	
	//Se crean las listas para cadenas favoritas y usuarios favoritos
	
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
	
	
	$this->set('check_user', $check_user);
	
	
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
		
		$file_path = $this->Attachment->upload($this->data['User']);
		$this->data['User']['active'] = 1;
		
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
	
	function edit()
	{
	
	$user = $this->Session->read('Auth.User.username');
	$user_id = $this->Session->read('Auth.User.id');
	
	
	
	$this->User->id = $user_id;
	
	$this->set('file_path', $this->User->field('user_file_path'));
	
	
	if(!empty($this->data))
	
	{
	
	$file_path = $this->Attachment->upload($this->data['User']);
	
	$this->User->saveField('user_file_path', $this->data['User']['user_file_path']);
	$this->User->saveField('user_file_name', $this->data['User']['user_file_name']);
	$this->User->saveField('user_file_size', $this->data['User']['user_file_size']);
	$this->User->saveField('user_content_type', $this->data['User']['user_content_type']);
	
	$this->set('file_path', $this->User->field('user_file_path'));
	
	$this->Session->setFlash('Datos actualizados');
	$this->redirect(array('controller' => 'users', 'action' => 'account', $user));
	
	
	}
	
	
	
	}
	
	function active($account_id = null)
	
	{
	
	$user = $this->Session->read('Auth.User.username');
	$role = $this->Session->read('Auth.User.role');
	$this->set('user',$user);
	
	$this->User->id = $account_id;
	
	if($role != 1)
	{
	
	$this->Session->setFlash('Solo el Admin puede aprobar items.'.$item_user.'/'.$user);
	$this->redirect(array('controller' => 'items', 'action' => 'view', $id));
	
	}
	
	$status = $this->User->field('active');
	
	if($status == 0)
	{
	$this->User->saveField('active', 1);
	$this->Session->setFlash('Usuario activo');
	$this->redirect(array('controller' => 'users', 'action' => 'admin'));
	}
	else
	{
	$this->User->saveField('active', 0);
	$this->Session->setFlash('Usuario NO activo');
	$this->redirect(array('controller' => 'users', 'action' => 'admin'));
	}
	
	
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