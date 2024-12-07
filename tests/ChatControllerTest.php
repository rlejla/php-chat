<?php

use PHPUnit\Framework\TestCase;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ServerRequestFactory;

class ChatControllerTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        $this->app = AppFactory::create();

        $this->app->post('/groups', function ($request, $response) {
            $response->getBody()->write(json_encode(['message' => 'Group created']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        });

        $this->app->post('/groups/{id}/messages', function ($request, $response, $args) {
            $response->getBody()->write(json_encode(['message' => 'Message sent', 'content' => $request->getParsedBody()['content']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        $this->app->get('/groups', function ($request, $response) {
            $response->getBody()->write(json_encode([['id' => 1, 'name' => 'Group 1'], ['id' => 2, 'name' => 'Group 2']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        $this->app->get('/users', function ($request, $response) {
            $response->getBody()->write(json_encode([['id' => 1, 'name' => 'Layla'], ['id' => 2, 'name' => 'John']]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });

        $this->app->post('/groups/{id}/join', function ($request, $response, $args) {
            $response->getBody()->write(json_encode(['message' => 'User joined the group']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        });
    }

    public function testCreateGroup()
    {
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', '/groups');
        $response = $this->app->handle($request);

        $this->assertEquals(201, $response->getStatusCode());

        $this->assertStringContainsString('Group created', (string) $response->getBody());
    }

    public function testSendMessage()
    {
        $groupId = 1;
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', "/groups/{$groupId}/messages")
            ->withParsedBody(['content' => 'Hello, world!']);

        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('Message sent', (string) $response->getBody());

        $this->assertStringContainsString('Hello, world!', (string) $response->getBody());
    }

    public function testGetAllGroups()
    {
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('GET', '/groups');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $groups = json_decode((string) $response->getBody(), true);
        $this->assertCount(2, $groups);

        $this->assertEquals('Group 1', $groups[0]['name']);
    }

    public function testGetAllUsers()
    {
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('GET', '/users');
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $users = json_decode((string) $response->getBody(), true);
        $this->assertCount(2, $users);

        $this->assertEquals('Layla', $users[0]['name']);
    }

    public function testJoinGroup()
    {
        $groupId = 1; 
        $requestFactory = new ServerRequestFactory();
        $request = $requestFactory->createServerRequest('POST', "/groups/{$groupId}/join");
        $response = $this->app->handle($request);

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertStringContainsString('User joined the group', (string) $response->getBody());
    }
}
