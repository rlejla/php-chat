<?php

namespace App\Controller;

use App\Database\Database;

class ChatController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createGroup($request, $response, $args)
    {
        $body = $request->getBody();
        $data = json_decode($body, true);
        $name = $data['name'];

        $stmt = $this->db->getPdo()->prepare("INSERT INTO groups (name) VALUES (?)");
        $stmt->execute([$name]);

        $response->getBody()->write(json_encode(['message' => 'Group created']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    }

    public function getAllGroups($request, $response, $args)
    {
        $stmt = $this->db->getPdo()->prepare("SELECT * FROM groups");
        $stmt->execute();
        $groups = $stmt->fetchAll();

        if (count($groups) > 0) {
            $response->getBody()->write(json_encode(['groups' => $groups]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['groups' => []]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }
    public function joinGroup($request, $response, $args)
    {
        $groupId = $args['id'];
        $userToken = $request->getHeaderLine('Authorization'); 

        $stmt = $this->db->getPdo()->prepare("INSERT INTO group_users (group_id, user_token) VALUES (?, ?)");
        $stmt->execute([$groupId, $userToken]);

        $response->getBody()->write(json_encode(['message' => 'User joined the group']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function leaveGroup($request, $response, $args)
    {
        $groupId = $args['id'];
        $userToken = $request->getHeaderLine('Authorization');

        $stmt = $this->db->getPdo()->prepare("DELETE FROM group_users WHERE group_id = ? AND user_token = ?");
        $stmt->execute([$groupId, $userToken]);

        if ($stmt->rowCount() > 0) {
            $response->getBody()->write(json_encode(['message' => 'User left the group']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['error' => 'User not in group or group does not exist']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public function sendMessage($request, $response, $args)
    {
        $groupId = $args['id'];
        $body = $request->getBody();
        $data = json_decode($body, true);
        $userToken = $request->getHeaderLine('Authorization');
        $content = $data['content'];

        $stmt = $this->db->getPdo()->prepare("INSERT INTO messages (group_id, user_token, content) VALUES (?, ?, ?)");
        $stmt->execute([$groupId, $userToken, $content]);

        $response->getBody()->write(json_encode(['message' => 'Message sent']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getMessages($request, $response, $args)
    {
        $groupId = $args['id'];

        $stmt = $this->db->getPdo()->prepare("SELECT * FROM messages WHERE group_id = ?");
        $stmt->execute([$groupId]);
        $messages = $stmt->fetchAll();

        $response->getBody()->write(json_encode(['messages' => $messages]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
}
