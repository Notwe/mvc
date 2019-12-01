<?php
namespace app\Model\Chat;

class ViewOptionsChat {

    public static function getViewHTMLData($permission) {
        foreach ($permission as $id_role => $name_role) {
            if ($name_role == 'Administrator' ?? $name_role == 'Moderator') {
                return ["
			<div class='user_box'>
				<div class='user_name'>data.name</div>
				<div class='add_message_time'>data.add_time</div>
					<ul class='hide_menu'>
						<li class='deleted_message' onclick='return deleteMessage(&quot;data.id&quot;)'><a href='#'>Удалить</a></li>
						<li class='edit_message'onclick='return editMessage(&apos;data.id&apos;, &apos;data.message&apos;)'><a href='#'>Редактировать</a></li>
					</ul>
			</div>
			<div class='user_message'>data.message</div>
		"];
            }
        }
        return ["
			<div class='user_box'>
				<div class='user_name'>data.name</div>
				<div class='add_message_time'>data.add_time</div>
			</div>
			<div class='user_message'>data.message</div>
			
		"];
    }
}