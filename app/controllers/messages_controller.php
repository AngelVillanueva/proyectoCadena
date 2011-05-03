<?php 

class MessagesController extends AppController {

var $name = 'Messages';

var $paginate = array('fields' => array('From.username', 'Message.user_id', 'Message.subject', 'Message.text','Message.created', 'Message.read', 'Message.deleted'), 'limit' => 5, 'order' => array('Message.created' => 'desc'));

function beforeFilter(){

}

function index()
{}

function delete($message_id = null)

{

$this->Message->id = $message_id;
$this->Message->saveField('deleted', 1);

$this->Session->setFlash('Mensaje borrado');
$this->redirect(array('controller' => 'messages', 'action' => 'inbox')); 

}


function inbox()
{

$username = $this->Session->read('Auth.User.username');
$user_id = $this->Session->read('Auth.User.id');

$this->set('username', $username);


$this->paginate = array( 'conditions' => array('Message.receiver_id' => $user_id), 'limit' => 5,'group' => 'Message.conv_id', 'order' => 'Message.created DESC');
$data = $this->paginate('Message');
$this->set(compact('data'));



}

function read($receiver_id = null, $conv_id = null)
{
$username = $this->Session->read('Auth.User.username');
$user_id = $this->Session->read('Auth.User.id');

$this->set('username', $username);

$this->set('user_id', $user_id);
$this->set('from_id', $receiver_id);
$this->set('conv_id', $conv_id);


//Marcar como leidos los mensajes
$messages = $this->Message->find('all', array('conditions' => array('Message.conv_id' => $conv_id, 'Message.receiver_id' => $user_id)));

foreach($messages as $message)
{

$this->Message->id = $message['Message']['id'];
$this->Message->saveField('read', 1);

}

$this->paginate = array('conditions' => array('Message.conv_id' => $conv_id), 'limit' => 10, 'order' => 'Message.created ASC');
$data = $this->paginate('Message');
$this->set(compact('data'));

}








function sendbox()
{

$username = $this->Session->read('Auth.User.username');
$user_id = $this->Session->read('Auth.User.id');

$this->set('username', $username);


$this->paginate = array('conditions' => array('Message.user_id' => $user_id), 'limit' => 5, 'order' => 'Message.created DESC');
$data = $this->paginate('Message');
$this->set(compact('data'));



}




function write($receiver_id = null, $conv_id = null)
{

$username = $this->Session->read('Auth.User.username');
$this->set('username', $username);

$user_id = $this->Session->read('Auth.User.id');

$this->set('user_id', $user_id);
$this->set('receiver_id', $receiver_id);

$this->Message->id = $conv_id;
$subject = $this->Message->field('subject');

$this->Message->Receiver->id = $receiver_id;
$receiver_username = $this->Message->Receiver->field('username');
$this->set('receiver_username', $receiver_username);

if(!empty($this->data))
{

if(!empty($subject))
{

$this->data['Message']['subject'] = $subject;

}

if($this->Message->save($this->data))
{



if(empty($conv_id))
{
$message_id = $this->Message->id;
$this->Message->saveField('conv_id', $message_id);
}
else
{

$this->Message->saveField('conv_id', $conv_id);
}

$this->Session->setFlash('Mensaje enviado');

}

else
{

$this->Session->setFlash('El mensaje no se ha podido enviar');

}

$this->redirect(array('controller' => 'messages', 'action' => 'inbox')); 

}



}




}

?>