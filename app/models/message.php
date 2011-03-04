<?php

class Message extends AppModel 

{

	var $name = 'Message';
	
	  var $belongsTo = array( 
	         
	  		'From' => array(            
	  				'className' => 'User',           
	  				'foreignKey' => 'user_id'      
	  				
	  		 ), 
	  				       
	  		'Receiver' => array(            
	  				'className' => 'User',            
	  				'foreignKey' => 'receiver_id'        
	  	)    
	 );

}
	


?>