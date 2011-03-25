<?php

class Chain extends AppModel 

{

	var $name = 'Chain';
	var $hasMany = array('Item', 'Vote', 'Comment', 'Invitation', 'Objetive');
	var $belongsTo = array('User');
	
	
	

	
		
	




}


?>