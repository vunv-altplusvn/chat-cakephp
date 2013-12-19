<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
		echo $this->Html->css('/plugins/bootstrap/css/bootstrap.min');
		//echo $this->Html->css('/plugins/bootstrap/css/bootstrap-theme.min');
		echo $this->Html->css('style');
		echo $this->Html->script('jquery-2.0.3.min');
		echo $this->Html->script('/plugins/bootstrap/js/bootstrap.min');
		echo $this->Html->script('common');
	?>
</head>
<body>
	<div class="wrapper">
		<div class="header">
	        <ul class="nav nav-pills pull-right">
				<li <?php if($this->action == 'index') echo 'class="active"';?>><a href="<?php echo Router::url('/', true) ?>">Home</a></li>
				<?php if(!$this->Session->read('Auth.User')): ?>
				<li <?php if($this->action == 'register') echo 'class="active"';?>><a href="<?php echo Router::url('/register', true) ?>">Register</a></li>
				<li <?php if($this->action == 'login') echo 'class="active"';?>><a href="<?php echo Router::url('/login', true) ?>">Login</a></li>
				<?php else: ?>
				<li><a href="<?php echo Router::url('/logout', true) ?>">Logout</a></li>
				<?php endif; ?>
	        </ul>
	        <h3 class="text-muted">Chat System</h3>
      	</div>
		<?php echo $this->fetch('content'); ?>
		</div> <!-- /container -->
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
