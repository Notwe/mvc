<?php


namespace app\Model;
use app\Model\Chat\ChatModel;
use app\Model\Chat\ViewOptionsChat;
use app\Model\Request\Request;

class AjaxValidation {
    /**
     * @var Request $request
     * @return bool|string
     *
     */

    /**
     * @var AuthorizeModel $authorize
     */
    protected $authorize;

    /**
     * @var RegisterModel $register
     */
    protected $register;

    /**
     * @var ChatModel $chat
     */
    protected $chat;

    public function __construct
        (
            AuthorizeModel $authorize,
            RegisterModel $register,
            ChatModel $chat
        ) {
        $this->authorize = $authorize;
        $this->register  = $register;
        $this->chat      = $chat;

    }

    public function ajaxHandle(Request $request) {
        $data = $request->getGet();
        if (isset($data['authorize'])) {
            return $this->authorize->userAuthorize();
        }

        if (isset($data['register'])) {
            return $this->register->registerUser();
        }

        if (isset($data['chat'])) {
            return $this->chat->chatValidation();
        }

        return false;
    }

}