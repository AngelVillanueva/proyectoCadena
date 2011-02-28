<?php 

class VotesController extends AppController {

var $name = 'Votes';

function beforeFilter(){

 $this->Auth->allow('add');
}

function index()
{}

function add($id = null, $type) 
{

$user = $this->Session->read('Auth.User.username');
$session_id = $this->Session->id();
if(empty($user))
{
$user = $session_id;
}


$check = $this->Vote->find('count', array('conditions' => array('Vote.user' =>$user, 'OR' => array('Vote.chain_id' => $id, 'Vote.item_id' => $id))));

if($check==0)
{

switch($type)
{
	case 'c':
		$controller = 'chains';
		$this->Vote->Chain->id = $id;
		$n_votes = $this->Vote->Chain->field('n_votes');
		$this->Vote->Chain->saveField('n_votes', $n_votes + 1);
		$this->data['Vote']['chain_id'] = $id;
		$this->data['Vote']['item_id'] = 0;
		$this->data['Vote']['user'] = $user;
		$this->Vote->save($this->data);
		break;
	
	case 'i':
		$controller = 'items';
		$this->Vote->Item->id = $id;
		$n_votes = $this->Vote->Item->field('n_votes');
		$this->Vote->Item->saveField('n_votes', $n_votes + 1);
		$this->data['Vote']['chain_id'] = 0;
		$this->data['Vote']['item_id'] = $id;
		$this->data['Vote']['user'] = $user;
		$this->Vote->save($this->data);
		break;

}

	$this->Session->setFlash('Voto guardado!');
}

else
{
	
	switch($type)
	{
		case 'c':
			$controller = 'chains';
			$this->Session->setFlash('Solo se admite un voto por cadena!');
			break;
		case 'i':
			$controller = 'items';
			$this->Session->setFlash('Solo se admite un voto por item!');
			break;
	
	}
}

	$this->redirect(array('controller' => $controller, 'action' => 'view/'.$id));   
	
	
	


}


}

?>