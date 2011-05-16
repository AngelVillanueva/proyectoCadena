<?php 

class PagesController extends AppController {

 var $uses = array();
 
 var $helpers = array('Text', 'Form', 'Html');






function beforeFilter() {
    
     $this->Auth->allow('index', 'selectLang');
     
     }



function index()
{

	$this->set('title_for_layout', __('Camelidus', true));

}


}

?>