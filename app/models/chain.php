<?php

class Chain extends AppModel 

{

	var $name = 'Chain';
	var $hasMany = array('Item', 'Vote', 'Comment', 'Invitation');
	var $belongsTo = array('User');
	var $hasOne = 'Objetive';
	
	
	
		
	




}


?>