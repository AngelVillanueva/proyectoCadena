<?php 

class PagesController extends AppController {

 var $uses = array();
 
 var $helpers = array('Text', 'Form', 'Html');






function beforeFilter() {
    
     $this->Auth->allow('index');
     
     }



function index()
{



}


}