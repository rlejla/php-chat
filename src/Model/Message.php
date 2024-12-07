<?php
namespace App\Model;

class Message
{
    public $id;
    public $group_id;
    public $user_id;
    public $content;
    public $timestamp;

    public function __construct($id, $group_id, $user_id, $content, $timestamp)
    {
        $this->id = $id;
        $this->group_id = $group_id;
        $this->user_id = $user_id;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }
}
