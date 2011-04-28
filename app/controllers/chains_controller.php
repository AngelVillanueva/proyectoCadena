<?php 

class ChainsController extends AppController {

var $name = 'Chains';
var $components = array('MathCaptcha', 'Attachment' => array('files_dir' => 'chains', 'images_size' => array( 'avatar' => array(263, 263, 'resize') ) ));

var $paginate = array('fields' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.created' , 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments', 'Chain.miles','Chain.denounced', 'Chain.approved', 'Chain.chain_file_path'), 'limit' => 5, 'order' => array('Chain.id' => 'asc'));




function beforeFilter() {
    
     $this->Auth->allow('index', 'view', 'search');
     
     }



function index()
{

$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$user_mail = $this->Session->read('Auth.User.mail');
$this->set('user_mail',$user_mail);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);


$this->Chain->recursive = 0;

$this->paginate = array('conditions' => array('Chain.approved ' => 1));

$data = $this->paginate('Chain');
$this->set(compact('data'));

//array de mas visitadas
$this->set('visited_chains', $this->Chain->find('all',array('conditions' => array('Chain.approved' => 1, 'Chain.n_hits >' => 0),'limit' => 5, 'order' => 'Chain.n_hits DESC')));

//array de mas comentadas
$this->set('comment_chains', $this->Chain->find('all',array('conditions' => array('Chain.approved' => 1, 'Chain.n_comments >' => 0),'limit' => 5, 'order' => 'Chain.n_comments DESC')));

//array de mas votadas
$this->set('voted_chains', $this->Chain->find('all',array('conditions' => array('Chain.approved' => 1, 'Chain.n_votes >' => 0),'limit' => 5, 'order' => 'Chain.n_votes DESC')));

//array de mas votadas
$this->set('item_chains', $this->Chain->find('all',array('conditions' => array('Chain.approved' => 1, 'Chain.n_items >' => 0),'limit' => 5, 'order' => 'Chain.n_items DESC')));

//array de cadenas del usuario
$this->set('user_chains', $this->Chain->find('all',array('conditions' => array('Chain.approved' => 1, 'Chain.user_id' => $user_id),'limit' => 5, 'order' => 'Chain.id ASC')));

//array de cadenas en las que el usuario ha participado
$this->set('join_chains', $this->Chain->Item->find('all', array('conditions' => array('Chain.approved' => 1, 'Item.user_id' => $user_id), 'group by' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'), 'fields' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments'),'limit' => 5, 'order' => 'Chain.id ASC')));

//invitationes pendientes
$this->set('pending', $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1))));

//solicitudes de participacion pendientes
$this->set('request_invitations', $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.username' => $username, 'Invitation.pending' => 1, 'Invitation.active' => 0))));

}



function add()
{

$username = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('username',$username);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);


if (!empty($this->data)) { 

	if($this->MathCaptcha->validates($this->data['Chain']['security_code']))
	{

	
			if(empty($this->data['Chain']['name']) || empty($this->data['Chain']['description'])){
	
				$this->Session->setFlash('Debe rellenar todos los campos!');
	
			}
	
			else
			{
	
	
	
			$this->data['Chain']['user_id'] = $user_id;
			$this->data['Chain']['username'] = $username;
			$this->data['Chain']['approved'] = 1;
			$this->data['Chain']['denounced'] = 0;
	
			$file_path = $this->Attachment->upload($this->data['Chain']);
	
			$this->Chain->save($this->data);
			$id = $this->Chain->getLastInsertId(); 
	
			$this->data['Objetive']['chain_id'] = $id;
			$this->data['Objetive']['miles'] = $this->data['Chain']['next_objetive'];
	
			$this->Chain->Objetive->save($this->data);
	          
			$this->redirect(array('controller' => 'invitations', 'action' => 'add/'.$id));   
			//DEBE ACTIVARSE UN BOTÓN PARA CONTINUAR
	
			}
	
	}
	
	else{
		$this->Session->setFlash(__('Please enter the correct answer to the math question.', true));
	
	}
	

}

	$this->set('mathCaptcha', $this->MathCaptcha->generateEquation());

}

function approve($id = null)

{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);

$this->Chain->id = $id;

$chain_user = $this->Chain->field('username');



