<?php

namespace app\Model\Chat;
use app\Model\AbstractUserModel;
use app\Model\AccountModel;
use app\Model\Database\Database;
use app\Model\Request\Request;
use app\Model\Response\ResponseModel;

class ChatModel extends AbstractUserModel {
    protected $view_html_chat;
    /**
     * @var Message $message
     */
    protected $message;

    public function __construct (
        Request       $request,
        ResponseModel $response,
        Database      $database,
        AccountModel  $account,
        Message       $message
    )
    {
        $this->message = $message;
        parent::__construct($request, $response, $database, $account);
    }

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

    protected function  userRoomList() {
        return $this->getUserRooms();
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
                return $this->message->get($current_user_room, $message_id);
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

    /**
     * For edit, or update, or deleted user message
     */
    protected function editUserMessage ($request) {
        if ($this->getUserPrivileges() === true) {
            if (isset($request['id_message']) && isset($request['messages'])) {
                if (!empty($request['id_message']) && !empty($request['messages'])) {
                    return $this->message->updateMessage($request['id_message'], $request['messages']);
                }
            }
        }
        return ['Ошибочка, мой юный падаван'];
    }
    protected function deletedUserMessage($request) {
         if ($this->getUserPrivileges() === true) {
             if (isset($request['id_message'])) {
                 if (!empty($request['id_message']) ) {
                     return $this->message->deletedMessage($request['id_message']);
                 }
             }
         }
         return ['Ошибочка, может у тебя нет прав ? '];
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
        $this->view_html_chat = ViewOptions::getViewHTMLData($this->getUserPermission());
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
                    return $this->message->addMessage($message, $id, $this->getUserData('id'));
                } else {
                    return ['У вас не достаточно прав'];
                }
            }
            return ['Ой, ошибочка, попробуйте обновить страницу и попробовать еще ... !'];
        }
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