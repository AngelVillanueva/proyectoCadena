<?php

class User extends AppModel 

{

	var $name = 'User';
	

	
	var $hasMany = array(
	
			'Chain',
			'Item', 
			'Favorite',
			
			'SentMessage' => array(
					'className' => 'Message',
					'foreignKey' => 'user_id'
			),
			
			'ReceivedMessage' => array(
					'className' => 'Message',
					'foreignKey' => 'receiver_id'
			)
			
			
			
			);
	
	var $validate = array(
	
			'username' => array (
					'required' => array(
					'rule' => array('minLength', 3)
					
					),
					'unique' => array(
					'rule' => array('isUnique', 'username'),
					'message' => 'El usuario ya existe'
					)
					),
			
			'mail' => array (
					'valid' => array(
					'rule' => array('email')
					
					),
					'required' => array(
					'rule' => array('minLength', 1)
					),
					'unique' => array(
					'rule' => array('isUnique', 'mail'),
					'message' => 'El mail ya existe'
					)
					
					
				),
				
			'password' => array (
					'required' => array(
					'rule' => array('minLength', 5),
					'message' => 'La contraseña debe contener al menos 5 caracteres'
					)
					
				),
			
			'password_confirm' => array (
					'required' => array(
					'rule' => array('minLength', 5),
					'message' => 'La contraseña debe contener al menos 5 caracteres'
					
					),
				
	
					)
			
				);
				
	
	function isUnique() {
	
		$args = func_get_args();
		$field = $args[1];
		$exists = $this->hasAny("$field='".$this->data["User"][$field]."'");
		return $exists===false;
	}
	
	

}


?>