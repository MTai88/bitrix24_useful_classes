<?php

namespace MTai\Im;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use CIMChat;
use CIMMessenger;
use Bitrix\Im\V2\Chat\ChatFactory;

class ChatService
{
    private CIMChat $chat;
    private int $chatId;

    public function __construct($chatId = 0)
    {
        if (!Loader::IncludeModule('im')) {
            throw new LoaderException("Module im not installed");
        }

        $this->chatId = $chatId;
        $this->chat = new CIMChat;
    }

    public function add(string $title, int $authorId, $type = IM_MESSAGE_OPEN, $description = "", $avatarId = 0, $color = null): bool
    {
        $result = ChatFactory::getInstance()->addChat([
            'TITLE' => $title,
            'TYPE' => $type,
            'AUTHOR_ID' => $authorId,
            'DESCRIPTION' => $description,
            'COLOR' => $color,
            'AVATAR_ID' => $avatarId,
        ]);
        if (!$result->isSuccess() || !$result->hasResult()) {
            $GLOBALS["APPLICATION"]->ThrowException("Error creating chat", "CHAT_ID");
            return false;
        }

        $this->chatId = $result->getResult()['CHAT_ID'];
        return true;
    }

    public function rename(string $newTitle): bool
    {
        return $this->chat->Rename($this->chatId, $newTitle, false, false);
    }

    public function addUser($userId): bool
    {

        return $this->chat->AddUser($this->chatId, $userId);
    }

    public function setOwner($userId): bool
    {
        return $this->chat->SetOwner($this->chatId, $userId, false);
    }

    public function removeUser($userId): bool
    {
        return $this->chat->DeleteUser($this->chatId, $userId, false, false);
    }

    public function addMessage($userId, $message, $system = "N"): bool|int
    {
        return $this->chat::AddMessage([
            "TO_CHAT_ID" => $this->chatId,
            "FROM_USER_ID" => $userId,
            "MESSAGE" => $message,
            "SYSTEM" => $system
        ]);
    }

    public function addPrivateMessage($fromUserId, $toUserId, $message): bool|int
    {
        return CIMMessenger::Add([
            'MESSAGE_TYPE' => IM_MESSAGE_PRIVATE,
            'FROM_USER_ID' => $fromUserId,
            'TO_USER_ID' => $toUserId,
            'MESSAGE' => $message
        ]);
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }
}
