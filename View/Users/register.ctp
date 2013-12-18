<div class="container">
	<?php 	
	echo $this->Form->create('User', array('class' => 'form-signin', 'type' => 'POST', 'role'=>'form'));
	echo '<h2 class="form-signin-heading">Please register</h2>';
	echo $this->Form->input('username', array('class' => 'form-control first', 'placeholder' => 'Username', 'label' => false, 'required', 'autofocus'));
	echo $this->Form->input('password', array('class' => 'form-control ', 'placeholder' => 'Password', 'label' => false, 'required'));
	echo $this->Form->input('email', array('class' => 'form-control last', 'placeholder' => 'Email', 'label' => false, 'required'));
	echo '<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>';
	echo $this->Form->end();
	?>
</div> <!-- /container -->