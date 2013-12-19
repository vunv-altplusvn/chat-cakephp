<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class RoomController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
		// $this->Auth->allow('login', 'register');
	}

	function create() {
		$this->autoRender = false;
		$return = new stdClass;
		$return->status = 200;

		$room = $this->Room->save(array(
			'Room' => array(
				'name' => $this->request->query['name'],
				'created_at' => time(),
				'updated_at' => time(),
				'user_id' => $this->Auth->user()['id'],
			),
		));
		$return->room = $room['Room'];
		echo json_encode($return);
	}

	function all() {
		$this->load('MyModel');
		$result = $this->Room->find('all', array());
		var_dump($result);
	}

	function view() {
		$this->loadModel('Message');
		// var_dump($this->Message->getAll());
		$this->set(array(
			'room' => $this->Room->getById($this->request->params['id']),
			'arrMessage' => $this->Message->getAll(),
		));
	}

	function reload() {
		$this->autoRender = false;
		$this->loadModel('Message');
		
		$roomId = $this->request->query['roomId'];
		$lastUpdate = $this->request->query['lastUpdate'];
		
		$return = new stdClass;
		
		$return->newMessage = $this->Message->getNewMessageByLastUpdate($lastUpdate);
		$return->deletedMessage = $this->Message->getDeletedMessageByLastUpdate($lastUpdate);
		$return->editedMessage = $this->Message->getEditedMessageByLastUpdate($lastUpdate);
		
		$return->hasUpdate = count($return->newMessage) + count($return->deletedMessage) + count($return->editedMessage) > 0 ? true : false;
		$return->userId = $this->Auth->user()['id'];
		$return->lastUpdate = time();

		echo json_encode($return);
	}

	function send() {
		$this->autoRender = false;
		$this->loadModel('Message');
		$return = new stdClass;
		$return->message = $this->Message->save(array(
			'Message' => array(
				'content' => $this->request->query['content'],
				'user_id' => $this->Session->read('Auth.User')['id'],
				'room_id' => $this->request->query['roomId'],
				'created_at' => time(),
				'updated_at' => time(),
			)
		));
		$return->status = 200;
		echo json_encode($return);
	}

	function delete() {
		$this->autoRender = false;
		$this->loadModel('Message');
		$id = $this->request->query['id'];

		$return = new stdClass;
		$return->x = $this->Message->deleteById($id);
		// $return->x = $this->Message->delete($id);
		$return->status = 200;
		echo json_encode($return);
	}

	function edit() {
		$this->loadModel('Message');
		$this->autoRender = false;
		$return = new stdClass;
		$id = $this->request->query['id'];
		$content = $this->request->query['content'];

		$this->Message->save(array(
			'Message' => array(
				'content' => $content,
				'updated_at' => time(),
				'id' => $id,
			)
		));
		$return->status = 200;
		echo json_encode($return);
	}

	function test() {
		$this->loadModel('Message');
		$result = $this->Message->find('all', array(
		    'conditions' => array(
				"Message.updated_at > 1387443356",
				'Message.deleted = 1'
			),
		 //    'fields' => array('Message.*'),
		));
		var_dump($result);die;
	}
}
