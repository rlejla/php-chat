<?php
namespace App\Model;

class User
{
    public $id;
    public $username;
    public $token;

    public function __construct($id, $username, $token)
    {
        $this->id = $id;
        $this->username = $username;
        $this->token = $token;
    }
}
