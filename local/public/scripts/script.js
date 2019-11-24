


//autorise
// $( document ).ready(function() {
//     $("#user_login").click(
// 		function(){
// 			let action_for_data = function (){window.location.reload()};
// 			send_Form('user_login', 'login.php', action_for_data);
// 			return false;
// 		}
// 	);
// });
///send_Form
function send_Form(name_form, page, action, param){
	let rooms = '';
	if(param){
		rooms = param;
	}
	if(name_form){
		$.ajax ({
			url: '/chat/function/page/ajax/'+page,
			type: 'POST',
			data: $("."+name_form).serialize()+"&id="+rooms,
			success: function (data) {
				if(!data){
					$(action);
				}
				$('#error_message > li').remove();
				if(data){
					data = jQuery.parseJSON(data);
					if(data.length > 0){
						for (var i = 0; i < data.length; i++){
							$("#error_message").append(
							"<li>"+data[i]+"</li>"
							);

						}
					}
				}
			}
		});
	}

}
//send_message
$(function() {
    $(".button_send_message").click(
		function(){
			let param = $('.user_send_message').attr('id');
			let action_for_data = function (){$('.user_send_message').val('');};
			send_Form('user_send_message', 'message.php', action_for_data, param);
			return false;
		}
	);
});

//room list
$(document).ready(function() {
	$.ajax({
            url: '/main',
            type: 'POST',
			data: {'room_list':''},
            success: function (data) {
			    for (var i = 0; i < data.length; i++){
					$(".public_room_list").append(
					"<div class='room_list'><a href='#" + data[i].name_room + "' onclick='return confirmRoom(&quot;" + data[i].name_room + "&quot;,&quot; " + data[i].room_id + "&quot;)';>" + data[i].name_room + "</a></div>");
				}
			}
	});
});

function confirmRoom(name_room, room_id){
	if (confirm("Ты точно хочешь в чат " + name_room + "?")) {
		$('.user_send_message').val('')
		let message_id = '';
		$('#message_box > div').remove();
		$('.user_send_message').attr('id', 'room_' + $.trim(room_id) );
		clearTimeout(timer);
		get_chat_message($.trim(room_id), message_id)
	}
	else {
		return false;
	}
}
///////////

$(function(){
	if(current_room){
		let message_id = '';
		$('.user_send_message').attr('id', 'room_' + $.trim(current_room) );
		clearTimeout(timer);
		get_chat_message(current_room, message_id);
	}
});

let timer;
function update_message(room_id ,message_id){
	timer = setTimeout(function (){
		get_chat_message(room_id, message_id);
	}, 3000);
}

function get_chat_message(room_id, message_id){
	if(room_id){
		$.ajax({
            url: '/chat/function/page/ajax/message.php',
            type: 'POST',
			data: {
				"getRoomMessages":room_id,
				"message_id":message_id,
			},
            success: function (data) {
                if(data){
					data = jQuery.parseJSON(data);
					if($(".user_name").length >= 50){
						var removeblock = function(){
							$('#message_box > div:nth-child(-n+4)').remove();
						}
					}
						let block = getUserViewParam();
						for (var i = 0; i < data.length; i++){
							let user_block = block.replace(/data.id/g, data[i].id).replace(/data.name/g, data[i].name).replace(/data.message/g, data[i].message).replace(/data.add_time/g, data[i].add_time);//.replace(/\r/g,"<br>");.replace(/\r/g,"<br>");
		                    $(removeblock);
							last_message_id = data[data.length -1].id;
							$("#message_box").append(user_block);
						};
					$(".message_box").animate({ scrollTop: (7000) }, "fast");
				}
				update_message(room_id, last_message_id);
            }
        });
	}

};


function getUserViewParam(){
	var returnParam = '';
	$.ajax({
		    async: false,
            url: '/chat/function/page/ajax/permission.php',
            type: 'POST',
			data:{get_user_view:''},
            success: function (data) {
				data = jQuery.parseJSON(data);
	            returnParam = data;
				return returnParam;
		}

	});
	return returnParam;
}
////message_del_edit_function

function confirmdelete(message_id) {
	if (confirm("Вы подтверждаете удаление?")) {
		let action_for_data = function (){window.location.reload()};
		send_edit('delete.php', action_for_data, message_id)

	}
	else {
		return false;
	}
}
function edit_message(message_id, message) {
	let edit = prompt("Сообщение", message);
	if(edit){
		if(edit != null ){
			let action_for_data = function (){window.location.reload()};
			send_edit('edit.php', action_for_data, message_id, edit)
		}
	}
	else {
		return false;
	}
}




function send_edit(page, action, param, message){
	if(!message){
		message = '';
	}
	if(param){
		$.ajax ({
			url: '/chat/function/page/ajax/'+page,
			type: 'POST',
			data: {
				'id':param,
				'messages':message,
				},
			success: function (data) {
				if(!data){
					$(action);
				}
				$('#error_message > li').remove();
				if(data){
					data = jQuery.parseJSON(data);
					if(data.length > 0){
						for (var i = 0; i < data.length; i++){
							$("#error_message").append(
							"<li>"+data[i]+"</li>"
							);

						}
					}
				}
			}
		});
	}

}
