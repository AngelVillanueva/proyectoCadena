<?php

class Item extends AppModel 

{

	var $name = 'Item';
	var $belongsTo = array('Chain', 'User');
	var $hasMany = array('Vote', 'Comment');
	
	
	
		
	




}


?>