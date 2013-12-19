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
class UsersController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login', 'register');
	}

	function login() {
		if ($this->isLoggedIn()) return $this->redirect('/');
		if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	            return $this->redirect($this->Auth->redirect());
	        }
	        $this->Session->setFlash('Invalid username or password, try again', 'default', array(), 'login');
	    }
	}

	function logout() {
		return $this->redirect($this->Auth->logout());
	}

	function register() {
		if ($this->isLoggedIn()) return $this->redirect('/');
		if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Register successfully, please login!', 'default', array(), 'register');
                return $this->redirect(array('action' => 'login'));
            }
            $this->Session->setFlash('The user has been saved', 'default', array(), 'register');
        }
	}
}
