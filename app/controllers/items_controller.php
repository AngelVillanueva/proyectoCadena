<?php 

class ItemsController extends AppController {

var $name = 'Items';
var $components = array('MathCaptcha', 'Attachment' => array('files_dir' => 'items', 'images_size' => array( 'avatar' => array(263, 263, 'resize') ) ));
var $helpers = array('Youtube', 'Vimeo');

var $paginate = array('fields' => array('Item.id', 'Item.name','Item.user_id', 'Item.chain_id','Item.type', 'Item.username', 'Item.position', 'Item.n_hits', 'Item.n_votes', 'Item.n_comments', 'Item.item_file_path', 'Item.item_file_size','Item.denounced', 'Item.approved'), 'limit' => 5, 'order' => array('Item.id' => 'asc'));


function beforeFilter(){

 $this->Auth->allow('view', 'search', 'selectLang');
 
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
				$chain_id = $this->data['Item']['chain_id'];
		

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
				$this->data['Item']['slug'] = $this->Item->createSlug($this->data['Item']['name']);
	
	//Comprobaciones según el tipo de item que se añade
				switch($item_type)
					{
				
					case 1:
					$item_miles = 10;
					break;
				
					case 2:
					$item_miles = 20;
					
					$file_path = $this->Attachment->upload($this->data['Item']);
					
					
					break;
				
					case 3:
					$item_miles = 30;
					
					$url = $this->data['Item']['link'];
					$parse_url = parse_url( $url );
					
					
						switch($parse_url['host']){
						
							case 'www.youtube.com':
							case 'youtube.com':
							$this->data['Item']['host'] = $parse_url['host'];
							parse_str($parse_url['query'], $query);
							$video_id = ($query['v']);
							$this->data['Item']['vid'] = $video_id;
							
							$thumb = sprintf('http://img.youtube.com/vi/%s/%s.jpg', $video_id, 'default');
							
							//guardar imagen en servidor
							
								$img_file = file_get_contents($thumb); 
							
							    $image_path = parse_url($thumb); 
							    $img_path_parts = pathinfo($image_path['path']); 
							     
							    $filename = $video_id.'.'.$img_path_parts['extension'];
							
								$this->data['Item']['item_file_path'] = $filename;
							
							    $path = 'attachments/items/avatar/'; 
							    $filex = $path . $filename; 
							    $fh = fopen($filex, 'w'); 
							    fputs($fh, $img_file); 
							    fclose($fh); 
							
							
							break;
							
							case 'www.vimeo.com':
							case 'vimeo.com':
							$this->data['Item']['host'] = $parse_url['host'];
							$this->data['Item']['vid'] = $parse_url['path'];
							$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video'.$parse_url['path'].'.php'));
							
							//guardar imagen en servidor
							
								$thumb = $hash[0]['thumbnail_medium']; 
							
								$img_file = file_get_contents($thumb); 
							
							    $image_path = parse_url($thumb); 
							    $img_path_parts = pathinfo($image_path['path']); 
							     
							    $filename = $img_path_parts['basename'];
							
								$this->data['Item']['item_file_path'] = $filename;
							
							    $path = 'attachments/items/avatar/'; 
							    $filex = $path . $filename; 
							    $fh = fopen($filex, 'w'); 
							    fputs($fh, $img_file); 
							    fclose($fh); 
							    
							  
							
							
							
							break;
							
							default:
							$this->Session->setFlash('Solo se admiten videos de Youtube y Vimeo');
							$this->redirect(array('controller' => 'items', 'action' => 'add/'.$chain_id.'/'.$item_type));
							break;
						
						}
					
					
					
					break;
				
				
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
			
				$this->Item->Chain->saveField('miles', $n_miles + $item_miles);
				
				//Si la meta se ha alcanzado
				
				$next_objetive = $this->Item->Chain->field('next_objetive');
				
				if($this->Item->Chain->field('miles') >= $next_objetive)
				{
				
				$objetive = $this->Item->Chain->Objetive->find('first', array('conditions' => array('Objetive.chain_id' => $chain_id, 'Objetive.miles' => $next_objetive)));
				
				$this->Item->Chain->Objetive->id = $objetive['Objetive']['id'];
				$this->Item->Chain->Objetive->saveField('complete', 1);
				
				//AQUI HABRIA QUE PONER LA PARTE QUE CAMBIA LA META (CAMBIAR NEXT_OBJETIVE DE CHAIN AL NUEVO VALOR Y CREAR UN NUEVO OBJETIVO).
				
				//Ahora mismo al pasar una meta se añaden 100 millas mas como nuevo objetivo, creando un objetivo en la bbdd.
				
				$this->Item->Chain->saveField('next_objetive', $next_objetive + 100);
				
				$this->data['Objetive']['id'] = '';
				$this->data['Objetive']['chain_id'] = $chain_id;
				$this->data['Objetive']['miles'] = $next_objetive + 100;
				
				
				$this->Item->Chain->Objetive->save($this->data);
				
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
$miles = 10;
break;

case 2:
$miles = 20;
break;

case 3:
$miles = 30;
break;


}

//Se restan las millas por borrar el item

$this->Item->Chain->saveField('miles', $n_miles - $miles);

//Ultima meta alcanzada

$last_objetive_complete = $this->Item->Chain->Objetive->find('first', array('conditions' => array('Objetive.chain_id' => $chain_id, 'Objetive.complete' => 1), 'order' => 'Objetive.created DESC'));

$last_objetive_created = $this->Item->Chain->Objetive->find('first', array('conditions' => array('Objetive.chain_id' => $chain_id, 'Objetive.complete' => 0), 'order' => 'Objetive.created DESC'));

$last_objetive_id = $last_objetive_complete['Objetive']['id'];
$last_objetive_created_id = $last_objetive_created['Objetive']['id'];

$last_miles_complete = $last_objetive_complete['Objetive']['miles'];

//Si con este item vuelve a la meta anterior se vuelve a poner Objetive.compete a 0, y Chain.next_objevite a la meta anterior.

if($last_miles_complete <= ($this->Item->Chain->field('miles') + $miles))

{


$this->Item->Chain->Objetive->id = $last_objetive_id;

$this->Item->Chain->Objetive->saveField('complete', 0);
$this->Item->Chain->saveField('next_objetive', $last_miles_complete);

//Se borra la meta creada cuando se añadió el item

$this->Item->Chain->Objetive->delete($last_objetive_created_id);

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

function view($slug = null) 
{

// REDIRECCIONAR A UNA PAGINA DE ERROR ????

$check_slug = $this->Item->find('count', array('conditions' => array('Item.approved' => 1, 'Item.slug' => $slug)));

if($check_slug == 0)
{

$this->Session->setFlash('El item que quiere ver no existe');
$this->cakeError('error404');

}

else
{

$item = $this->Item->findBySlug($slug);

$id = $item['Item']['id'];

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