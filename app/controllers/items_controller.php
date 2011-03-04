<?php 

class ItemsController extends AppController {

var $name = 'Items';
var $components = array('Attachment' => array('files_dir' => 'items', 'images_size' => array( 'avatar' => array(75, 75, 'resizeCrop') ) ));

var $paginate = array('fields' => array('Item.id', 'Item.name','Item.user_id', 'Item.chain_id','Item.type', 'Item.username', 'Item.position', 'Item.n_hits', 'Item.n_votes', 'Item.n_comments', 'Item.item_file_path', 'Item.item_file_size','Item.denounced', 'Item.approved'), 'limit' => 5, 'order' => array('Item.id' => 'asc'));


function beforeFilter(){

 $this->Auth->allow('view');
 
}

function index()
{}



function add($id = null, $item_type = null) 
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$user_mail = $this->Session->read('Auth.User.mail');
$this->set('user_mail',$user_mail);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);

$this->Item->Chain->id = $id;
$this->set('chain_id', $id);

$this->set('item_type', $item_type);



if (!empty($this->data)) {

	$item_type = $this->data['Item']['type'];

	switch($item_type)
	{

	

		//texto
		case 1:
		break;
		
		//foto
		case 2:
		$this->Session->setFlash('ESTO EN FOTO');
			$username = $this->Session->read('Auth.User.username');
			$this->set('username',$username); 
		
			$user_id = $this->Session->read('Auth.User.id');
			$this->set('user_id',$user_id);
			
		
			$this->data['Item']['user_id'] = $user_id;
			$this->data['Item']['username'] = $username;
			$this->data['Item']['denounced'] = 0;
			$this->data['Item']['approved'] = 1;
			
			
			$file_path = $this->Attachment->upload($this->data['Item']);
		
		
			if($this->Item->save($this->data))
				{
			
				$chain_id = $this->data['Item']['chain_id'];
				$this->Item->Chain->id = $chain_id;
				$n_items = $this->Item->Chain->field('n_items');
				$this->Item->Chain->saveField('n_items', $n_items + 1);
				$this->Item->saveField('position', $n_items + 1);
				
				$item_id = $this->Item->id; 
				$user_mail = $this->Session->read('Auth.User.mail');         
					
				$invitations = $this->Item->Chain->Invitation->find('all', array('conditions' => array('Invitation.chain_id' => $chain_id, 'Invitation.guest_mail' => $user_mail)));
					
				foreach($invitations as $invitation)
					{
					
					$this->Item->Chain->Invitation->id = $invitation['Invitation']['id'];
					$this->Item->Chain->Invitation->saveField('pending', 0);
					
					
					}
				
				$this->redirect(array('controller' => 'invitations', 'action' => 'add/'.$chain_id));
					 
					//DEBE ACTIVARSE UN BOTÓN PARA CONTINUAR
					
					
				}
			else{
			$this->Session->setFlash('PROBLEMON');
			
			}
		
		break;
		
		//video
		case 3:
		break; 
	
	}


/*

$username = $this->Session->read('Auth.User.username');
$this->set('username',$username); 

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);


	if(empty($this->data['Item']['name']) || empty($this->data['Item']['description'])){
	
	$this->Session->setFlash('Debe rellenar todos los campos!');

	}
	
	else
	{
	$this->data['Item']['user_id'] = $user_id;
	$this->data['Item']['username'] = $username;
	

	$file_path = $this->Attachment->upload($this->data['Item']);
		
	if($this->Item->save($this->data))
	{

	$chain_id = $this->data['Item']['chain_id'];
	$this->Item->Chain->id = $chain_id;
	$n_items = $this->Item->Chain->field('n_items');
	$this->Item->Chain->saveField('n_items', $n_items + 1);
	$this->Item->saveField('position', $n_items + 1);
	
	
	
	$item_id = $this->Item->id; 
	$user_mail = $this->Session->read('Auth.User.mail');         
	
	$invitations = $this->Item->Chain->Invitation->find('all', array('conditions' => array('Invitation.chain_id' => $chain_id, 'Invitation.guest_mail' => $user_mail)));
	
	foreach($invitations as $invitation)
	{
	
	$this->Item->Chain->Invitation->id = $invitation['Invitation']['id'];
	$this->Item->Chain->Invitation->saveField('pending', 0);
	
	
	}

	$this->redirect(array('controller' => 'invitations', 'action' => 'add/'.$chain_id));
	 
	//DEBE ACTIVARSE UN BOTÓN PARA CONTINUAR
	
	
	}


	}
*/	
}

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

$this->Item->recursive = 0;

$data = $this->paginate('Item');
$this->set(compact('data'));


}


function denounce($id = null)
{

$this->Item->id = $id;

$this->Item->saveField('denounced', 1);
$this->Session->setFlash('Item Denunciado, En breve revisaremos su contenido...');
$this->redirect(array('controller' => 'items', 'action' => 'view', $id));

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

$this->Item->id = $id;
$status = $this->Item->field('approved');

if($status == 0)
{
$this->Item->saveField('approved', 1);
$this->Session->setFlash('Item APROBADO');
$this->redirect(array('controller' => 'items', 'action' => 'admin'));
}
else
{
$this->Item->saveField('approved', 0);
$this->Session->setFlash('Item DESAPROBADO');
$this->redirect(array('controller' => 'items', 'action' => 'admin'));
}

}

function last_item()
{

$this->set('last_item', $this->Item->find('first',  array('order' => array('Item.created DESC'))));

}

function select_type($id = null)
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);

$this->set('chain_id', $id);

if (!empty($this->data)) {

	$item_type = $this->data['Item']['type'];
	$id = $this->data['Item']['chain_id'];
	
	$this->redirect(array('controller' => 'items', 'action' => 'add/'.$id.'/'.$item_type));
	
	

}

}

function view($id = null) 
{

// REDIRECCIONAR A UNA PAGINA DE ERROR ????

$check_id = $this->Item->find('count', array('conditions' => array('Item.id' => $id)));

if($check_id == 0)
{

$this->Session->setFlash('El item que quiere ver no existe');

}

else
{

$this->Item->id = $id;
$this->set('item', $this->Item->read());
$this->set('id', $id);

//actualiza hits de item
$n_hits = $this->Item->field('n_hits');
$this->Item->saveField('n_hits', $n_hits + 1);

//lista de comentarios que corresponden a la cadena
$this->set('n_comments', $this->Item->field('n_comments'));
$this->set('comments', $this->Item->Comment->find('all', array('conditions' => array('Comment.item_id' => $this->Item->id), 'order' => 'Comment.id ASC')));
}

}


}

?>