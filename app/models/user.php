<?php

class User extends AppModel 

{

	var $name = 'User';
	var $hasMany = array('Chain','Item');
	
	var $validate = array(
			'username' => array (
					'rule' => 'notEmpty',
					'message' => 'Introduzca nombre de usuario'
				),
			
				);
	
		
	




}


?>