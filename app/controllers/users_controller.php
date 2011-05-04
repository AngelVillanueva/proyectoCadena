<?php

class UsersController extends AppController {

	var $name = 'Users';
	
	var $components = array('MathCaptcha', 'Email', 'Attachment' => array('files_dir' => 'users', 'images_size' => array( 'avatar' => array(75, 75, 'resizeCrop'))));
	
	
	
	function index(){}
	
	function beforeFilter() {
	
	      $this->Auth->allow('login', 'logout', 'forgotPass', 'search', 'account');
	      
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
	
	//Comprueba si la cuenta de usuario es la suya
	
	if($account_id != $user_id)
	{
	$check_user = 1;
	}
	
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
	$this->set('pending', $this->User->Chain->Invitation->find('count', array('conditions' => array('Invitation.guest_mail' => $account_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1))));
	
	//array de cadenas del usuario
	$this->set('user_chains', $this->User->Chain->find('all',array('conditions' => array('Chain.user_id' => $account_id),'limit' => 5, 'order' => 'Chain.id ASC')));
	
	//Array de cadenas en las que el usuario ha participado
	
	$this->set('join_chains', $this->User->Chain->Item->find('all', array('conditions' => array('Item.user_id' => $account_id),'group' => array('Chain.id'), 'fields' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'),'limit' => 5, 'order' => 'Chain.id ASC')));
	
	//Mensajes y mensajes sin leer
	
	$messages = $this->User->ReceivedMessage->find('count', array('conditions' => array('ReceivedMessage.receiver_id' => $user_id, 'ReceivedMessage.deleted' => 0), 'fields' => 'DISTINCT ReceivedMessage.conv_id') );
	$this->set('messages', $messages);
	
	$new_messages =  $this->User->ReceivedMessage->find('count', array('conditions' => array('ReceivedMessage.receiver_id' => $user_id, 'ReceivedMessage.read' => 0, 'ReceivedMessage.deleted' => 0), 'fields' => 'DISTINCT ReceivedMessage.conv_id'));
	$this->set('new_messages', $new_messages);
	
	
	//Seguidores
	
	$supporters = $this->User->Favorite->find('count', array('conditions' => array('Favorite.fav_id' => $account_id, 'Favorite.type' => 0)));
	$this->set('supporters', $supporters);
	
	//Comprueba si ya sigue al usuario
	
	$check_fav = $this->User->Favorite->find('count', array('conditions' => array('Favorite.user_id' => $user_id, 'Favorite.fav_id' => $account_id, 'Favorite.type' => 0)));
	$this->set('check_fav', $check_fav);
	
	
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
	


	function add(){
	
		$user = $this->Session->read('Auth.User.username');
		$role = $user = $this->Session->read('Auth.User.role');
		$this->set('user',$user);
		
		/*
		if($role != 1)
		{
		
		$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
		$this->redirect(array('controller' => 'chains', 'action' => 'index'));
		
		}
		*/
		
		if(!empty($this->data))
		
		{
		
			
		
				if($this->MathCaptcha->validates($this->data['User']['security_code']))
				{
		
					if ($this->data['User']['password'] == $this->Auth->password($this->data['User']['password_confirm']))
					{
			
		
					$file_path = $this->Attachment->upload($this->data['User']);
					$this->data['User']['active'] = 1;
		
					if ($this->User->save($this->data)) { 
		
		
		
					$this->Session->setFlash('Usuario guardado!');
					$this->redirect(array('controller' => 'users', 'action' => 'add')); 
		
					}
				}
		
				else{
			
				$this->Session->setFlash('Las contraseñas no coinciden');
		
				}
		
				}
		
			else{
				$this->Session->setFlash(__('Please enter the correct answer to the math question.', true));
			
			}
			
			
		
			}
			
			$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());
	
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
	
	$this->Session->setFlash('Usuario desactivado!');
	$this->redirect(array('controller' => 'users', 'action' => 'view')); 
	
	
	
	
	}
	
	
	function edit()
	
	{
	
	$user = $this->Session->read('Auth.User.username');
	$this->set('username', $user);
	$user_id = $this->Session->read('Auth.User.id');
	
	$this->User->id = $user_id;
	
	$this->set('file_path', $this->User->field('user_file_path'));
	
	if(!empty($this->data))
	
	{
	
	if ($this->data['User']['password'] == $this->data['User']['password_confirm'])
	{
		
		$this->data['User']['password'] =  $this->Auth->password($this->data['User']['password']);
	
		$file_path = $this->Attachment->upload($this->data['User']);
		
		if ($this->User->save($this->data)) { 
		
		
		
			$this->Session->setFlash('Usuario guardado!');
			$this->redirect(array('controller' => 'users', 'action' => 'account', $user)); 
		
			}
		
	
	}
	
	else
	{
	
	$this->Session->setFlash('Las contraseñas no coinciden');
	
	}
	
	}
	
	}
	
	
	
	function forgotPass($token = null)
	{
	
	if (!empty($this->data['User']['mail'])){ 
	
		$user = $this->User->findByMail($this->data['User']['mail']);
		
		if (empty($user)){ 
		
			$this->Session->setFlash('Unknown email.');   
			  
		}
		
		else
		{
			$username = $user['User']['username'];
			$salt = Configure::read('Security.salt');
			$emailtoken = md5($user['User']['password'].$salt);
			
			//SMTP
			$this->Email->smtpOptions = array(
			'port' => '25',
			'timeout' => '30',
			'host' => 'smtp.1and1.es',
			'username' => 'tests@sinapsescopio.es',
			'password' => 'key1and11971');
			
			//método de entrega
			$this->Email->delivery = 'smtp';
			
			//Para enviar mails
			$this->Email->from = 'tests@sinapsescopio.es';
			$this->Email->to = $this->data['User']['mail'];
			$this->Email->subject = $username.' le recordamos su contraseña';
			$this->Email->send();
			
						
			$this->Session->setFlash('Check your email.-> '.$emailtoken); 
			
		
		
		}
	
	}
	
	
	if (!empty($token)){
		
		$salt = Configure::read('Security.salt');

		$user_id = '';
		
		$users = $this->User->find('all');
		
		foreach($users as $user)
		{
		
		if(md5($user['User']['password'].$salt) == $token)
		{
		
		$user_id = $user['User']['id'];
		
		}
		
		}
		
		$this->User->id = $user_id;
		
		if (empty($user_id)){ 
		       
			$this->Session->setFlash('Invalid token.'); 
			return; 
			
		} 
	
		if (!empty($this->data['User']['password'])){
		
			if ($this->data['User']['password'] == $this->data['User']['password_confirm'])
			{
		
				$this->data['User']['password'] = $this->Auth->password($this->data['User']['password']); 
		 		$this->User->save($this->data); 
		 		$this->Session->setFlash('New password set.'); 
		 		$this->redirect('/');
		 	}
		
		}
		
		$this->set('token', $token); 
		$this->render('resetPass');
	
	}
	
	}
	
	function getMessages()
	{
		$user_id = $this->Session->read('Auth.User.id');
		
		$messages = $this->User->ReceivedMessage->find('count', array('conditions' => array('ReceivedMessage.receiver_id' => $user_id, 'ReceivedMessage.deleted' => 0), 'fields' => 'DISTINCT ReceivedMessage.conv_id') );
	if(isset($this->params['requested'])) {
		return $messages;
	}
	else {
		$this->set('messages', $messages);
	}
	}
	
	function getNewMessages()
	{
		$user_id = $this->Session->read('Auth.User.id');
		
		$new_messages =  $this->User->ReceivedMessage->find('count', array('conditions' => array('ReceivedMessage.receiver_id' => $user_id, 'ReceivedMessage.read' => 0, 'ReceivedMessage.deleted' => 0), 'fields' => 'DISTINCT ReceivedMessage.conv_id'));
	if(isset($this->params['requested'])) {
		return $new_messages;
	}
	else {
		$this->set('new_messages', $new_messages);
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