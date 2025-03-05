import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/soal/create.jsx",
                "resources/js/room-ujian/tes.jsx"
            ],
            refresh: true,
        }),
        react(),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        assetsDir: "assets",
    },
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
});
