<?php 

class CommentsController extends AppController {

var $name = 'Comments';

function beforeFilter(){

 $this->Auth->allow('add');
}

function index()
{}

function add($id = null, $type) 
{

$user = $this->Session->read('Auth.User.username');
if(empty($user))
{
$user = 'anonymous';
}



if (!empty($this->data))
{

switch($type)
{
	case 'c':
		$controller = 'chains';
		$this->Comment->Chain->id = $id;
		$n_comments = $this->Comment->Chain->field('n_comments');
		$this->Comment->Chain->saveField('n_comments', $n_comments + 1);
		$this->data['Comment']['chain_id'] = $id;
		$this->data['Comment']['item_id'] = 0;
		$this->data['Comment']['username'] = $user;
		$this->data['Comment']['approved'] = 1;
		$this->data['Comment']['denounced'] = 0;
		$this->Comment->save($this->data);
		break;
	
	case 'i':
		$controller = 'items';
		$this->Comment->Item->id = $id;
		$n_comments = $this->Comment->Item->field('n_comments');
		$this->Comment->Item->saveField('n_comments', $n_comments + 1);
		$this->data['Comment']['chain_id'] = 0;
		$this->data['Comment']['item_id'] = $id;
		$this->data['Comment']['username'] = $user;
		$this->data['Comment']['approved'] = 1;
		$this->data['Comment']['denounced'] = 0;
		$this->Comment->save($this->data);
		break;

}

	$this->Session->setFlash('Comentario guardado!');
}

else
{
	$this->Session->setFlash('No puede introducir un comentario vacio!');	
	
}

	$this->redirect(array('controller' => $controller, 'action' => 'view/'.$id));   
	
	
	


}

function admin()

{

$username = $this->Session->read('Auth.User.username');
$role = $user = $this->Session->read('Auth.User.role');
$this->set('username',$username);

if($role != 1)
{

$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
$this->redirect(array('controller' => 'chains', 'action' => 'index'));

}

$this->Comments->recursive = 0;

$data = $this->paginate('Comment');
$this->set(compact('data'));


}


function denounce($id = null, $chain_item_id = null, $type = null)
{

$this->Comment->id = $id;

$this->Comment->saveField('denounced', 1);
$this->Session->setFlash('Comentario Denunciado, En breve revisaremos su contenido...');

if($type == 'c')
{
$this->redirect(array('controller' => 'chains', 'action' => 'view', $chain_item_id));
}
elseif($type == 'i')
{
$this->redirect(array('controller' => 'items', 'action' => 'view', $chain_item_id));
}


}

function disapprove($id = null)

{

$username = $this->Session->read('Auth.User.username');
$role = $user = $this->Session->read('Auth.User.role');
$this->set('username',$username);

if($role != 1)
{

$this->Session->setFlash('Solo el Administrador puede acceder a esta zona.');
$this->redirect(array('controller' => 'chains', 'action' => 'index'));

}

$this->Comment->id = $id;
$status = $this->Comment->field('approved');

if($status == 0)
{
$this->Comment->saveField('approved', 1);
$this->Session->setFlash('Comentario APROBADO');
$this->redirect(array('controller' => 'comments', 'action' => 'admin'));
}
else
{
$this->Comment->saveField('approved', 0);
$this->Session->setFlash('Comentario DESAPROBADO');
$this->redirect(array('controller' => 'comments', 'action' => 'admin'));
}

}


}

?>