$status = $this->Chain->field('approved');

if($status == 0)
{

if($role != 1)
{

$this->Session->setFlash('Solo el Admin puede aprobar cadenas.');
$this->redirect(array('controller' => 'chains', 'action' => 'view'));

}

$this->Chain->saveField('approved', 1);
$this->Session->setFlash('Cadena aprobada');
$this->redirect(array('controller' => 'chains', 'action' => 'admin'));
}
else
{

if($role != 1 && $chain_user != $user)
{

$this->Session->setFlash('Solo el Propietario de la cadena puede eliminarla.');
$this->redirect(array('controller' => 'chains', 'action' => 'view', $id));

}

if($role != 1 && $this->Chain->field('private') != 1)
{
$this->Session->setFlash('No puede borrar una cadena publica');
$this->redirect(array('controller' => 'chains', 'action' => 'view', $id));

}

$this->Chain->saveField('approved', 0);

$this->Session->setFlash('Cadena borrada');

if($role ==1)
{
$this->redirect(array('controller' => 'chains', 'action' => 'admin'));
}
else
{
$this->redirect(array('controller' => 'chains', 'action' => 'index')); 
}


}


}


function commentChains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_comments >' => 0), 'limit' => 10, 'order' => 'Chain.n_comments DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}




function getImage($chain_id = null)
{

if(!empty($chain_id))
{
$this->Chain->id = $chain_id;

$last_item = $this->Chain->Item->find('first', array('conditions' => array('Item.chain_id' => $chain_id), 'order' => 'Item.created DESC'));

$image = $last_item['Item']['item_file_path'];

if(isset($this->params['requested'])) {
	return $image;
}
else {
$this->set('image', $image);
}

}

}

function getPending()
{
	$user_mail = $this->Session->read('Auth.User.mail');
	$pending = $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1)));
if(isset($this->params['requested'])) {
	return $pending;
}
else {
	$this->set('pending', $pending);
}
}

function getRequestInvitations()
{
	$username = $this->Session->read('Auth.User.username');
	$request_invitations = $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.username' => $username, 'Invitation.pending' => 1, 'Invitation.active' => 0)));
if(isset($this->params['requested'])) {
	return $request_invitations;
}
else {
	$this->set('request_invitations', $request_invitations);
}
}



function itemChains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_items >' => 0), 'limit' => 10, 'order' => 'Chain.n_items DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}

function joinChains($account_id = null)
{

$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);


if(empty($account_id))
{
$this->set('tittle', 'Cadenas en las que has participado');
$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Item.user_id LIKE' => $user_id), 'limit' => 10, 'order' => 'Chain.id ASC');
$data = $this->paginate('Item');
$this->set(compact('data'));
}

else
{
$this->Chain->User->id = $account_id;
$account_name = $this->Chain->User->field('username');
$this->set('tittle', 'Cadenas en las que '.$account_name.' ha participado');
$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Item.user_id LIKE' => $account_id), 'limit' => 10, 'order' => 'Chain.id ASC');
$data = $this->paginate('Item');
$this->set(compact('data'));

}

}




function userChains($account_id = null)
{

$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);

if(empty($account_id))
{
$this->set('tittle', 'Tus cadenas');
$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.user_id LIKE' => $user_id), 'limit' => 10, 'order' => 'Chain.id ASC');
$data = $this->paginate('Chain');
$this->set(compact('data'));
}

else
{
$this->Chain->User->id = $account_id;
$account_name = $this->Chain->User->field('username');
$this->set('tittle', 'Cadenas de '.$account_name);
$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.user_id LIKE' => $account_id), 'limit' => 10, 'order' => 'Chain.id ASC');
$data = $this->paginate('Chain');
$this->set(compact('data'));


}


}


function votedChains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_votes >' => 0), 'limit' => 10, 'order' => 'Chain.n_votes DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}

function visitedChains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_hits >' => 0), 'limit' => 10, 'order' => 'Chain.n_hits DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}

function view($id = null)
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$user_mail = $this->Session->read('Auth.User.mail');
$this->set('user_mail',$user_mail);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_mail',$user_id);

$user_role = $this->Session->read('Auth.User.role');

