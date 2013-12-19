<div class="jumbotron" style="margin-top:20px;">
    <?php if($this->Session->read('Auth.User')): ?>
    <h2>Hello, <?php echo $this->Session->read('Auth.User')['username']; ?> </h2>
    
    <form class="form" role="form" id="formCreateRoom" method="get">
        <div class="form-group">
            <input type="text" class="form-control" id="roomName" placeholder="Enter room's name" required>
        </div>
        <button type="submit" class="btn btn-success">Create new room</button>
    </form>
    <?php else: ?>
    <p class="lead">Hi, login or register to chatting</p>
    <?php endif; ?>
</div>
<div id="createRoomMessage" style="display: none;">
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Well done!</strong> You successfully create new room.
    </div>    
</div>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">All rooms</div>
    <div class="panel-body">
    </div>
    <!-- List group -->
    <div class="list-group" id="listRoom">
        <?php foreach($arrRoom as $room): ?>
        <a href="<?php echo Router::url('/room/' . $room['Room']['id']) ?>" class="list-group-item">
            <?php echo $room['Room']['name'] ?>
            <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true" title="Delete this room">&times;</button> -->
        </a>
        <?php endforeach; ?>
    </div>
</div>
