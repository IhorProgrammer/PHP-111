<?php

class UserItem {
    public string $user_id;
    public string $login;
    public string $email;
    public string $avatar;
    public string $salt;
    public string $dk;
    public DateTime $registeredDate;
    public DateTime $deletedDate;



    public static function toUserItem( $userArray ) : ?UserItem {
        $userItem = new UserItem();
        $userItem->user_id = $userArray["user_id"];
        $userItem->login = $userArray["login"];
        $userItem->email = $userArray["email"];
        $userItem->avatar = $userArray["avatar"];
        $userItem->salt = $userArray["salt"];
        $userItem->dk = $userArray["dk"];
        $userItem->registeredDate = new DateTime($userArray["registered_date"]);
        $userItem->deletedDate = new DateTime($userArray["deleted_date"]);
        return $userItem;
    }
}