<?php


namespace app\Model\Chat;


use app\Model\Database\Database;

class Message {
    /**
     * @var Database $database
     */
    protected $database;
    protected $error_messag;

    public function __construct (Database $database) {
        $this->database     = $database;
        $this->error_messag = ['Ошибка , проблемы с сервером , скоро все заработает ... '];
   }

    public function get ( $room_id,  $message_id) {
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

    public function updateMessage ($id_message, $messages) {
        $this->database->update('messages', ['message' => [$messages]], ['id' => [$id_message]]);
        return ['confirm'];
    }

    public function deletedMessage($id_message) {
        if ( $this->database->deleted('messages', ['id' => $id_message])) {
            return ['confirm'];
        }
         return $this->error_messag;
    }

    public function addMessage ($message,  $room, $user) {
        $colums = ['user_id', 'message', 'room_id'];
        $params = [$user, [$message], $room];
        if ($this->database->insert('messages', $params, $colums)) {
            return ['true'];
        }
        return $this->error_messag;
    }

}