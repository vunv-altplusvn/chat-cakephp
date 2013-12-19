<?php
	echo $this->Form->create('User', array('class' => 'form-signin', 'type' => 'POST', 'role'=>'form'));
	echo '<h2 class="form-signin-heading">Please sign in</h2>';
	if($message = $this->Session->flash('register')) echo '<div class="alert alert-success">' . $message .'</div>';
	if($message = $this->Session->flash('login')) echo '<div class="alert alert-danger">' . $message .'</div>';
	echo $this->Form->input('username', array('class' => 'form-control first', 'placeholder' => 'Username', 'label' => false, 'required', 'autofocus'));
	echo $this->Form->input('password', array('class' => 'form-control last', 'placeholder' => 'Password', 'label' => false, 'required'));
	echo '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>';
	echo $this->Form->end();
?>
