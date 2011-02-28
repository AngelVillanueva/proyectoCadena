<?php 

class InvitationsController extends AppController {

var $name = 'Invitations';
var $components = array('Email');

var $paginate = array('fields' => array('Invitation.id', 'Invitation.chain_id', 'Invitation.username'), 'limit' => 5, 'order' => array('Invitation.id' => 'asc'));


function beforeFilter(){

}

function index()
{}

function add($chain_id = null)
{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);
$this->set('chain_id', $chain_id);


if (!empty($this->data)) {
	
	if(empty($this->data['Invitation']['guest_name']) || empty($this->data['Invitation']['guest_mail'])){
	
	$this->Session->setFlash('Debe rellenar todos los campos!');
	
	}
	
	else
	{
	$user = $this->data['Invitation']['user'];
	$chain_id = $this->data['Invitation']['chain_id'];
	
	
	
	//Se guardan los datos de la invitacion
	$this->Invitation->save($this->data);  
	$id = $this->Invitation->id;
	$this->redirect(array('controller' => 'invitations', 'action' => 'send/'.$id));        
	//DEBE ACTIVARSE UN BOTÓN PARA CONTINUAR
	}
	


}

}





function send($invitation_id = null)
{

$this->Invitation->id = $invitation_id;

//Para enviar mails
$this->Email->from = 'invitaciones@cadenas.com';
$this->Email->to = $this->Invitation->field('guest_mail');
$id = $this->Invitation->field('chain_id');
$this->Email->subject = 'Prueba invitacion cadena';
$this->Email->send('Prueba invitacion --> http://sinapsescopio.es/proyectoCadena/chains/view/'.$id);
$this->Session->setFlash('Invitación enviada!');
$this->redirect(array('controller' => 'chains', 'action' => 'view/'.$id)); 

}


function view()
{
$user = $this->Session->read('Auth.User.username');
$user_mail = $this->Session->read('Auth.User.mail');

$pending = $this->Invitation->find('all', array('conditions' => array('Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1)));
$this->set('pending', $pending);

$this->paginate = array('conditions' => array('Invitation.pending' => 1, 'Invitation.guest_mail' => $user_mail), 'limit' => 10, 'order' => 'Invitation.id DESC');
$data = $this->paginate('Invitation');
$this->set(compact('data'));

}

}

?>