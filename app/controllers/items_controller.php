<?php 

class ItemsController extends AppController {

var $name = 'Items';
var $components = array('MathCaptcha', 'Attachment' => array('files_dir' => 'items', 'images_size' => array( 'avatar' => array(263, 263, 'resize') ) ));

var $paginate = array('fields' => array('Item.id', 'Item.name','Item.user_id', 'Item.chain_id','Item.type', 'Item.username', 'Item.position', 'Item.n_hits', 'Item.n_votes', 'Item.n_comments', 'Item.item_file_path', 'Item.item_file_size','Item.denounced', 'Item.approved'), 'limit' => 5, 'order' => array('Item.id' => 'asc'));


function beforeFilter(){

 $this->Auth->allow('view', 'search');
 
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

		if($this->MathCaptcha->validates($this->data['Item']['security_code']))
		{
		

				$item_type = $this->data['Item']['type'];
				$this->set('item_type', $item_type);
				
				$this->set('username',$username); 
		
				$user_id = $this->Session->read('Auth.User.id');
				$this->set('user_id',$user_id);
		
				$this->data['Item']['user_id'] = $user_id;
				$this->data['Item']['username'] = $username;
				$this->data['Item']['denounced'] = 0;
				$this->data['Item']['approved'] = 1;
				$this->data['Item']['deleted'] = 0;
	
				if($item_type == 2)
				{
	
					$file_path = $this->Attachment->upload($this->data['Item']);

	
				}
	
				if($this->Item->save($this->data))
			
				{
			
			
		
				$chain_id = $this->data['Item']['chain_id'];
				$this->Item->Chain->id = $chain_id;
				$n_items = $this->Item->Chain->field('n_items');
				$this->Item->Chain->saveField('n_items', $n_items + 1);
				$this->Item->saveField('position', $n_items + 1);
			
				//Actualizacion de millas
			
				$n_miles = $this->Item->Chain->field('miles');
			
				switch($item_type)
				{
			
				case 1:
				$this->Item->Chain->saveField('miles', $n_miles + 10);
				break;
			
				case 2:
				$this->Item->Chain->saveField('miles', $n_miles + 20);
				break;
			
				case 3:
				$this->Item->Chain->saveField('miles', $n_miles + 30);
				break;
			
			
				}
			
	
				$item_id = $this->Item->id; 
				$user_mail = $this->Session->read('Auth.User.mail'); 
			
			
				$invitations = $this->Item->Chain->Invitation->find('all', array('conditions' => array('Invitation.chain_id' => $chain_id, 'Invitation.guest_mail' => $user_mail)));
					
					foreach($invitations as $invitation)
					{
				
					//Borra la invitation
					$this->Item->Chain->Invitation->delete($invitation['Invitation']['id']);
					
					}
				
				$this->redirect(array('controller' => 'invitations', 'action' => 'add/'.$chain_id));
					 
					//DEBE ACTIVARSE UN BOTÓN PARA CONTINUAR
					
					
				}
				
				else{
					$this->Session->setFlash('Problema al guardar datos');
			
				}
				
		}
		
		else{
			$this->Session->setFlash(__('Please enter the correct answer to the math question.', true));
		
		}

		}

		$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

}


function delete($id = null)

{

$user = $this->Session->read('Auth.User.username');
$user_mail = $this->Session->read('Auth.User.mail');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);



$this->Item->id = $id;
$chain_id = $this->Item->field('chain_id');
$item_type = $this->Item->field('type');


$item_user = $this->Item->field('username');

if($role != 1 && $item_user != $user)
{

$this->Session->setFlash('Solo el Propietario del item puede eliminarlo.');
$this->redirect(array('controller' => 'items', 'action' => 'view', $id));

}

$position = $this->Item->field('position');
$this->Item->Chain->id = $chain_id;

$n_items = $this->Item->Chain->field('n_items');
$this->Item->Chain->saveField('n_items', $n_items - 1);

//Borra el Item

$this->Item->delete($id, false);

//Borra las millas correspondientes


$n_miles = $this->Item->Chain->field('miles');

switch($item_type)
{

case 1:
$this->Item->Chain->saveField('miles', $n_miles - 10);
break;

case 2:
$this->Item->Chain->saveField('miles', $n_miles - 20);
break;

case 3:
$this->Item->Chain->saveField('miles', $n_miles - 30);
break;


}


//Comprueba si es el dueño de la cadena (porque el dueño siempre puede si no ha participado, no necesita invitacion)

$own_chain = $this->Item->Chain->field('username');

//Si no es el dueño de la cadena le envia una invitacion para poder usar la cadena otra vez

if($user != $own_chain)
{

$this->data['Invitation']['chain_id'] = $chain_id;
$this->data['Invitation']['username'] = 'Camelidus';
$this->data['Invitation']['guest_name'] = $user;
$this->data['Invitation']['guest_mail'] = $user_mail;
$this->data['Invitation']['pending'] = 1;
$this->data['Invitation']['active'] = 1;

$this->Item->Chain->Invitation->save($this->data);

}

$items_chain = $this->Item->find('all', array('conditions' => array('Item.chain_id' => $chain_id, 'Item.approved' => 1, 'Item.position >' => $position)));

foreach($items_chain as $item)
{
	
	$this->Item->id = $item['Item']['id'];
	$pos = $this->Item->field('position');
	$this->Item->saveField('position', $pos - 1);

}


$this->Session->setFlash('Item eliminado!');

if($role ==1)
{
$this->redirect(array('controller' => 'items', 'action' => 'admin')); 
}

$this->redirect(array('controller' => 'chains', 'action' => 'view', $chain_id)); 

}


function selectType($id = null)
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

$check_id = $this->Item->find('count', array('conditions' => array('Item.approved' => 1, 'Item.id' => $id)));

if($check_id == 0)
{

$this->Session->setFlash('El item que quiere ver no existe');

}

else
{

$this->Item->id = $id;
$chain_id = $this->Item->field('chain_id');
$this->Item->Chain->id = $chain_id;
$n_items = $this->Item->Chain->field('n_items');
$this->set('n_items', $n_items);
$this->set('item', $this->Item->read());
$this->set('id', $id);


//item anterior y siguiente
$position = $this->Item->field('position');

//Si es el ultimo de la cadena

if($n_items == $position){

	$this->set('next_item',$this->Item->find('first', array('conditions' => array('Item.chain_id' => $chain_id, 'Item.position' => 1))));

	$this->set('prev_item',$this->Item->find('first', array('conditions' => array('Item.chain_id' => $chain_id, 'Item.position' => $position - 1))));



}

//Si no es el último de la cadena

else{

	$this->set('next_item',$this->Item->find('first', array('conditions' => array('Item.chain_id' => $chain_id, 'Item.position' => $position + 1))));

//Si es el primero

	if($position == 1)
		{
		
		$this->set('prev_item',$this->Item->find('first', array('conditions' => array('Item.chain_id' => $chain_id, 'Item.position' => $n_items))));
		
		
		}
//Si no es el primero		
	else
	{
	
	$this->set('prev_item',$this->Item->find('first', array('conditions' => array('Item.chain_id' => $chain_id, 'Item.position' => $position - 1))));
	
	}


}


//actualiza hits de item
$n_hits = $this->Item->field('n_hits');
$this->Item->saveField('n_hits', $n_hits + 1);

//lista de comentarios que corresponden a la cadena
$this->set('n_comments', $this->Item->field('n_comments'));
$this->set('comments', $this->Item->Comment->find('all', array('conditions' => array('Comment.approved' => 1, 'Comment.item_id' => $this->Item->id), 'order' => 'Comment.id ASC')));
}

}


}

?>