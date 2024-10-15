import React, { useState, useEffect } from "react";
import axios from "axios";

export default function Chat() {
    const [messages, setMessages] = useState([]);
    const [message, setMessage] = useState("");

    useEffect(() => {
        // Fetch initial messages from the server
        axios
            .get("/api/messages")
            .then((response) => setMessages(response.data));

        // Listen for new messages using Echo
        window.Echo.channel("chat").listen("MessageSent", (e) => {
            alert("New message received!");
            setMessages([...messages, e.message]);
        });
    }, [messages]);

    const sendMessage = async (e) => {
        e.preventDefault();

        await axios.post("/api/messages", {
            message_content: message,
        });

        setMessage("");
    };

    return (
        <div>
            <ul>
                {messages.map((msg, index) => (
                    <li key={index}>
                        {msg.user.name}: {msg.message_content}
                    </li>
                ))}
            </ul>
            <form onSubmit={sendMessage}>
                <input
                    type="text"
                    value={message}
                    onChange={(e) => setMessage(e.target.value)}
                    placeholder="Type your message..."
                />
                <button type="submit">Send</button>
            </form>
        </div>
    );
}
