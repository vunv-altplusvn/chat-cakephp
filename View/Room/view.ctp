<h4>Room: <?php echo $room['Room']['name'] ?>, created by <?php echo $room['User']['username'] ?></h4>
<div id="chat-box" >
	<div id="content-box" data-lastupdate="<?php echo time() ?>" data-room="<?php echo $room['Room']['id'] ?>">
		<?php foreach($arrMessage as $message): ?>
			<div class="m" data-id="<?php echo $message['Message']['id'] ?>">
				<p class="content">
					<span><?php echo $message['User']['username'] ?>: </span>
					<input type="text" placeholder="Enter email" value="<?php echo $message['Message']['content'] ?>" readonly >
				</p>
				<p class="meta">
					<?php if($message['Message']['user_id'] === $this->Session->read('Auth.User')['id']): ?>
					<a class="delete-message" href="#">[delete]</a> 
					<a class="edit-message" href="#">[edit]</a>, 
					<?php endif; ?>
					<span><?php echo (new DateTime)->setTimestamp($message['Message']['created_at'])->format('H:i:s, d/m/Y'); ?></span>
					</p>
			</div>
		<?php endforeach; ?>
	</div>
	<div id="send-box">
		<form role="form" id="formSendMessage" method="post">
			<input type="text" id="message" placeholder="Enter Message" autofocus>
			<button type="submit" class="btn btn-default" id="send">Send</button>
		</form>
	</div>
</div>