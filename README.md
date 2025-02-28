# PHP Chat Application

This is a backend implementation for a simple chat application built in PHP using the Slim Framework. It allows users to:

- Create chat groups
- Join groups
- Leave chat groups
- Send and list messages within groups

## Project Structure

- **`src/`**: Main application logic (controllers, routes...).
- **`tests/`**: Tests for the application.
- Other settings and configurations can be found in the root directory.

## Installation

1. Clone the repository from
   `https://github.com/rlejla/php-chat.git`

2.  Install dependencies:
   `composer install`

3.  Run the application - The application will run on `localhost` and listen for requests on port 8080 by default.

## API Endpoints Examples
--------------------------

You can use `curl` to interact with the APIs:

-   **Create a new user:**

    `curl -X POST http://localhost:8080/users -H "Content-Type: application/json" -d '{"username": "bunq"}'`

-   **Create a new group:**

    `curl -X POST http://localhost:8080/groups -H "Content-Type: application/json" -d '{"name": "Fintech"}'`

-   **Join a group:**

   `curl -X POST http://localhost:8080/groups/1/join -H "Authorization: Bearer b943de5972490e7d4cee02509f6764bc" -H "Content-Type: application/json"`

-   **Leave a group:**

    `curl -X POST http://localhost:8080/groups/1/leave -H "Authorization: Bearer b943de5972490e7d4cee02509f6764bc" -H "Content-Type: application/json"`

-   **Send a message:**

    `curl -X POST http://localhost:8080/groups/1/messages\
        -H "Authorization: Bearer b943de5972490e7d4cee02509f6764bc"\
        -H "Content-Type: application/json"\
        -d '{"content": "Hello, this is Layla!"}'`

-   **Get messages in a group:**

    `curl -X GET http://localhost:8080/groups/1/messages -H "Authorization: Bearer b943de5972490e7d4cee02509f6764bc"`

## Running Tests

To run the unit tests:

`vendor/bin/phpunit tests/ChatControllerTest.php`
