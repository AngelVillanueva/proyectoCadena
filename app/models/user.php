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
					'rule' => 'notEmpty',
					'message' => 'Introduzca nombre de usuario'
				),
			
				);
	
		
	




}


?>