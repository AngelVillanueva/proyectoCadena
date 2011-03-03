<?php 

class FavoritesController extends AppController {

var $name = 'Favorites';
var $components = array('Email');




function beforeFilter(){

}

function index()
{}

function add($fav_id = null, $type = null)
{

$user = $this->Session->read('Auth.User.username');
$user_id = $this->Session->read('Auth.User.id');
$role = $this->Session->read('Auth.User.role');
$this->set('user',$user);
$this->set('id', $id);





	$check_favorite = $this->Favorite->find('count', array('conditions' => array('Favorite.fav_id' => $id)));
	
	if($check_favorite == 0)
	
	{
	$this->data['Favorite']['fav_id'] = $fav_id;
	$this->data['Favorite']['user_id'] = $user_id;
	$this->data['Favorite']['type'] = $type;
	
	$this->Favorite->save($this->data);
	$this->Session->setFlash('Añadido a favoritos!');
	}
	
	
	

	
	
$this->redirect(array('controller' => 'users', 'action' => 'account/'.$user));	

}


function view()
{
$user = $this->Session->read('Auth.User.username');
$user_id = $this->Session->read('Auth.User.user_id');
$user_mail = $this->Session->read('Auth.User.mail');

$fav_users = $this->Favorite->find('all', array('conditions' => array('Favorite.type' => 0, 'Favorite.user_id' => $user_id)));
$this->set('fav_users', $fav_users);

$fav_chains = $this->Favorite->find('all', array('conditions' => array('Favorite.type' => 1, 'Favorite.user_id' => $user_id)));
$this->set('fav_chains', $fav_chains);



}

}

?>