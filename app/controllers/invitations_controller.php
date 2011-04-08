<?php 

class InvitationsController extends AppController {

var $name = 'Invitations';
var $components = array('Email');

var $paginate = array('fields' => array('Invitation.id', 'Invitation.chain_id', 'Invitation.username', 'Invitation.guest_name', 'Invitation.guest_mail', 'Invitation.created', 'Invitation.pending', 'Invitation.active'), 'limit' => 5, 'order' => array('Invitation.id' => 'asc'));


function beforeFilter(){

}

function index()
{}

function active($invitation_id = null)
{

$user = $this->Session->read('Auth.User.username');
$this->set('user',$user);



if(!empty($invitation_id))

{

$this->Invitation->id = $invitation_id;

$invitation_user = $this->Invitation->field('username');

if($invitation_user != $user)
{

$this->Session->setFlash('No puedes aprobar esta solicitud');
$this->redirect(array('controller' => 'invitations', 'action' => 'view_request'));

}

$this->Invitation->saveField('active', 1);
$this->Session->setFlash('Solicitud aprobada');

}

$this->redirect(array('controller' => 'invitations', 'action' => 'view_request'));


}

function add($chain_id = null)
{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);
$this->set('chain_id', $chain_id);

$sent_invitations = 0;

if (!empty($this->data)) {

			$chain_id = $this->data['Invitation'][0]['chain_id'];


			for($i=0;$i<count($this->data['Invitation']);$i++)
			{
			
			if(!empty($this->data['Invitation'][$i]['guest_mail']))
			{
			
			$this->Invitation->save($this->data['Invitation'][$i]); 
			
			$id = $this->Invitation->getLastInsertId();
			
			$this->Email->smtpOptions = array(
				'port' => '25',
				'timeout' => '30',
				'host' => 'smtp.1and1.es',
				'username' => 'tests@sinapsescopio.es',
				'password' => 'key1and11971');
			
			//método de entrega
			$this->Email->delivery = 'smtp';
			
			//Para enviar mails
			$this->Email->from = 'tests@sinapsescopio.es';
			$this->Email->to = $this->Invitation->field('guest_mail');
			$chain_id = $this->Invitation->field('chain_id');
			$this->Email->subject = 'Prueba invitacion cadena';
			$this->Email->send();
			$this->Email->reset();
			
			$sent_invitations++;
			
			}
			
			}
			$this->Session->setFlash('Invitaciones enviadas!-> '.$sent_invitations);
			$this->redirect(array('controller' => 'chains', 'action' => 'view/'.$chain_id));
	
	
		
	
	}
	
	
	
	




}

function delete($invitation_id)

{

$role = $this->Session->read('Auth.User.role');


if(!empty($invitation_id))

{


$this->Invitation->delete($invitation_id, false);



}

if($role == 1)
{
$this->redirect(array('controller' => 'invitations', 'action' => 'admin'));

}



}

function request($chain_id = null)
{

$user = $this->Session->read('Auth.User.username');
$user_mail = $this->Session->read('Auth.User.mail');

if (!empty($chain_id)) {

	$this->Invitation->Chain->id = $chain_id;

	$chain_user = $this->Invitation->Chain->field('username');

	$this->data['Invitation']['username'] = $chain_user;
	$this->data['Invitation']['guest_name'] = $user;
	$this->data['Invitation']['guest_mail'] = $user_mail;
	$this->data['Invitation']['chain_id'] = $chain_id;
	$this->data['Invitation']['pending'] = 1;
	$this->data['Invitation']['active'] = 0;

	$this->Invitation->save($this->data);
	$this->Session->setFlash('Se ha enviado la solicitud');
	$this->redirect(array('controller' => 'chains', 'action' => 'view/'.$chain_id));
}

}



function view()
{
$user = $this->Session->read('Auth.User.username');
$user_mail = $this->Session->read('Auth.User.mail');

$pending = $this->Invitation->find('all', array('conditions' => array('Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1, 'Invitation.active' => 1)));
$this->set('pending', $pending);

$this->paginate = array('conditions' => array('Invitation.pending' => 1, 'Invitation.active' => 1, 'Invitation.guest_mail' => $user_mail), 'limit' => 10, 'order' => 'Invitation.id DESC');
$data = $this->paginate('Invitation');
$this->set(compact('data'));

}

function view_request()
{
$user = $this->Session->read('Auth.User.username');
$user_mail = $this->Session->read('Auth.User.mail');

$pending = $this->Invitation->find('all', array('conditions' => array('Invitation.username' => $user, 'Invitation.pending' => 1, 'Invitation.active' => 0)));
$this->set('pending', $pending);

$this->paginate = array('conditions' => array('Invitation.pending' => 1, 'Invitation.username' => $user, 'Invitation.active' => 0), 'limit' => 10, 'order' => 'Invitation.id DESC');
$data = $this->paginate('Invitation');
$this->set(compact('data'));

}

}

?>