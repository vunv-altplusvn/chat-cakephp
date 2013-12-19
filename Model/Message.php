<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class Message extends AppModel {
	public $useTable = 'message';

	public function getAll() {
		return $this->find('all', array(
		    'joins' => array(
		        array(
		            'table' => 'users as User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'Message.user_id = User.id'
		            )
		        )
		    ),
		    'conditions' => array(
                'Message.deleted = 0',
            ),
		    'fields' => array('Message.*', 'User.username'),
		
		));
	}

	public function getNewMessageByLastUpdate($lastUpdate) {
		$data = $this->find('all', array(
		    'joins' => array(
		        array(
		            'table' => 'users as User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'Message.user_id = User.id'
		            )
		        )
		    ),
		    'conditions' => array(
				"Message.created_at > $lastUpdate",
				'Message.deleted = 0'
			),
		    'fields' => array('Message.*', 'User.username'),

		));

		foreach ($data as &$message) {
			$message['Message']['created_at'] = (new DateTime)->setTimestamp($message['Message']['created_at'])->format('H:i:s, d/m/Y');
		}
		
		return $data;
	}

	public function getDeletedMessageByLastUpdate($lastUpdate) {
		$result = $this->find('all', array(
		    'conditions' => array(
				"Message.updated_at > $lastUpdate",
				'Message.deleted = 1'
			),
		    'fields' => array('Message.id'),
		));
		$data = array();
		foreach ($result as $message) {
			$data[] = $message['Message']['id'];
		}
		
		return $data;
	}

	public function getEditedMessageByLastUpdate($lastUpdate) {
		$data = $this->find('all', array(
		    'conditions' => array(
				"Message.updated_at > $lastUpdate",
				'Message.deleted = 0'
			),
		    'fields' => array('Message.id', 'Message.content', 'Message.updated_at'),
		));

		foreach ($data as &$message) {
			$message['Message']['updated_at'] = 'Edited at ' .  (new DateTime)->setTimestamp($message['Message']['updated_at'])->format('H:i:s, d/m/Y');
		}

		return $data;
	}

	public function deleteById($id) {
		$this->save(array(
			'Message' => array(
				'deleted' => 1,
				'updated_at' => time(),
				'id' => $id,
			)
		));
	}
}
