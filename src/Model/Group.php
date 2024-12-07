<?php
namespace App\Model;

class Group
{
    public $id;
    public $name;
    public $users = [];

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function addUser($user)
    {
        $this->users[] = $user;
    }
}
