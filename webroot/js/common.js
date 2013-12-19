$(document).ready(function () {

	// create new room
	formCreateRoom = $('#formCreateRoom');
	roomName = $('#roomName');
    createRoomMessage = $('#createRoomMessage');
    listRoom = $('#listRoom');
	formCreateRoom.submit(function (event) {
		event.preventDefault();
		var name = roomName.val();
		$.ajax({
			type: "GET",
			url: "/room/create",
			dataType: "JSON",
			data: { 
				name: roomName.val(),
			},
		}).done(function( data ) {
            if (data.status == 200) {
                listRoom.append('<a href="/room/' + data.room.id + '" class="list-group-item">' + data.room.name + '</a>');
                roomName.val('');
                createRoomMessage.fadeIn('fast').delay(3000).fadeOut('slow');
            }
		}).fail(function( jqXHR, textStatus ) {
			console.log("Request failed: " + textStatus );
		});
	});


	contentBox = $('#content-box');
	formSendMessage = $('#formSendMessage');
	inputSendMessage = $('#message');

	// send message
	formSendMessage.submit(function (event) {
		event.preventDefault();
		// console.log('send message:');
		$.ajax({
			type: "GET",
			url: "/room/send",
			dataType: "JSON",
			data: { 
				roomId: contentBox.data('room'),
				content: inputSendMessage.val(),
			},
		}).done(function( data ) {
			if (data.status ==  200){
				inputSendMessage.val('');
			}
		}).fail(function( jqXHR, textStatus ) {
			console.log("Request failed: " + textStatus );
		});
	}); 


	//reload
	setInterval(function() {
		$.ajax({
			type: "GET",
			url: "/room/reload",
			dataType: "JSON",
			data: { 
				lastUpdate: contentBox.data('lastupdate'),
				roomId: contentBox.data('room'),
			},
		}).done(function( data ) {
			// console.log('last update: ' + data.lastUpdate);
			console.log(data);
			if (data.hasUpdate) {
				contentBox.data('lastupdate', data.lastUpdate);
				// new message
				newMessage = data.newMessage;
				// console.log(newMessage);

				for(var i=0; i < newMessage.length; i++) {
					var m = newMessage[i];
					var mHtml = '';
					mHtml += '<div class="m" data-id="' + m.Message.id + '">';
					mHtml += '<p class="content"><span>' + m.User.username + ': </span><input type="text" placeholder="Enter email" value="' + m.Message.content + '" readonly ></p>';
					if(m.Message.user_id == data.userId) {
						mHtml += '<p class="meta"><a href="#" class="delete-message">[delete]</a> <a href="#" class="edit-message">[edit]</a>, <span>' + m.Message.created_at + '</span></p>';
					} else {
						mHtml += '<p class="meta"><span>' + m.Message.created_at + '</span></p>';
					}
					mHtml += '</div>';
					contentBox.append(mHtml);
				}

				$('div.m input[type=text]').pressEnter(function () {
					editMessage($(this));
				});

				// deleted message
				deletedMessage = data.deletedMessage;
				for(var i = 0; i <deletedMessage.length; i++) {
					$('div.m[data-id=' + deletedMessage[i] + ']').remove();
				}

				// edited message
				editedMessage = data.editedMessage;
				// console.log(editedMessage);
				for(var i = 0; i < editedMessage.length; i++) {
					var m = editedMessage[i];
					// console.log(m);
					// console.log($('div.m[data-id=' + m.Message.id + ']'));
					$('div.m[data-id=' + m.Message.id + ']').find('input[type=text]').first().val(m.Message.content);
					$('div.m[data-id=' + m.Message.id + ']').find('p.meta span').first().text(m.Message.updated_at);
				}
			}
			contentBox.scrollTop(contentBox[0].scrollHeight);
		}).fail(function( jqXHR, textStatus ) {
			console.log("Request failed: " + textStatus );
		});
	}, 1000);

	// edit message
	$(document).on('click', '.edit-message', function (event) {
		event.preventDefault();
		console.log('edit message');
		$(this).parent().parent().find('input[type=text]').first().removeAttr('readonly').addClass('active').focus();
	});

	// delete message
	$(document).on('click', '.delete-message', function (event) {
		console.log('delete');
		event.preventDefault();
		deleteMessage($(this));
	});

	$('div.m input[type=text]').pressEnter(function () {
		editMessage($(this));
	});
});

function deleteMessage(aDelete) {
	// alert('delete message');
	// console.log('delete message');
	var messageId = aDelete.parent().parent().data('id');
	console.log('id: ' + messageId);
	$.ajax({
		type: "GET",
		url: "/room/delete",
		dataType: "JSON",
		data: { 
			id: messageId,
		},
	}).done(function( data ) {
		console.log(data);
	}).fail(function( jqXHR, textStatus ) {
		console.log("Request failed: " + textStatus );
	});
}

function editMessage(inputEdit) {
	console.log('save content: ' + inputEdit.val());
	var m = inputEdit.parent().parent(),
		messageId = m.data('id');
	$.ajax({
		type: "GET",
		url: "/room/edit",
		dataType: "JSON",
		data: { 
			id: messageId,
			content: inputEdit.val(),
		},
	}).done(function( data ) {
		// console.log(data);
		inputEdit.attr('readonly', 'readonly');
		inputEdit.removeClass('active');
	}).fail(function( jqXHR, textStatus ) {
		console.log("Request failed: " + textStatus );
	});
}

$.fn.pressEnter = function (fn) {
	return this.each(function() {  
        $(this).bind('enterPress', fn);
        $(this).keyup(function(e){
            if (e.keyCode == 13) {
              $(this).trigger("enterPress");
            }
        })
    });  
};