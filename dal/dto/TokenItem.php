<?php 
class TokenItem {
    public $token_id = "";
    public $user_id = "";
    public $tokenExpires;

    public static function toTokenItem( $tokenArray ) : ?TokenItem {
        $tokenItem = new TokenItem();
        $tokenItem->token_id = $tokenArray["token_id"];
        $tokenItem->user_id = $tokenArray["user_id"];
        $tokenItem->tokenExpires = new DateTime($tokenArray["token_expires"]);
        return $tokenItem;
    }
}