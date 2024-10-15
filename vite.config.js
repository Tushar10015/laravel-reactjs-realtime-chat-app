import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
        react(),
    ],
    esbuild: {
        loader: "jsx", // Set the loader for .js files to 'jsx'
        // If you want to specify loaders for specific file types, do it like this:
        // loader: {
        //     '.js': 'jsx', // This is not needed if you set the loader globally
        // },
    },
});
