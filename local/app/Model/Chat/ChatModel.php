<?php

namespace app\Model\Chat;
use app\Model\AbstractUserModel;

class ChatModel extends AbstractUserModel {
    protected $view_html_chat;
    /**
     * @return array|bool|void
     * TODO Еще в проэкте , работает, не разделил еще.
     * This class to get room message for user
     */
    public function chatValidation () {
        $request = $this->request->getPost();

        if (empty($this->getUserData())) {
            return false;
        }
        if (isset($request['get_message'])) {
            return $this->getRoomMessages($request);
        }
        if (isset($request['room_list'])) {
            return $this->userRoomList();
        }
        if (isset($request['edit_message'])) {
            return $this->editUserMessage($request);
        }
        if (isset($request['deleted_message'])) {
            return $this->deletedUserMessage($request);
        }
        if (isset($request['view_param'])) {
            return $this->viewPrivileges();
        }
        if (isset($request['get_last_user_room'])) {
            return $this->lastUserRoom();
        }
        if (isset($request['add_message'])) {
            return $this->insertMessage($request);
        }

        return false;

    }

    protected function getRoomMessages($request) {
        if (isset($request['room_id'])) {
            $room_id = $request['room_id'];
            if(!empty($request['message_id'])) {
                $message_id = $request['message_id'];
            } else {
                $message_id = '';
            }
            if ($permission = $this->roomAccess($room_id) === true) {
                $current_user_room = $this->prepareRoomId($room_id);
                return $this->getMessage($current_user_room, $message_id);
            }
        }
        return ['Ошибка! у вас нет дуступа для просмотра этого чата'];
    }

    protected function roomAccess($id) {
        foreach ($this->getUserRooms() as $rooms) {
            if ($rooms['room_id'] === $id) {
                $this->request->setCookie(['room'=>$rooms['room_id']], 300);
                return true;
            }
        }
        return false;
    }



    protected function  userRoomList() {
        return $this->getUserRooms();
    }

    protected function getMessage ( $room_id,  $message_id) {
        if (!empty($room_id)) {
            $select = ['user.name, messages.id, message, add_time'];
            $join   =
                ['JOIN' => ['user', 'messages.user_id' => 'user.id', 'messages.room_id' => [$room_id]],
                'WHERE' => ['WHERE messages.id > ' => [$message_id]],
                 'ORDER' => ['BY' => 'messages.id'], 'LIMIT' => ['DESC' => '50']
            ];
            $message_data = [];
            $data = $this->database->select('messages', $join, $select);
            while($message = $this->database->fetch_assoc($data)){
                $message['message'] = htmlspecialchars($message['message'], ENT_QUOTES);
                $message_data[] = $message;
            }
            $message_data = array_reverse($message_data);
            if (!empty($message_data)) {
                return $message_data;
            }
            return ['empty'];
        }
        return false;

    }

    /**
     * For edit, or update, or deleted user message
     */
    protected function editUserMessage ($request) {
        if ($this->getUserPrivileges() === true) {
            if (isset($request['id_message']) && isset($request['messages'])) {
                if (!empty($request['id_message']) && !empty($request['messages'])) {
                    $id_message = $request['id_message'];
                    $messages = $request['messages'];
                    $this->database->update('messages', ['message' => [$messages]], ['id' => [$id_message]]);
                    return ['confirm'];
                }
            }
        }
        return ['Ошибочка, мой юный падаван'];
    }
    protected function deletedUserMessage($request) {
         if ($this->getUserPrivileges() === true) {
             if (isset($request['id_message'])) {
                 if (!empty($request['id_message']) ) {
                     $id = $request['id_message'];
                     $this->database->deleted('messages', ['id' => $id]);
                     return ['confirm'];
                 }
             }
         }
         return false;
    }

    protected function lastUserRoom() {
           if (!empty($last_room = $this->request->getCookie('room'))) {
               if($this->roomAccess($last_room) === true ) {
                   return [$last_room];
               }
           }
        return ['empty'];
    }

    /**
     * this view params for user
     * where privilege :
     * User
     * Administrator
     * Moderator
     */
    protected function viewPrivileges () {
        $this->view_html_chat = ViewOptionsChat::getViewHTMLData($this->getUserPermission());
        return $this->view_html_chat;
    }

    protected function prepareRoomId ($id) {
        if (!empty($id)) {
            foreach ($this->getUserRooms(true) as $room) {
                if (hash('crc32', $room['room_id']) === $id) {
                    return $room['room_id'];
                }
            }
        }
        return false;
    }

    protected function insertMessage($request) {

        if (isset($request['add_message']) && !empty($request['add_message'])) {
            if (!empty($request['room_id'])) {
                if ($this->roomAccess($request['room_id']) === true) {
                    $id = $this->prepareRoomId($request['room_id']);
                    $message = $request['add_message'];
                    return $this->addMessage($message, $id, $this->getUserData('id'));
                } else {
                    return ['У вас не достаточно прав'];
                }
            }
            return ['Ой, ошибочка, попробуйте обновить страницу и попробовать еще ... !'];
        }
    }

    protected function addMessage ($message,  $room, $user) {
        $colums = ['user_id', 'message', 'room_id'];
        $params = [$user, [$message], $room];
        $this->database->insert('messages', $params, $colums);
        return ['true'];
    }

    protected function getUserPrivileges() {
        foreach ($permission = $this->getUserPermission() as $id_role => $name_role) {
            if ($name_role == 'Administrator' ?? $name_role == 'Moderator') {
                return true;
            }

        }
        return false;
    }


}