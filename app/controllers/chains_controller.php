<?php 

class ChainsController extends AppController {

var $name = 'Chains';
var $components = array('MathCaptcha');

var $paginate = array('fields' => array('Chain.id', 'Chain.name','Chain.user_id', 'Chain.username', 'Chain.created' , 'Chain.n_items', 'Chain.n_hits', 'Chain.n_votes', 'Chain.n_comments', 'Chain.miles', 'Objetive.miles','Chain.denounced', 'Chain.approved'), 'limit' => 5, 'order' => array('Chain.id' => 'asc'));




function beforeFilter() {
    
     $this->Auth->allow('index', 'view');
     
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
$this->set('pending', $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1))));

}



function add()
{

$username = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('username',$username);

$user_id = $this->Session->read('Auth.User.id');
$this->set('user_id',$user_id);


if (!empty($this->data)) { 

	
	if(empty($this->data['Chain']['name']) || empty($this->data['Chain']['description'])){
	
	$this->Session->setFlash('Debe rellenar todos los campos!');
	
	}
	
	else
	{
	
	
	
	$this->data['Chain']['user_id'] = $user_id;
	$this->data['Chain']['username'] = $username;
	$this->data['Chain']['approved'] = 1;
	$this->data['Chain']['denounced'] = 0;
	
	
	$this->Chain->save($this->data);
	$id = $this->Chain->id; 
	
	$this->data['Objetive']['chain_id'] = $id;
	$this->data['Objetive']['miles'] = $this->data['Chain']['next_objetive'];
	
	$this->Chain->Objetive->save($this->data);
	          
	$this->redirect(array('controller' => 'invitations', 'action' => 'add/'.$id));   
	//DEBE ACTIVARSE UN BOTÓN PARA CONTINUAR
	
	
	
	
	

	
	}
	


}

}

function approve($id = null)

{

$user = $this->Session->read('Auth.User.username');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);

$this->Chain->id = $id;

if($role != 1)
{

$this->Session->setFlash('Solo el Admin puede aprobar cadenas.');
$this->redirect(array('controller' => 'chains', 'action' => 'view'));

}

$status = $this->Chain->field('approved');

if($status == 0)
{
$this->Chain->saveField('approved', 1);
$this->Session->setFlash('Cadena aprobada');
$this->redirect(array('controller' => 'chains', 'action' => 'admin'));
}
else
{
$this->Chain->saveField('approved', 0);
$this->Session->setFlash('Cadena desaprobada');
$this->redirect(array('controller' => 'chains', 'action' => 'admin'));
}


}







function comment_chains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_comments >' => 0), 'limit' => 10, 'order' => 'Chain.n_comments DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}

function denounce($id = null)
{

$this->Chain->id = $id;

$this->Chain->saveField('denounced', 1);
$this->Session->setFlash('Cadena Denunciada, En breve revisaremos su contenido...');
$this->redirect(array('controller' => 'chains', 'action' => 'view', $id));

}






function item_chains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_items >' => 0), 'limit' => 10, 'order' => 'Chain.n_items DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}

function join_chains($account_id = null)
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



function user_chains($account_id = null)
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


function voted_chains()
{
$username = $this->Session->read('Auth.User.username');
$this->set('username',$username);

$this->paginate = array('conditions' => array('Chain.approved' => 1, 'Chain.n_votes >' => 0), 'limit' => 10, 'order' => 'Chain.n_votes DESC');
$data = $this->paginate('Chain');
$this->set(compact('data'));

}

function visited_chains()
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

$this->Chain->id = $id;
$this->set('chain', $this->Chain->read());
$this->set('id', $id);

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

//invitationes pendientes
$this->set('check_invitation', $this->Chain->Invitation->find('count', array('conditions' => array('Invitation.chain_id' => $this->Chain->id, 'Invitation.guest_mail' => $user_mail, 'Invitation.pending' => 1))));


}









}


?>