$this->Chain->id = $id;
$this->set('chain', $this->Chain->read());
$this->set('id', $id);

//cadena privada?
$private = $this->Chain->field('private');
$this->set('private', $private);

//cadena restricted?
$restricted = $this->Chain->field('restricted');
$this->set('restricted', $restricted);

$repeat = $this->Chain->field('repeat');


//Comprueba si el usuario ya ha participado en la cadena

$this->set('check_joins', $this->Chain->Item->find('count',  array('conditions' => array('Item.chain_id' => $this->Chain->id, 'Item.username' => $username))));

//Comprueba si el usuario es el creador
$check_own = $this->Chain->field('username');
$this->set('check_own',$check_own);

//Comprueba si esta cadena es una de sus favoritas

$check_fav = $this->Chain->User->Favorite->find('count', array('conditions' => array('Favorite.user_id' => $user_id, 'Favorite.fav_id' => $id, 'Favorite.type' => 1)));
$this->set('check_fav', $check_fav);

// Si la cadena permite repetición

switch($repeat)
	{
	
	case 0:
	$this->set('check_repeat', 0);
	break;
	
	
	case 1:
	//Se comprueba si el usuario ha puesto el ultimo item...
	
	$last_item = $this->Chain->Item->find('first', array('order' => array('Item.created DESC')));
		if($last_item['Item']['username'] == $username)
			{
			
			$this->set('check_repeat', 0);
			
			}
		else
			{
			$this->set('check_repeat', 1);
			
			}
	break;
	
	}



//Si la cadena es privada

switch($private)
	{
	
	case 0:
	//es public
		//Comprueba si tiene invitacion para participar
		$check_invitation = $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.chain_id' => $this->Chain->id, 'Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1)));
		$this->set('check_invitation', $check_invitation);
		
	break;
	
	case 1:
	//es private
		
		//Comprueba si el usuario tiene invitacion para participar
		$check_invitation = $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.chain_id' => $this->Chain->id, 'Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1)));
		$this->set('check_invitation', $check_invitation);
		
		//Comprueba si es uno de los participantes
		$check_player = $this->Chain->Item->find('count',  array('conditions' => array('Item.chain_id' => $this->Chain->id, 'Item.username' => $username)));
		
		
		
		//Si no tiene invitacion, no es uno de los participantes, no es el creador y no es admin, prohibe la entrada
		if($check_invitation == 0 && $check_player == 0 && $check_own != $username && $user_role != 1)
			{
			$this->Session->setFlash('Esta cadena es privada, no puedes ver su contenido->'.$check_player);
			$this->redirect(array('controller' => 'chains', 'action' => 'index'));
			}
		
	break;
	
	}
	
switch ($restricted)
	{
	
	case 0:
	//es open
		//Todos pueden participar
		$this->set('check_invitation', 1);
	break;
	
	case 1:
	//es restricted
		//Comprueba si el usuario tiene invitacion
		$this->set('check_invitation', $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.chain_id' => $this->Chain->id, 'Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1))));
		
		//Comprueba si el usuario ha solicitado unirse a esta cadena
		$this->set('check_request', $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.chain_id' => $this->Chain->id, 'Invitation.guest_mail' => $user_mail, 'Invitation.active' => 0))));
		
	break;
	
	}
	

	

//actualiza hits de cadena
$n_hits = $this->Chain->field('n_hits');
$this->Chain->saveField('n_hits', $n_hits + 1);

//lista de items que corresponden a la cadena
$this->set('n_items', $this->Chain->field('n_items'));
$this->set('items', $this->Chain->Item->find('all', array('conditions' => array('Item.approved' => 1, 'Item.chain_id' => $this->Chain->id), 'order' => 'Item.id ASC')));

//lista de metas que corresponden a la cadena
$this->set('objetives', $this->Chain->Objetive->find('all', array('conditions' => array('Objetive.chain_id' => $this->Chain->id), 'order' => 'Objetive.miles ASC')));

//lista de comentarios que corresponden a la cadena
$this->set('n_comments', $this->Chain->field('n_comments'));
$this->set('comments', $this->Chain->Comment->find('all', array('conditions' => array('Comment.approved' => 1, 'Comment.chain_id' => $this->Chain->id), 'order' => 'Comment.id ASC')));




}









}


?>