<?php
use Slim\Factory\AppFactory;
use App\Controller\ChatController;

$app = AppFactory::create();

$app->post('/users', [ChatController::class, 'createUser']);

$app->post('/groups', [ChatController::class, 'createGroup']);
$app->get('/groups', [ChatController::class, 'getAllGroups']);

$app->post('/groups/{id}/join', [ChatController::class, 'joinGroup']);
$app->post('/groups/{id}/leave', [ChatController::class, 'leaveGroup']);

$app->post('/groups/{id}/messages', [ChatController::class, 'sendMessage']);
$app->get('/groups/{id}/messages', [ChatController::class, 'getMessages']);

return $app;
