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
class Room extends AppModel {
	public $useTable = 'room';

	public function getAllRoom() {
		return $this->find('all', array());
	}

	public function getById($id) {
		return $this->find('first', array(
		    'joins' => array(
		        array(
		            'table' => 'users as User',
		            'type' => 'INNER',
		            'conditions' => array(
		                'Room.user_id = User.id'
		            )
		        )
		    ),
		    'conditions' => array(
		        'Room.id' => $id
		    ),
		    'fields' => array('Room.*', 'User.username'),
		));		
	}
}
