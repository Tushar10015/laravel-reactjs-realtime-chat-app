# Laravel & React Real-Time Chat Application

This is a simple real-time chat application built with **Laravel** and **React**. It leverages **WebSockets** for real-time communication using **Pusher** and **Laravel Echo**.

## Features

-   Real-time messaging using WebSockets
-   Laravel backend for broadcasting events
-   React frontend for listening to events and displaying messages

## Requirements

-   PHP 8.x
-   Composer
-   Node.js and npm
-   Laravel 10.x
-   React
-   Pusher account (for WebSockets)

## Installation

### Backend (Laravel)

1. Clone the repository:

    ```bash
    git clone https://github.com/your-username/laravel-react-chat.git
    ```

2. Navigate to the project directory:

    ```bash
    cd laravel-react-chat
    ```

3. Install PHP dependencies:

    ```bash
    composer install
    ```

4. Set up your environment variables by copying the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

5. Set your Pusher credentials in the `.env` file:

    ```env
    BROADCAST_DRIVER=pusher
    PUSHER_APP_ID=your-app-id
    PUSHER_APP_KEY=your-app-key
    PUSHER_APP_SECRET=your-app-secret
    PUSHER_APP_CLUSTER=mt1
    ```

6. Generate an application key:

    ```bash
    php artisan key:generate
    ```

7. Install Pusher PHP SDK:

    ```bash
    composer require pusher/pusher-php-server
    ```

8. Clear and cache the configuration:

    ```bash
    php artisan config:clear
    php artisan config:cache
    ```

9. Run the Laravel development server:
    ```bash
    php artisan serve
    ```

### Frontend (React)

1. Navigate to the React frontend directory (if it's in a separate folder):

    ```bash
    cd frontend
    ```

2. Install JavaScript dependencies:

    ```bash
    npm install
    ```

3. Set your Pusher credentials in the React `.env` file:

    ```env
    REACT_APP_PUSHER_APP_KEY=your-app-key
    REACT_APP_PUSHER_APP_CLUSTER=your-cluster
    ```

4. Run the React development server:
    ```bash
    npm start
    ```

### Database Migration (Optional)

If you have a database for this project, run the migrations:

```bash
php artisan migrate
```

````

## Usage

1. Start both the Laravel and React servers.
2. Navigate to the Laravel route `/send-message` in your browser to broadcast a message:
    ```
    http://localhost:8000/send-message
    ```
    This will send a message to the `chat` channel.
3. Open your React app in a different tab (default URL: `http://localhost:3000`). The message should appear in real-time in the message list.

## Testing the Application

1. Open two browser windows: one for the Laravel `/send-message` route and one for the React frontend.
2. When a message is sent from the Laravel route, it will be broadcast in real-time and displayed in the React app.

## Project Structure

-   **Laravel Backend (API and Broadcasting)**

    -   Handles event broadcasting
    -   Uses Pusher as the WebSocket service
    -   `/send-message` route triggers a broadcast event

-   **React Frontend**
    -   Listens to the `MessageSent` event using Laravel Echo
    -   Displays messages in real-time

## Example Code

### Laravel Event: `MessageSent`

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
```

### React Component

```jsx
import React, { useEffect, useState } from "react";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

const Chat = () => {
    const [messages, setMessages] = useState([]);

    useEffect(() => {
        window.Pusher = Pusher;

        const echo = new Echo({
            broadcaster: "pusher",
            key: process.env.REACT_APP_PUSHER_APP_KEY,
            cluster: process.env.REACT_APP_PUSHER_APP_CLUSTER,
            forceTLS: true,
        });

        echo.channel("chat").listen("MessageSent", (e) => {
            setMessages((prevMessages) => [...prevMessages, e.message]);
        });

        return () => {
            echo.disconnect();
        };
    }, []);

    return (
        <div>
            <h2>Messages</h2>
            <ul>
                {messages.map((msg, index) => (
                    <li key={index}>{msg}</li>
                ))}
            </ul>
        </div>
    );
};

export default Chat;
```

## Troubleshooting

### Common Issues

1. **BindingResolutionException**: Ensure that the `BroadcastServiceProvider` is correctly registered in `config/app.php`.
2. **WebSocket connection issues**: Check the Pusher debug console to verify that events are being broadcast correctly.
3. **CORS issues**: Ensure that CORS is properly configured in Laravel to allow the React frontend to make requests.

### Useful Commands

-   Clear cache:
    ```bash
    php artisan config:clear
    php artisan cache:clear
    ```
-   Run the Laravel server:
    ```bash
    php artisan serve
    ```
-   Run the React app:
    ```bash
    npm start
    ```
````
