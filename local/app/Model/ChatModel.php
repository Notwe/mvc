<?php


namespace app\Model;


class ChatModel extends AbstractUserModel {
    /**
     * @return array|bool|void
     *Еще в проэкте , работает криво , либо не работает...
     * This function to identify the parameters of POST request
     */
    public function chatValidation () {
        $request = $this->request->getPost();

        if ($this->userCookieVerification() ===false) {
            //TODO временно для теста, удалится
            return false;
        }
        if (isset($request['get_room_messages'])) {
            return $this->getRoomMessages($request);
        }
        if (isset($request['room_list'])) {
            return $this->userRoomList();
        }
        if (isset($request['edit_message'])) {
            return $this->editUserMessage($request);
        }
        if (isset($request['view_param'])) {
            return $this->viewForPrivileges();
        }
        if (isset($request['get_last_user_room'])) {
            return $this->lastUserRoom();
        }

        return false;

    }

    protected function getRoomMessages($request) {
        if (isset($request['get_room_messages'])) {
            $room_id = $request['get_room_messages'];
            if(!empty($request['message_id'])) {
                $message_id = $request['message_id'];
            } else {
                $message_id = '';
            }
            if ($permission = $this->roomAccess($room_id) === true) {
                return $this->getMessage($room_id, $message_id);
            }
        }
        return ['Ошибка! у вас нет дуступа для просмотра этого чата'];
    }

    protected function roomAccess($id) {
        foreach ($this->user_rooms as $room) {
            if ($room['room_id'] == $id) {
                return true;
            }
        }
        return false;
    }



    protected function  userRoomList() {
        return $this->user_rooms;
    }

    protected function getMessage (int $room_id,  $message_id) {
        if (!empty($room_id)) {
            $select = ['user.name, messages.id, message, add_time'];
            $join   = ['JOIN' => ['user', 'messages.user_id' => 'user.id', 'messages.room_id' => [$room_id]],
                'WHERE' => ['WHERE messages.id > ' => [$message_id]]
            ];
            $message_data = [];
            while($message = $this->database->fetch_array($this->database->select('messages', $join, $select))){
                $message_data[] = $message;
            }
            $message_data = array_reverse($message_data);
            return $message_data;
        }
        return false;

    }

    /**
     * For edit, or update, or deleted user message
     */
    protected function editUserMessage () {

    }

    protected function lastUserRoom() {

    }

    /**
     * this view params for user
     * where privilege
     * User
     * Administrator
     * Moderator
     */
    protected function viewForPrivileges () {

    }
}