import "./bootstrap";

import Alpine from "alpinejs";

import Echo from "laravel-echo";

import Pusher from "pusher-js";

import React from "react";
import { createRoot } from "react-dom/client";
import Chat from "./components/Chat";

window.Alpine = Alpine;

Alpine.start();

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

if (document.getElementById("chat-app")) {
    const root = createRoot(document.getElementById("chat-app"));
    root.render(<Chat />);
}
