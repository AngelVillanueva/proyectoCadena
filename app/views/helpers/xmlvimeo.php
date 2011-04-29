<?php  

class XmlvimeoHelper extends AppHelper 
{ 
  
    function xml($id) 
    { 
         // clase XML de cakephp 
      App::import('Xml'); 
   
      // url del api de vimeo 
      $file = 'http://vimeo.com/api/v2/video/'.$id.'.xml'; 
   
      // Crear el arreglo apartir del XML 
      $Mixml =& new XML($file); 
      $Mixml  = Set::reverse($Mixml );  
   
      // devuelver el arreglo 
     return $Mixml ; 
    } 
} 

?> 